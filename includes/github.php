<?php
/**
 * Small helper library for talking to the GitHub REST API,
 * with a simple file-based cache so we don't hammer the API
 * (and don't die when it's unreachable or rate-limited).
 */

require_once __DIR__ . '/config.php';

function gh_cache_path(string $key): string {
    return CACHE_DIR . '/' . preg_replace('/[^a-z0-9_\-]/i', '_', $key) . '.json';
}

function gh_cache_get(string $key) {
    $path = gh_cache_path($key);
    if (is_file($path) && (time() - filemtime($path)) < CACHE_TTL) {
        $raw = @file_get_contents($path);
        if ($raw !== false) {
            $data = json_decode($raw, true);
            if ($data !== null) return $data;
        }
    }
    return null;
}

function gh_cache_set(string $key, $data): void {
    @file_put_contents(gh_cache_path($key), json_encode($data));
}

/**
 * Fetch stale cache regardless of TTL — used as a fallback when
 * a live request fails, so the site degrades gracefully instead
 * of showing nothing.
 */
function gh_cache_get_stale(string $key) {
    $path = gh_cache_path($key);
    if (is_file($path)) {
        $raw = @file_get_contents($path);
        if ($raw !== false) {
            $data = json_decode($raw, true);
            if ($data !== null) return $data;
        }
    }
    return null;
}

function gh_request(string $url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 8,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_HTTPHEADER => [
            'User-Agent: ' . GITHUB_USER . '-site',
            'Accept: application/vnd.github+json',
            'X-GitHub-Api-Version: 2022-11-28',
        ],
    ]);
    $body = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($body === false || $status < 200 || $status >= 300) {
        return null;
    }
    $data = json_decode($body, true);
    return $data;
}

/**
 * Returns the user's public, non-fork repos sorted by last push,
 * each annotated with its latest commit.
 */
function gh_get_repos(int $limit = 12): array {
    $cacheKey = 'repos_' . GITHUB_USER;
    $cached = gh_cache_get($cacheKey);
    if ($cached !== null) return $cached;

    $repos = gh_request('https://api.github.com/users/' . urlencode(GITHUB_USER) . '/repos?per_page=100&sort=pushed&type=owner');

    if (!is_array($repos)) {
        $stale = gh_cache_get_stale($cacheKey);
        return $stale !== null ? $stale : [];
    }

    // Drop forks, keep the freshest N
    $repos = array_values(array_filter($repos, fn($r) => empty($r['fork'])));
    usort($repos, fn($a, $b) => strtotime($b['pushed_at']) <=> strtotime($a['pushed_at']));
    $repos = array_slice($repos, 0, $limit);

    $result = [];
    foreach ($repos as $r) {
        $commit = gh_get_latest_commit($r['name']);
        $result[] = [
            'name' => $r['name'],
            'full_name' => $r['full_name'],
            'description' => $r['description'],
            'url' => $r['html_url'],
            'language' => $r['language'],
            'stars' => $r['stargazers_count'],
            'forks' => $r['forks_count'],
            'pushed_at' => $r['pushed_at'],
            'archived' => $r['archived'],
            'topics' => $r['topics'] ?? [],
            'commit' => $commit,
        ];
    }

    gh_cache_set($cacheKey, $result);
    return $result;
}

function gh_get_latest_commit(string $repo) {
    $cacheKey = 'commit_' . GITHUB_USER . '_' . $repo;
    $cached = gh_cache_get($cacheKey);
    if ($cached !== null) return $cached;

    $commits = gh_request('https://api.github.com/repos/' . urlencode(GITHUB_USER) . '/' . urlencode($repo) . '/commits?per_page=1');

    if (!is_array($commits) || empty($commits[0])) {
        $stale = gh_cache_get_stale($cacheKey);
        return $stale;
    }

    $c = $commits[0];
    $result = [
        'sha' => substr($c['sha'], 0, 7),
        'message' => explode("\n", trim($c['commit']['message']))[0],
        'date' => $c['commit']['author']['date'] ?? null,
        'url' => $c['html_url'],
        'author' => $c['commit']['author']['name'] ?? null,
    ];

    gh_cache_set($cacheKey, $result);
    return $result;
}

/**
 * Basic profile info (avatar, bio, follower count, etc.)
 */
function gh_get_profile() {
    $cacheKey = 'profile_' . GITHUB_USER;
    $cached = gh_cache_get($cacheKey);
    if ($cached !== null) return $cached;

    $data = gh_request('https://api.github.com/users/' . urlencode(GITHUB_USER));
    if (!is_array($data)) {
        $stale = gh_cache_get_stale($cacheKey);
        return $stale !== null ? $stale : [];
    }

    $result = [
        'avatar_url' => $data['avatar_url'] ?? null,
        'followers' => $data['followers'] ?? 0,
        'public_repos' => $data['public_repos'] ?? 0,
        'created_at' => $data['created_at'] ?? null,
    ];
    gh_cache_set($cacheKey, $result);
    return $result;
}

/**
 * Turns "2026-07-10T12:00:00Z" into "3 days ago" style relative text.
 */
function gh_time_ago(?string $iso): string {
    if (!$iso) return 'unknown';
    $then = strtotime($iso);
    if (!$then) return 'unknown';
    $diff = time() - $then;
    if ($diff < 60) return 'just now';
    $units = [
        31536000 => 'y',
        2592000 => 'mo',
        604800 => 'w',
        86400 => 'd',
        3600 => 'h',
        60 => 'm',
    ];
    foreach ($units as $secs => $label) {
        $val = intdiv($diff, $secs);
        if ($val >= 1) return $val . $label . ' ago';
    }
    return 'just now';
}

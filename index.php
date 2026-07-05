<?php
/**
 * Coming Soon page for Skylar Furri
 * -------------------------------------------------
 * EDIT THESE TWO LINES to point at your repo:
 */
$github_owner = "yourusername";
$github_repo  = "yourrepo";

/**
 * Bump this with every release.
 */
$site_version = "0.0.1";
/**
 * Everything else works automatically.
 */

$year = date("Y");

function fetch_commits(string $owner, string $repo, int $limit = 6): array {
    $url = "https://api.github.com/repos/{$owner}/{$repo}/commits?per_page={$limit}";

    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: PHP\r\n" .
                        "Accept: application/vnd.github+json\r\n",
            "timeout" => 6,
            "ignore_errors" => true,
        ],
    ];

    $context = stream_context_create($opts);
    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
        return [];
    }

    $data = json_decode($response, true);

    if (!is_array($data) || isset($data["message"])) {
        // API error (rate limit, repo not found, etc.)
        return [];
    }

    $commits = [];
    foreach ($data as $item) {
        $commits[] = [
            "sha"     => substr($item["sha"] ?? "", 0, 7),
            "message" => explode("\n", trim($item["commit"]["message"] ?? ""))[0],
            "author"  => $item["commit"]["author"]["name"] ?? "unknown",
            "date"    => $item["commit"]["author"]["date"] ?? null,
        ];
    }

    return $commits;
}

$commits = fetch_commits($github_owner, $github_repo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Skylar Furri — Coming Soon (v<?= htmlspecialchars($site_version) ?>)</title>

<!-- Favicon -->
<link rel="icon" type="image/png" href="/images/skylar.png">
<link rel="apple-touch-icon" href="/images/skylar.png">

<!-- Discord / Open Graph embed -->
<meta property="og:title" content="Skylar Furri">
<meta property="og:description" content="Coming Soon — I am working on it qwp">
<meta property="og:image" content="/images/skylar.png">
<meta property="og:type" content="website">
<meta name="theme-color" content="#721e1e">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Skylar Furri">
<meta name="twitter:description" content="Coming Soon — I am working on it qwp">
<meta name="twitter:image" content="/images/skylar.png">

<link rel="stylesheet" href="/css/style.css">
</head>
<body>

<main class="wrap">

    <div class="pfp-frame">
        <img src="/images/skylar.png" alt="Skylar Furri" class="pfp">
    </div>

    <h1 class="headline">Coming Soon</h1>
    <p class="subline">I am working on it qwp</p>

    <section class="log">
        <div class="log-header">
            <span class="log-dot"></span>
            <span class="log-title">git status</span>
            <span class="log-repo">
                <?= htmlspecialchars($github_owner) ?>/<?= htmlspecialchars($github_repo) ?>
            </span>
            <span class="log-version">v<?= htmlspecialchars($site_version) ?></span>
        </div>

        <div class="log-body">
            <?php if (empty($commits)): ?>
                <p class="log-empty">No commits found yet — check the repo name in index.php, or the API rate limit may be hit.</p>
            <?php else: ?>
                <ul class="timeline">
                    <?php foreach ($commits as $c): ?>
                        <li class="timeline-entry">
                            <span class="hash"><?= htmlspecialchars($c["sha"]) ?></span>
                            <span class="msg"><?= htmlspecialchars($c["message"]) ?></span>
                            <?php if ($c["date"]): ?>
                                <span class="date"><?= htmlspecialchars(date("M j, Y", strtotime($c["date"]))) ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">
        &copy;<?= $year ?> Skylar Furri
    </footer>

</main>

</body>
</html>
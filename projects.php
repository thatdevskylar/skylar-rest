<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/github.php';

$pageTitle = 'Projects — Skylar';
$pageDescription = 'Public repositories and latest commits from github.com/' . GITHUB_USER;

$repos = gh_get_repos(12);

// Rough color map so language dots aren't just grey
$langColors = [
    'Python' => '#3776AB', 'JavaScript' => '#F7DF1E', 'TypeScript' => '#3178C6',
    'C#' => '#239120', 'C++' => '#00599C', 'PHP' => '#777BB4', 'HTML' => '#E34F26',
    'CSS' => '#264DE4', 'Shell' => '#89e051', 'Dockerfile' => '#384d54',
    'Go' => '#00ADD8', 'Rust' => '#dea584', 'Java' => '#b07219',
];
function lang_color(?string $lang, array $map): string {
    return $lang && isset($map[$lang]) ? $map[$lang] : '#6f625d';
}

require __DIR__ . '/includes/header.php';
?>

<section class="wrap">
  <p class="eyebrow">// public_repos</p>
  <h1>Projects</h1>
  <p>Live pull from <a href="https://github.com/<?= GITHUB_USER ?>" target="_blank" rel="noopener" style="color:var(--accent-bright);">github.com/<?= GITHUB_USER ?></a> — repo list and latest commit, cached for 15 minutes.</p>

  <?php if (empty($repos)): ?>
    <div class="empty-state">
      couldn't reach the GitHub API right now — try refreshing in a bit,<br>
      or browse the repos directly on <a href="https://github.com/<?= GITHUB_USER ?>" target="_blank" rel="noopener" style="color:var(--accent-bright);">GitHub</a>.
    </div>
  <?php else: ?>
    <div class="repo-grid">
      <?php foreach ($repos as $repo): ?>
        <a class="repo-card" href="<?= htmlspecialchars($repo['url']) ?>" target="_blank" rel="noopener">
          <div class="repo-card__head">
            <span class="repo-card__name"><span class="slash">/</span><?= htmlspecialchars($repo['name']) ?></span>
          </div>
          <p class="repo-card__desc"><?= htmlspecialchars($repo['description'] ?? 'No description yet.') ?></p>
          <div class="repo-card__stats">
            <?php if (!empty($repo['language'])): ?>
              <span><i class="repo-card__lang-dot" style="background:<?= lang_color($repo['language'], $langColors) ?>"></i><?= htmlspecialchars($repo['language']) ?></span>
            <?php endif; ?>
            <span><?php include __DIR__ . '/includes/icons/star.svg'; ?><?= (int)$repo['stars'] ?></span>
            <span><?php include __DIR__ . '/includes/icons/fork.svg'; ?><?= (int)$repo['forks'] ?></span>
            <span><?= gh_time_ago($repo['pushed_at']) ?></span>
          </div>
          <?php if (!empty($repo['commit'])): ?>
            <div class="repo-card__commit">
              <span><span class="sha"><?= htmlspecialchars($repo['commit']['sha']) ?></span> · <?= gh_time_ago($repo['commit']['date']) ?></span>
              <span class="msg"><?= htmlspecialchars($repo['commit']['message']) ?></span>
            </div>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

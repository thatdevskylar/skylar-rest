<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/github.php';

$pageTitle = 'Skylar — thatdevskylar';
$pageDescription = '21-year-old college student who builds useful apps and self-hosted services. Furry, homelabber, open source tinkerer.';

$profile = gh_get_profile();
$avatar = !empty($profile['avatar_url']) ? $profile['avatar_url'] : '/images/skylar.png';
$sinceYear = !empty($profile['created_at']) ? date('Y', strtotime($profile['created_at'])) : '2024';

require __DIR__ . '/includes/header.php';
?>

<section class="wrap">
  <p class="eyebrow">// whoami</p>

  <div class="status-card">
    <div class="status-card__top">
      <div class="status-card__avatar-wrap">
        <img class="status-card__avatar" src="<?= htmlspecialchars($avatar) ?>" alt="Skylar's avatar" width="84" height="84">
        <span class="status-card__pulse" title="Status: online"></span>
      </div>
      <div class="status-card__id">
        <h1 class="status-card__name">Hi, I'm Skylar <span aria-hidden="true">👋</span></h1>
        <p class="status-card__handle">@<?= GITHUB_USER ?> · skylar.rest</p>

        <div class="status-card__meta">
          <span>age: <b>21</b></span>
          <span>role: <b>college student</b></span>
          <span>status: <b class="ok">● online</b></span>
          <span>member since: <b><?= htmlspecialchars($sinceYear) ?></b></span>
        </div>
      </div>
    </div>

    <div class="status-card__bio">
      <p>🎓 21-year-old college student, building whatever seems useful at 2am.</p>
      <p>🛠️ I build small apps and self-hosted services — mostly for myself, sometimes they escape onto the internet.</p>
      <p>🦊 Furry. Digital creature of the internet. That's basically my whole personality outside of a terminal.</p>
      <p>📫 Reach me at <a href="mailto:<?= CONTACT_EMAIL ?>" class="btn-inline" data-copy="<?= CONTACT_EMAIL ?>" style="color:var(--accent-bright);"><?= CONTACT_EMAIL ?></a></p>
    </div>

    <div class="status-card__links">
      <a class="btn btn--primary" href="https://github.com/<?= GITHUB_USER ?>" target="_blank" rel="noopener">
        <?php include __DIR__ . '/includes/icons/github.svg'; ?>
        github/<?= GITHUB_USER ?>
      </a>
      <a class="btn" href="mailto:<?= CONTACT_EMAIL ?>">
        <?php include __DIR__ . '/includes/icons/mail.svg'; ?>
        email me
      </a>
      <a class="btn" href="/projects">
        <?php include __DIR__ . '/includes/icons/folder.svg'; ?>
        view projects
      </a>
    </div>
  </div>

  <h2>Languages &amp; tools</h2>
  <div class="badge-row">
    <span class="badge"><span class="badge__dot" style="background:#3776AB"></span>Python</span>
    <span class="badge"><span class="badge__dot" style="background:#F7DF1E"></span>JavaScript</span>
    <span class="badge"><span class="badge__dot" style="background:#239120"></span>C#</span>
    <span class="badge"><span class="badge__dot" style="background:#00599C"></span>C++</span>
    <span class="badge"><span class="badge__dot" style="background:#777BB4"></span>PHP</span>
  </div>

  <h2>What I'm into</h2>
  <div class="card-grid">
    <div class="info-card">
      <svg class="info-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="4" width="18" height="7" rx="1.5"/><rect x="3" y="13" width="18" height="7" rx="1.5"/><circle cx="7" cy="7.5" r="0.8" fill="currentColor"/><circle cx="7" cy="16.5" r="0.8" fill="currentColor"/></svg>
      <h3>Self-hosting</h3>
      <p>Running services on my own hardware, because the cloud is just someone else's computer.</p>
    </div>
    <div class="info-card">
      <svg class="info-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2l2.4 6.6L21 11l-6.6 2.4L12 20l-2.4-6.6L3 11l6.6-2.4L12 2z"/></svg>
      <h3>Small useful apps</h3>
      <p>Building tools that solve one real problem well, instead of everything badly.</p>
    </div>
    <div class="info-card">
      <svg class="info-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 4h16v12H4z"/><path d="M8 20h8M12 16v4"/></svg>
      <h3>Homelab &amp; open source</h3>
      <p>Tinkering with racks, containers, and whatever breaks this week — then fixing it in public.</p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

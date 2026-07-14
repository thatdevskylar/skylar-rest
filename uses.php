<?php
require_once __DIR__ . '/includes/config.php';

$pageTitle = 'The Stack — Skylar';
$pageDescription = 'Hardware, self-hosted services, and tools running in the homelab.';

require __DIR__ . '/includes/header.php';
?>

<section class="wrap">
  <p class="eyebrow">// homelab.yml</p>
  <h1>The stack</h1>
  <p>What's actually running behind skylar.rest — hardware, self-hosted services, and the tools I reach for day to day.</p>

  <h2>Self-hosted services</h2>
  <div class="rack">
    <div class="rack__row">
      <span class="rack__led"></span>
      <span><span class="rack__name">Reverse proxy</span><span class="rack__desc">TLS termination and routing for every subdomain</span></span>
      <span class="rack__tag">Caddy</span>
    </div>
    <div class="rack__row">
      <span class="rack__led"></span>
      <span><span class="rack__name">Container orchestration</span><span class="rack__desc">Keeps every service isolated and easy to redeploy</span></span>
      <span class="rack__tag">Docker Compose</span>
    </div>
    <div class="rack__row">
      <span class="rack__led"></span>
      <span><span class="rack__name">Git hosting</span><span class="rack__desc">Private repos and CI for stuff that isn't public yet</span></span>
      <span class="rack__tag">Gitea</span>
    </div>
    <div class="rack__row">
      <span class="rack__led"></span>
      <span><span class="rack__name">Uptime monitoring</span><span class="rack__desc">Pings every service and yells at me when one dies</span></span>
      <span class="rack__tag">Uptime Kuma</span>
    </div>
    <div class="rack__row">
      <span class="rack__led"></span>
      <span><span class="rack__name">Media &amp; storage</span><span class="rack__desc">Photos, backups, and the things I don't trust the cloud with</span></span>
      <span class="rack__tag">Nextcloud</span>
    </div>
  </div>

  <h2>Languages &amp; tools</h2>
  <div class="badge-row">
    <span class="badge"><span class="badge__dot" style="background:#3776AB"></span>Python</span>
    <span class="badge"><span class="badge__dot" style="background:#F7DF1E"></span>JavaScript</span>
    <span class="badge"><span class="badge__dot" style="background:#239120"></span>C#</span>
    <span class="badge"><span class="badge__dot" style="background:#00599C"></span>C++</span>
    <span class="badge"><span class="badge__dot" style="background:#777BB4"></span>PHP</span>
    <span class="badge"><span class="badge__dot" style="background:#89e051"></span>Bash</span>
  </div>

  <h2>Editor &amp; environment</h2>
  <div class="rack">
    <div class="rack__row">
      <span class="rack__led"></span>
      <span><span class="rack__name">Editor</span><span class="rack__desc">Where most of the badges above actually get typed</span></span>
      <span class="rack__tag">VS Code</span>
    </div>
    <div class="rack__row">
      <span class="rack__led"></span>
      <span><span class="rack__name">Daily driver OS</span><span class="rack__desc">Servers run headless; desktop stays flexible</span></span>
      <span class="rack__tag">Linux + Windows</span>
    </div>
    <div class="rack__row">
      <span class="rack__led"></span>
      <span><span class="rack__name">Terminal</span><span class="rack__desc">Tabs, panes, and too many SSH sessions at once</span></span>
      <span class="rack__tag">Windows Terminal</span>
    </div>
  </div>

  <p style="margin-top:32px;font-size:13px;font-family:var(--font-mono);color:var(--text-faint);">
    all green — last checked <?= date('Y-m-d H:i') ?> UTC
  </p>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

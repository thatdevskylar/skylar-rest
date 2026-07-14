<?php
require_once __DIR__ . '/includes/config.php';
http_response_code(404);

$pageTitle = '404 — Skylar';
$pageDescription = 'This page went offline.';

require __DIR__ . '/includes/header.php';
?>

<section class="wrap" style="text-align:center;padding-top:40px;">
  <p class="eyebrow" style="justify-content:center;">// error</p>
  <h1 style="font-size:56px;">404</h1>
  <p style="font-family:var(--font-mono);font-size:14px;">
    <span style="color:var(--accent-bright);">service unreachable</span> — this route isn't hosted here.
  </p>
  <div class="status-card__links" style="justify-content:center;margin-top:28px;">
    <a class="btn btn--primary" href="/">
      <?php include __DIR__ . '/includes/icons/folder.svg'; ?>
      back to home
    </a>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

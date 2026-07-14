<?php
require_once __DIR__ . '/config.php';
$currentPage = basename($_SERVER['SCRIPT_NAME']);

$pageTitle = $pageTitle ?? SITE_NAME;
$pageDescription = $pageDescription ?? '21-year-old college student who builds useful apps and self-hosted services.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">

<!-- Discord / OpenGraph embed -->
<meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
<meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
<meta property="og:image" content="/images/skylar.png">
<meta property="og:type" content="website">
<meta name="theme-color" content="<?= BRAND_COLOR ?>">
<meta name="twitter:card" content="summary">

<link rel="icon" type="image/png" href="/images/skylar.png">
<link rel="apple-touch-icon" href="/images/skylar.png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="scanline-overlay" aria-hidden="true"></div>

<header class="site-header">
  <div class="wrap site-header__inner">
    <a href="/" class="brand">
      <span class="brand__mark"></span>
      <span class="brand__word">skylar<span class="brand__dot">.</span>rest</span>
    </a>
    <nav class="nav" aria-label="Primary">
      <a href="/" class="nav__link <?= $currentPage === 'index.php' ? 'is-active' : '' ?>">home</a>
      <a href="/projects" class="nav__link <?= $currentPage === 'projects.php' ? 'is-active' : '' ?>">projects</a>
      <a href="/uses" class="nav__link <?= $currentPage === 'uses.php' ? 'is-active' : '' ?>">stack</a>
      <a href="https://github.com/<?= GITHUB_USER ?>" class="nav__link nav__link--ext" target="_blank" rel="noopener">github ↗</a>
    </nav>
  </div>
</header>

<main>

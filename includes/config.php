<?php
/**
 * Site configuration
 */

define('SITE_NAME', 'Skylar');
define('SITE_TAGLINE', 'Digital creature of the internet');
define('GITHUB_USER', 'thatdevskylar');
define('CONTACT_EMAIL', 'skylar@skylar.rest');
define('BRAND_COLOR', '#721e1e');
define('SITE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'skylar.rest'));
define('CACHE_DIR', __DIR__ . '/../cache');
define('CACHE_TTL', 900); // 15 minutes

if (!is_dir(CACHE_DIR)) {
    @mkdir(CACHE_DIR, 0755, true);
}

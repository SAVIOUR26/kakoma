<?php
/**
 * Site-wide configuration for the Kakoma S.S. website.
 * Edit this file to change brand colors, key dates, or contact details.
 */

// --- Core site info -------------------------------------------------
define('SITE_NAME', 'Kakoma Secondary School');
define('SITE_MOTTO', 'Labour for Success');
define('SITE_TAGLINE', 'Kakoma at 60 — Diamond Jubilee 1967-2026');
define('SITE_URL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    ? 'https://' . $_SERVER['HTTP_HOST']
    : 'http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));

define('SITE_FOUNDED_YEAR', 1967);
define('JUBILEE_DATE', '2026-11-14'); // Diamond Jubilee (60th anniversary) date
define('JUBILEE_DATE_LABEL', '14 November 2026');

// --- Contact details (placeholder — confirm with school administration) ---
define('SCHOOL_ADDRESS', 'Kakoma Secondary School, Rakai District, Uganda');
define('SCHOOL_PHONE', '+256 000 000 000');
define('SCHOOL_EMAIL', 'info@kakomass.com');
define('SCHOOL_MAP_QUERY', 'Kakoma Secondary School, Rakai District, Uganda');

// Social links — leave blank ('') to hide a given icon on the site.
define('SOCIAL_FACEBOOK', '');
define('SOCIAL_TWITTER', '');
define('SOCIAL_INSTAGRAM', '');
define('SOCIAL_YOUTUBE', '');
define('SOCIAL_WHATSAPP', '');

// --- Brand colors -----------------------------------------------------
// Sampled directly from the school crest graphic's blue ring.
define('COLOR_NAVY', '#267CC0');
define('COLOR_NAVY_DARK', '#134062');
define('COLOR_GOLD', '#D4A017');
define('COLOR_GOLD_LIGHT', '#F0C93B');

// --- Paths --------------------------------------------------------
define('BASE_PATH', __DIR__);
define('DATA_PATH', BASE_PATH . '/data');
define('DB_PATH', DATA_PATH . '/kakoma.sqlite');

// --- Navigation (Phase 1 = live at launch, Phase 2 = coming soon teasers) ---
$GLOBALS['NAV_ITEMS'] = [
    ['label' => 'Home', 'href' => '/', 'page' => 'index.php'],
    ['label' => 'Kakoma at 60', 'href' => '/anniversary', 'page' => 'anniversary.php'],
    ['label' => 'Our History', 'href' => '/history', 'page' => 'history.php'],
    ['label' => 'Board Message', 'href' => '/board-message', 'page' => 'board-message.php'],
    ['label' => "Head Teacher's Message", 'href' => '/headteacher-message', 'page' => 'headteacher-message.php'],
    ['label' => 'Old Students', 'href' => '/alumni', 'page' => 'alumni.php'],
    ['label' => 'Digital Magazine', 'href' => '/magazine', 'page' => 'magazine.php'],
    ['label' => 'Gallery', 'href' => '/gallery', 'page' => 'gallery.php'],
    ['label' => 'Blog', 'href' => '/blog', 'page' => 'blog.php'],
    ['label' => 'Events', 'href' => '/events', 'page' => 'events.php'],
    ['label' => 'E-Learning', 'href' => '/elearning', 'page' => 'elearning.php'],
    ['label' => 'Contact', 'href' => '/contact', 'page' => 'contact.php'],
];

date_default_timezone_set('Africa/Kampala');

// Start session for admin auth + flash messages (safe to call on every page).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

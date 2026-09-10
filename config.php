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
// Sampled from the school crest; confirm exact values against official
// brand guidelines once supplied.
define('COLOR_NAVY', '#0A2F5C');
define('COLOR_NAVY_DARK', '#071F3D');
define('COLOR_GOLD', '#D4A017');
define('COLOR_GOLD_LIGHT', '#F0C93B');

// --- Paths --------------------------------------------------------
define('BASE_PATH', __DIR__);
define('DATA_PATH', BASE_PATH . '/data');
define('DB_PATH', DATA_PATH . '/kakoma.sqlite');

// --- Navigation (Phase 1 = live at launch, Phase 2 = coming soon teasers) ---
$GLOBALS['NAV_ITEMS'] = [
    ['label' => 'Home', 'href' => 'index.php'],
    ['label' => 'Kakoma at 60', 'href' => 'anniversary.php'],
    ['label' => 'Our History', 'href' => 'history.php'],
    ['label' => 'Board Message', 'href' => 'board-message.php'],
    ['label' => "Head Teacher's Message", 'href' => 'headteacher-message.php'],
    ['label' => 'Old Students', 'href' => 'alumni.php'],
    ['label' => 'Digital Magazine', 'href' => 'magazine.php'],
    ['label' => 'Gallery', 'href' => 'gallery.php'],
    ['label' => 'Blog', 'href' => 'blog.php'],
    ['label' => 'Events', 'href' => 'events.php'],
    ['label' => 'E-Learning', 'href' => 'elearning.php'],
    ['label' => 'Contact', 'href' => 'contact.php'],
];

date_default_timezone_set('Africa/Kampala');

// Start session for admin auth + flash messages (safe to call on every page).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

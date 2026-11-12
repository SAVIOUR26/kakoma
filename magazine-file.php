<?php
/**
 * Serves the digital magazine's page images and PDF from assets/magazine/
 * (which is closed to direct access) only once the magazine has launched.
 */
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';

$name = basename((string)($_GET['f'] ?? ''));
if (preg_match('/^page-\d{2}\.jpg$/', $name)) {
    $path = BASE_PATH . '/assets/magazine/pages/' . $name;
    $type = 'image/jpeg';
} elseif ($name === 'kakoma-diamond-jubilee-magazine.pdf') {
    $path = BASE_PATH . '/assets/magazine/' . $name;
    $type = 'application/pdf';
} else {
    $path = '';
}

if (!magazine_can_read() || $path === '' || !is_file($path)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Not found';
    exit;
}

header('Content-Type: ' . $type);
header('Content-Length: ' . filesize($path));
header('Cache-Control: ' . (magazine_is_live() ? 'public, max-age=86400' : 'private, no-store'));
if ($type === 'application/pdf') {
    header('Content-Disposition: attachment; filename="Kakoma-at-Sixty-Diamond-Jubilee-Magazine.pdf"');
}
readfile($path);

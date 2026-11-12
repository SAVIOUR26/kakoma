<?php
/**
 * Shared page header. Expects (optionally) these variables to be set
 * before including this file:
 *   $page_title       string  – appears in <title> and breadcrumb
 *   $page_description string  – meta description
 *   $body_class       string  – extra class on <body>, e.g. "page-home"
 */
$page_title = $page_title ?? SITE_NAME;
$page_description = $page_description ?? 'Kakoma Secondary School, Rakai District — celebrating 60 years of Labour for Success.';
$body_class = $body_class ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= h($page_title) ?> | <?= h(SITE_NAME) ?></title>
<meta name="description" content="<?= h($page_description) ?>">
<meta property="og:title" content="<?= h($page_title) ?> | <?= h(SITE_NAME) ?>">
<meta property="og:description" content="<?= h($page_description) ?>">
<meta property="og:type" content="website">
<?php if (!empty($page_image)): ?>
<meta property="og:image" content="<?= h(rtrim(SITE_URL, '/') . '/' . ltrim($page_image, '/')) ?>">
<?php endif; ?>
<link rel="icon" href="assets/logo/kakoma-crest.svg" type="image/svg+xml">
<link rel="alternate icon" href="assets/logo/kakoma-crest.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap">
<link rel="stylesheet" href="assets/css/style.css?v=<?= h((string) @filemtime(BASE_PATH . '/assets/css/style.css')) ?>">
</head>
<body class="<?= h($body_class) ?>">

<?php include __DIR__ . '/ribbon.php'; ?>
<?php include __DIR__ . '/nav.php'; ?>

<main>

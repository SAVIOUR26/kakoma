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
<link rel="icon" href="assets/logo/kakoma-crest.png">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="<?= h($body_class) ?>">

<?php include __DIR__ . '/ribbon.php'; ?>
<?php include __DIR__ . '/nav.php'; ?>

<main>

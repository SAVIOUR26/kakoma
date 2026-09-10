<?php
/** Expects $page_title and optional $active set before including. */
$active = $active ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= h($page_title ?? 'Admin') ?> | Kakoma Admin</title>
<link rel="icon" href="../assets/logo/kakoma-crest.jpg">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="brand">
            <img src="../assets/logo/kakoma-crest.jpg" alt="Kakoma crest">
            <span>Kakoma Admin</span>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" class="<?= $active === 'dashboard' ? 'is-active' : '' ?>">Dashboard</a></li>
                <li><a href="posts.php" class="<?= $active === 'posts' ? 'is-active' : '' ?>">Blog Posts</a></li>
                <li><a href="events.php" class="<?= $active === 'events' ? 'is-active' : '' ?>">Events</a></li>
                <li><a href="alumni.php" class="<?= $active === 'alumni' ? 'is-active' : '' ?>">Old Students</a></li>
                <li><a href="gallery.php" class="<?= $active === 'gallery' ? 'is-active' : '' ?>">Gallery</a></li>
                <li><a href="messages.php" class="<?= $active === 'messages' ? 'is-active' : '' ?>">Messages</a></li>
                <li><a href="account.php" class="<?= $active === 'account' ? 'is-active' : '' ?>">My Account</a></li>
            </ul>
            <div class="logout">
                <ul><li><a href="logout.php">Log Out</a></li></ul>
            </div>
        </nav>
    </aside>
    <div class="admin-main">
        <div class="admin-topbar">
            <h1><?= h($page_title ?? 'Admin') ?></h1>
            <a href="../index.php" target="_blank" class="btn btn-navy" style="padding:8px 16px;font-size:0.85rem;">View Site &rarr;</a>
        </div>
        <div class="admin-content">
            <?php $flashSuccess = flash_get('admin_success'); $flashError = flash_get('admin_error'); ?>
            <?php if ($flashSuccess): ?><div class="alert alert-success"><?= h($flashSuccess) ?></div><?php endif; ?>
            <?php if ($flashError): ?><div class="alert alert-error"><?= h($flashError) ?></div><?php endif; ?>

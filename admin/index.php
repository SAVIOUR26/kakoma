<?php
require __DIR__ . '/includes/bootstrap.php';
require_admin_login();

$db = get_db();
$stats = [
    'Blog Posts' => $db->query('SELECT COUNT(*) FROM posts')->fetchColumn(),
    'Events' => $db->query('SELECT COUNT(*) FROM events')->fetchColumn(),
    'Old Students Registered' => $db->query('SELECT COUNT(*) FROM alumni')->fetchColumn(),
    'Pending Approval' => $db->query('SELECT COUNT(*) FROM alumni WHERE approved = 0')->fetchColumn(),
    'Gallery Photos' => $db->query('SELECT COUNT(*) FROM gallery_images')->fetchColumn(),
    'Unread Messages' => $db->query('SELECT COUNT(*) FROM contact_messages WHERE read_flag = 0')->fetchColumn(),
];

$page_title = 'Dashboard';
$active = 'dashboard';
require __DIR__ . '/includes/layout-header.php';
?>

<div class="admin-stats">
    <?php foreach ($stats as $label => $num): ?>
        <div class="admin-stat">
            <span class="num"><?= h((string) $num) ?></span>
            <div class="label"><?= h($label) ?></div>
        </div>
    <?php endforeach; ?>
</div>

<div class="admin-card">
    <h3 class="mt-0">Welcome to the Kakoma Admin Panel</h3>
    <p class="muted">
        Use the menu on the left to publish blog posts, manage events, review
        Old Students registrations, caption gallery photos, and read messages
        from the contact form and e-learning interest form — all without
        needing a developer.
    </p>
    <p class="muted">
        Days to the Diamond Jubilee (<?= h(JUBILEE_DATE_LABEL) ?>):
        <strong><?= h((string) jubilee_countdown_parts()['days']) ?></strong>
    </p>
</div>

<?php require __DIR__ . '/includes/layout-footer.php'; ?>

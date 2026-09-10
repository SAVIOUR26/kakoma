<?php
require __DIR__ . '/includes/bootstrap.php';
require_admin_login();

$db = get_db();

if (isset($_GET['approve'])) {
    $db->prepare('UPDATE alumni SET approved = 1 WHERE id = :id')->execute([':id' => (int) $_GET['approve']]);
    flash_set('admin_success', 'Old student approved and now visible on the site.');
    header('Location: alumni.php');
    exit;
}
if (isset($_GET['unapprove'])) {
    $db->prepare('UPDATE alumni SET approved = 0 WHERE id = :id')->execute([':id' => (int) $_GET['unapprove']]);
    flash_set('admin_success', 'Old student hidden from the site.');
    header('Location: alumni.php');
    exit;
}
if (isset($_GET['feature'])) {
    $db->prepare('UPDATE alumni SET featured = 1 WHERE id = :id')->execute([':id' => (int) $_GET['feature']]);
    header('Location: alumni.php');
    exit;
}
if (isset($_GET['unfeature'])) {
    $db->prepare('UPDATE alumni SET featured = 0 WHERE id = :id')->execute([':id' => (int) $_GET['unfeature']]);
    header('Location: alumni.php');
    exit;
}
if (isset($_GET['delete'])) {
    $db->prepare('DELETE FROM alumni WHERE id = :id')->execute([':id' => (int) $_GET['delete']]);
    flash_set('admin_success', 'Old student record deleted.');
    header('Location: alumni.php');
    exit;
}

$alumni = $db->query('SELECT * FROM alumni ORDER BY approved ASC, submitted_at DESC')->fetchAll();

$page_title = 'Old Students';
$active = 'alumni';
require __DIR__ . '/includes/layout-header.php';
?>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Class Year</th><th>Role</th><th>Quote</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($alumni as $alum): ?>
                <tr>
                    <td><?= h($alum['full_name']) ?><br><span class="muted" style="font-size:0.8rem;"><?= h($alum['email']) ?> <?= h($alum['phone']) ?></span></td>
                    <td><?= h($alum['class_year']) ?></td>
                    <td><?= h($alum['current_role']) ?></td>
                    <td style="max-width:220px;"><?= h($alum['quote']) ?></td>
                    <td>
                        <?php if ($alum['approved']): ?><span class="badge badge-yes">Approved</span><?php else: ?><span class="badge badge-no">Pending</span><?php endif; ?>
                        <?php if ($alum['featured']): ?><br><span class="badge badge-yes" style="margin-top:4px;">Featured</span><?php endif; ?>
                    </td>
                    <td class="action-links">
                        <?php if (!$alum['approved']): ?>
                            <a href="alumni.php?approve=<?= (int) $alum['id'] ?>">Approve</a>
                        <?php else: ?>
                            <a href="alumni.php?unapprove=<?= (int) $alum['id'] ?>">Unapprove</a>
                            <?php if ($alum['featured']): ?>
                                <a href="alumni.php?unfeature=<?= (int) $alum['id'] ?>">Unfeature</a>
                            <?php else: ?>
                                <a href="alumni.php?feature=<?= (int) $alum['id'] ?>">Feature</a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <a href="alumni.php?delete=<?= (int) $alum['id'] ?>" class="danger" onclick="return confirm('Delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$alumni): ?><tr><td colspan="6" class="muted">No Old Student registrations yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/includes/layout-footer.php'; ?>

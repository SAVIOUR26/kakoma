<?php
require __DIR__ . '/includes/bootstrap.php';
require_admin_login();

$db = get_db();

if (isset($_GET['read'])) {
    $db->prepare('UPDATE contact_messages SET read_flag = 1 WHERE id = :id')->execute([':id' => (int) $_GET['read']]);
    header('Location: messages.php');
    exit;
}
if (isset($_GET['delete'])) {
    $db->prepare('DELETE FROM contact_messages WHERE id = :id')->execute([':id' => (int) $_GET['delete']]);
    flash_set('admin_success', 'Message deleted.');
    header('Location: messages.php');
    exit;
}
if (isset($_GET['delete_interest'])) {
    $db->prepare('DELETE FROM elearning_interest WHERE id = :id')->execute([':id' => (int) $_GET['delete_interest']]);
    header('Location: messages.php');
    exit;
}

$messages = $db->query('SELECT * FROM contact_messages ORDER BY submitted_at DESC')->fetchAll();
$interest = $db->query('SELECT * FROM elearning_interest ORDER BY submitted_at DESC')->fetchAll();

$page_title = 'Messages';
$active = 'messages';
require __DIR__ . '/includes/layout-header.php';
?>

<div class="admin-card">
    <h3 class="mt-0">Contact Form Messages</h3>
    <table class="admin-table">
        <thead><tr><th>From</th><th>Message</th><th>Received</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($messages as $msg): ?>
                <tr style="<?= $msg['read_flag'] ? '' : 'background:#FBF7EC;' ?>">
                    <td><?= h($msg['name']) ?><br><a href="mailto:<?= h($msg['email']) ?>"><?= h($msg['email']) ?></a></td>
                    <td style="max-width:320px;"><?= nl2br(h($msg['message'])) ?></td>
                    <td><?= h(format_date($msg['submitted_at'], 'j M Y, g:i a')) ?></td>
                    <td class="action-links">
                        <?php if (!$msg['read_flag']): ?><a href="messages.php?read=<?= (int) $msg['id'] ?>">Mark Read</a><?php endif; ?>
                        <a href="messages.php?delete=<?= (int) $msg['id'] ?>" class="danger" onclick="return confirm('Delete this message?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$messages): ?><tr><td colspan="4" class="muted">No messages yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<div class="admin-card">
    <h3 class="mt-0">E-Learning Interest List</h3>
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Submitted</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($interest as $row): ?>
                <tr>
                    <td><?= h($row['name']) ?></td>
                    <td><?= h($row['email']) ?></td>
                    <td><?= h($row['phone']) ?></td>
                    <td><?= h(format_date($row['submitted_at'], 'j M Y, g:i a')) ?></td>
                    <td class="action-links">
                        <a href="messages.php?delete_interest=<?= (int) $row['id'] ?>" class="danger" onclick="return confirm('Delete this entry?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$interest): ?><tr><td colspan="5" class="muted">No entries yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/includes/layout-footer.php'; ?>

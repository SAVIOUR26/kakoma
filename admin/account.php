<?php
require __DIR__ . '/includes/bootstrap.php';
require_admin_login();

$db = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $stmt = $db->prepare('SELECT * FROM admin_users WHERE id = :id');
    $stmt->execute([':id' => $_SESSION['admin_id']]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($current, $user['password_hash'])) {
        flash_set('admin_error', 'Current password is incorrect.');
    } elseif (strlen($new) < 8) {
        flash_set('admin_error', 'New password must be at least 8 characters.');
    } elseif ($new !== $confirm) {
        flash_set('admin_error', 'New password and confirmation do not match.');
    } else {
        $db->prepare('UPDATE admin_users SET password_hash = :h WHERE id = :id')
            ->execute([':h' => password_hash($new, PASSWORD_DEFAULT), ':id' => $user['id']]);
        flash_set('admin_success', 'Password updated successfully.');
    }
    header('Location: account.php');
    exit;
}

$page_title = 'My Account';
$active = 'account';
require __DIR__ . '/includes/layout-header.php';
?>

<div class="admin-card" style="max-width:480px;">
    <h3 class="mt-0">Change Password</h3>
    <p class="muted">Signed in as <strong><?= h($_SESSION['admin_username']) ?></strong>.</p>
    <form method="post">
        <div class="field">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>
        </div>
        <div class="field">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required minlength="8">
        </div>
        <div class="field">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
        </div>
        <button type="submit" class="btn btn-navy">Update Password</button>
    </form>
</div>

<?php require __DIR__ . '/includes/layout-footer.php'; ?>

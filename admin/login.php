<?php
require __DIR__ . '/includes/bootstrap.php';

if (is_admin_logged_in()) {
    header('Location: /admin/');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $db = get_db();
    $stmt = $db->prepare('SELECT * FROM admin_users WHERE username = :u');
    $stmt->execute([':u' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        header('Location: /admin/');
        exit;
    }
    $error = 'Incorrect username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | Kakoma S.S.</title>
<link rel="icon" href="../assets/logo/kakoma-crest.png">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">
<div class="login-wrap">
    <div class="login-box">
        <img src="../assets/logo/kakoma-crest.png" alt="Kakoma crest">
        <h2 class="mt-0">Kakoma Admin</h2>
        <p class="muted">Sign in to manage site content.</p>
        <?php if ($error): ?><div class="alert alert-error"><?= h($error) ?></div><?php endif; ?>
        <form method="post">
            <div class="field" style="text-align:left;">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="field" style="text-align:left;">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-navy btn-block">Log In</button>
        </form>
    </div>
</div>
</body>
</html>

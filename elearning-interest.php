<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: elearning.php');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

if ($email === '' && $phone === '') {
    flash_set('elearning_error', 'Please provide at least an email or phone number so we can notify you.');
    header('Location: elearning.php');
    exit;
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash_set('elearning_error', 'That email address doesn\'t look right — please check and try again.');
    header('Location: elearning.php');
    exit;
}

$db = get_db();
$stmt = $db->prepare(
    'INSERT INTO elearning_interest (name, email, phone) VALUES (:name, :email, :phone)'
);
$stmt->execute([':name' => $name ?: null, ':email' => $email ?: null, ':phone' => $phone ?: null]);

flash_set('elearning_success', "Thanks! We'll let you know as soon as e-learning launches.");
header('Location: elearning.php');
exit;

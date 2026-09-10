<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    flash_set('contact_error', 'Please fill in your name, email and message.');
    header('Location: contact.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash_set('contact_error', 'That email address doesn\'t look right — please check and try again.');
    header('Location: contact.php');
    exit;
}

$db = get_db();
$stmt = $db->prepare(
    'INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)'
);
$stmt->execute([':name' => $name, ':email' => $email, ':message' => $message]);

flash_set('contact_success', 'Thank you, ' . $name . '! Your message has been received — we\'ll get back to you soon.');
header('Location: contact.php');
exit;

<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: alumni.php');
    exit;
}

$fullName = trim($_POST['full_name'] ?? '');
$classYear = trim($_POST['class_year'] ?? '');
$currentRole = trim($_POST['current_role'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$quote = trim($_POST['quote'] ?? '');

if ($fullName === '') {
    flash_set('alumni_error', 'Please tell us your full name to register.');
    header('Location: alumni.php#register');
    exit;
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash_set('alumni_error', 'That email address doesn\'t look right — please check and try again.');
    header('Location: alumni.php#register');
    exit;
}

$db = get_db();
$stmt = $db->prepare(
    'INSERT INTO alumni (full_name, class_year, current_role, quote, email, phone, approved)
     VALUES (:full_name, :class_year, :current_role, :quote, :email, :phone, 0)'
);
$stmt->execute([
    ':full_name' => $fullName,
    ':class_year' => $classYear ?: null,
    ':current_role' => $currentRole ?: null,
    ':quote' => $quote ?: null,
    ':email' => $email ?: null,
    ':phone' => $phone ?: null,
]);

flash_set('alumni_success', 'Thank you, ' . $fullName . '! Your registration has been received and will appear here once reviewed by the school.');
header('Location: alumni.php#register');
exit;

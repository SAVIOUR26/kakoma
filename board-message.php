<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/magazine.php';

$message = mag_messages()['board'];
$page_title = "Word From the Board";
$page_description = "A Diamond Jubilee message from Owek. Richard Sseggwanyi, Chairman of the Board of Governors of Kakoma Secondary School.";
$page_image = $message['photo'];
$body_class = 'page-board';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1><?= h($message['title']) ?></h1>
        <p>From the Chairman of the Board of Governors</p>
    </div>
</section>

<section>
    <div class="container">
        <?php render_message($message, false); ?>
        <p class="text-center">
            <a class="btn btn-navy" href="/messages">All Jubilee messages</a>
            <a class="btn btn-gold" href="/magazine">Read the magazine</a>
        </p>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

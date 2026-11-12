<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/magazine.php';

$message = mag_messages()['headteacher'];
$page_title = "Head Teacher's Message";
$page_description = "A Diamond Jubilee message from Mr. Bbaale David, Head Teacher of Kakoma Secondary School.";
$page_image = $message['photo'];
$body_class = 'page-headteacher';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1><?= h($message['title']) ?></h1>
        <p>Kakoma Secondary School at sixty</p>
    </div>
</section>

<section>
    <div class="container">
        <?php render_message($message, false); ?>
        <p class="text-center">
            <a class="btn btn-navy" href="/messages">All Jubilee messages</a>
            <a class="btn btn-gold" href="/magazine"><?= h(magazine_cta()) ?></a>
        </p>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

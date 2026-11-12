<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/magazine.php';

$messages = mag_messages();
$page_title = 'Jubilee Messages';
$page_description = 'Diamond Jubilee messages from HRH the Kamuswaga of Kooki, the Bishop of West Buganda Diocese, the Board Chairman, the Organising Committee Chairman and the Head Teacher of Kakoma Secondary School.';
$body_class = 'page-messages';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Diamond Jubilee Messages</h1>
        <p>As published in &ldquo;Kakoma at Sixty&rdquo;, the Diamond Jubilee magazine</p>
    </div>
</section>

<section>
    <div class="container">
        <nav class="message-nav" aria-label="Messages">
            <?php foreach ($messages as $m): ?>
                <a href="#<?= h($m['key']) ?>"><?= h($m['author']) ?></a>
            <?php endforeach; ?>
        </nav>
        <?php foreach ($messages as $m): render_message($m); endforeach; ?>
        <p class="text-center"><a class="btn btn-gold" href="/magazine"><?= h(magazine_cta()) ?></a></p>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

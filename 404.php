<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = 'Page Not Found';
$body_class = 'page-404';
require __DIR__ . '/includes/header.php';
?>

<section style="padding:100px 0; text-align:center;">
    <div class="container">
        <h1 style="font-size:4rem;">404</h1>
        <p class="muted">Sorry, we couldn't find that page.</p>
        <a href="/" class="btn btn-navy">Back to Home</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

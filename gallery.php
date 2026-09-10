<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

$db = get_db();
$images = $db->query("SELECT * FROM gallery_images ORDER BY album ASC, sort_order ASC")->fetchAll();

$albumLabels = [
    'dinner' => "Old Students' Dinner",
    'rakai' => 'Rakai Field Trip',
    'campus' => 'Campus',
    'archive' => 'Historical Archive',
];
$albumsPresent = array_unique(array_column($images, 'album'));

$page_title = 'Gallery';
$page_description = 'Photos from the Old Students\' fundraising dinner, the Rakai field trip, our campus, and historical archives.';
$body_class = 'page-gallery';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Gallery</h1>
        <p>Dinner &middot; Rakai Field Trip &middot; Campus &middot; Archive</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="gallery-filters">
            <button data-filter="all" class="is-active">All</button>
            <?php foreach ($albumLabels as $key => $label): ?>
                <?php if (in_array($key, $albumsPresent, true)): ?>
                    <button data-filter="<?= h($key) ?>"><?= h($label) ?></button>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <?php if ($images): ?>
            <div class="gallery-grid">
                <?php foreach ($images as $img): ?>
                    <div class="gallery-item"
                         data-album="<?= h($img['album']) ?>"
                         data-full="assets/photos/<?= h($img['album']) ?>/<?= h($img['filename']) ?>"
                         data-caption="<?= h($img['caption']) ?>">
                        <img src="assets/photos/<?= h($img['album']) ?>/thumbs/<?= h($img['filename']) ?>" alt="<?= h($img['caption']) ?>" loading="lazy">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center muted">Photos are being added — check back soon.</p>
        <?php endif; ?>
    </div>
</section>

<div class="lightbox" id="lightbox">
    <button class="lightbox-close" aria-label="Close">&times;</button>
    <button class="lightbox-nav lightbox-prev" aria-label="Previous">&larr;</button>
    <figure style="margin:0;">
        <img src="" alt="">
        <figcaption></figcaption>
    </figure>
    <button class="lightbox-nav lightbox-next" aria-label="Next">&rarr;</button>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';

// Digital edition of "Kakoma at Sixty" (32 pages, November 2026).
// Pages are JPEGs rendered from the final digital PDF, so the reader works on
// any phone without a PDF plug-in; the PDF itself is offered as a download.
$magazinePdf = 'assets/magazine/kakoma-diamond-jubilee-magazine.pdf';
$pageFiles = glob(BASE_PATH . '/assets/magazine/pages/page-*.jpg') ?: [];
sort($pageFiles);
$pages = array_map(fn($f) => 'assets/magazine/pages/' . basename($f), $pageFiles);
$hasPdf = file_exists(BASE_PATH . '/' . $magazinePdf);
$pdfSizeMb = $hasPdf ? round(filesize(BASE_PATH . '/' . $magazinePdf) / 1048576, 1) : 0;

// Where to find each section (page numbers as printed).
$contents = [
    1 => 'Front cover',
    3 => "Contents & Editor's note",
    4 => 'A Royal Message from the Kamuswaga of Kooki',
    5 => 'Message from the Bishop of West Buganda Diocese',
    6 => 'Message from the Board Chairman',
    7 => 'Message from the Organising Committee',
    8 => 'Message from the Head Teacher',
    9 => 'Kakoma at 60',
    11 => 'The School History, the Land & the Founding Families',
    15 => 'Timeline',
    16 => 'Where It All Began: the 1968 pioneer',
    17 => 'Head Teachers Through the Years',
    19 => 'Old Students: Where Are They Now',
    20 => 'Voices & Memories',
    22 => '11 Ways to Rekindle Love and Strengthen Your Marriage',
    24 => 'Dining for a Diamond: the fundraising dinners',
    26 => 'Kakoma Today',
    28 => 'The Journey Ahead: the Diamond Hall',
    29 => 'Acknowledgements',
    30 => 'Jubilee Day Programme',
];

$page_title = 'Digital Magazine';
$page_description = 'Read "Kakoma at Sixty", the 32-page Diamond Jubilee magazine of Kakoma Secondary School, online or download it.';
$page_image = $pages[0] ?? null;
$body_class = 'page-magazine';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Kakoma at Sixty</h1>
        <p>The Diamond Jubilee magazine &middot; 32 pages &middot; 1967&ndash;2026</p>
    </div>
</section>

<section>
    <div class="container">
        <?php if ($pages): ?>
            <div class="mag-reader" id="magReader" data-pages="<?= h(json_encode($pages)) ?>">
                <div class="mag-stage" id="magStage" aria-live="polite">
                    <a class="mag-page" href="<?= h($pages[0]) ?>"><img src="<?= h($pages[0]) ?>" alt="Front cover of Kakoma at Sixty"></a>
                </div>
                <div class="mag-controls">
                    <button type="button" class="btn btn-navy" id="magPrev" aria-label="Previous page">&larr; Previous</button>
                    <span class="mag-count" id="magCount">Page 1 of <?= count($pages) ?></span>
                    <button type="button" class="btn btn-navy" id="magNext" aria-label="Next page">Next &rarr;</button>
                </div>
                <p class="form-note text-center">Tap a page to open it full size and zoom in. Swipe or use the arrow keys to turn pages.</p>
            </div>

            <div class="mag-actions">
                <?php if ($hasPdf): ?>
                    <a class="btn btn-gold" href="<?= h($magazinePdf) ?>" download="Kakoma-at-Sixty-Diamond-Jubilee-Magazine.pdf">Download the PDF (<?= h((string)$pdfSizeMb) ?> MB)</a>
                <?php endif; ?>
                <a class="btn btn-navy" href="https://wa.me/?text=<?= urlencode('Read "Kakoma at Sixty", the Kakoma Secondary School Diamond Jubilee magazine: ' . SITE_URL . '/magazine') ?>" target="_blank" rel="noopener">Share on WhatsApp</a>
            </div>

            <div class="mag-contents">
                <h2>In this edition</h2>
                <ol>
                    <?php foreach ($contents as $num => $title): ?>
                        <?php if ($num <= count($pages)): ?>
                            <li><a href="#page-<?= $num ?>" data-goto="<?= $num ?>"><span class="mag-contents__num"><?= $num ?></span> <?= h($title) ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </div>

            <h2 class="text-center" style="margin-top:40px;">All pages</h2>
            <div class="mag-thumbs" id="magThumbs">
                <?php foreach ($pages as $i => $src): ?>
                    <a href="#page-<?= $i + 1 ?>" data-goto="<?= $i + 1 ?>">
                        <img src="<?= h($src) ?>" alt="Page <?= $i + 1 ?>" loading="lazy">
                        <span><?= $i + 1 ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="magazine-frame">
                <div class="magazine-placeholder">
                    <span class="coming-soon-badge">Coming Soon</span>
                    <h3 class="mt-0">The Digital Edition Is On Its Way</h3>
                </div>
            </div>
        <?php endif; ?>

        <div class="social-share text-center" style="justify-content:center;">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(SITE_URL . '/magazine') ?>" target="_blank" rel="noopener">Share on Facebook</a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode(SITE_URL . '/magazine') ?>&text=<?= urlencode('Kakoma at Sixty: the Kakoma S.S. Diamond Jubilee magazine') ?>" target="_blank" rel="noopener">Share on X</a>
            <a href="https://wa.me/?text=<?= urlencode('Read "Kakoma at Sixty", the Kakoma S.S. Diamond Jubilee magazine: ' . SITE_URL . '/magazine') ?>" target="_blank" rel="noopener">Share on WhatsApp</a>
        </div>
    </div>
</section>

<script src="assets/js/magazine.js" defer></script>
<?php require __DIR__ . '/includes/footer.php'; ?>

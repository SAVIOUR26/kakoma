<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';

// Once the digital edition is ready, drop the PDF (or page-flip embed URL)
// here and the reader below will pick it up automatically.
$magazinePdf = 'assets/magazine/kakoma-diamond-jubilee-magazine.pdf';
$magazineEmbedUrl = ''; // e.g. an Issuu / FlipHTML5 embed URL, if used instead of a raw PDF
$hasMagazine = $magazineEmbedUrl !== '' || file_exists(BASE_PATH . '/' . $magazinePdf);

$page_title = 'Digital Magazine';
$page_description = 'Read the Kakoma Secondary School Diamond Jubilee magazine — 60 pages marking 60 years — online.';
$body_class = 'page-magazine';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Digital Magazine</h1>
        <p>The Diamond Jubilee edition — 60 pages marking 60 years</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="magazine-frame">
            <?php if ($magazineEmbedUrl): ?>
                <iframe src="<?= h($magazineEmbedUrl) ?>" allowfullscreen title="Kakoma Diamond Jubilee Magazine"></iframe>
            <?php elseif ($hasMagazine): ?>
                <iframe src="<?= h($magazinePdf) ?>" title="Kakoma Diamond Jubilee Magazine"></iframe>
            <?php else: ?>
                <div class="magazine-placeholder">
                    <span class="coming-soon-badge">Coming Soon</span>
                    <h3 class="mt-0">The Digital Edition Is On Its Way</h3>
                    <p style="max-width:480px;">
                        Our 60-page Diamond Jubilee magazine is being finalized in print and
                        digital editions. Once ready, it will appear here as a page-flip
                        reader you can browse right in your browser — no download needed.
                    </p>
                    <p class="form-note">Want to know the moment it's live? <a href="/contact">Contact us</a> or follow our <a href="/blog">blog</a>.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="social-share text-center" style="justify-content:center;">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(SITE_URL . '/magazine') ?>" target="_blank" rel="noopener">Share on Facebook</a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode(SITE_URL . '/magazine') ?>&text=<?= urlencode('Check out the Kakoma S.S. Diamond Jubilee magazine') ?>" target="_blank" rel="noopener">Share on X</a>
            <a href="https://wa.me/?text=<?= urlencode('Check out the Kakoma S.S. Diamond Jubilee magazine: ' . SITE_URL . '/magazine') ?>" target="_blank" rel="noopener">Share on WhatsApp</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

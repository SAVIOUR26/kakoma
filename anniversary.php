<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

$db = get_db();
$dinnerPhotos = $db->query("SELECT * FROM gallery_images WHERE album = 'dinner' ORDER BY sort_order ASC LIMIT 6")->fetchAll();

$page_title = 'Kakoma at 60';
$page_description = 'The Diamond Jubilee hub: countdown, fundraising dinner highlights, our 60-year timeline, and links to the anniversary magazine.';
$body_class = 'page-anniversary';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Kakoma at 60</h1>
        <p>Diamond Jubilee &middot; <?= h(JUBILEE_DATE_LABEL) ?></p>
    </div>
</section>

<section>
    <div class="container text-center">
        <div id="jubileeCountdown" class="countdown" data-target="<?= h(JUBILEE_DATE) ?>" style="color:var(--navy);">
            <div class="countdown__unit" style="background:var(--cream);border-color:var(--border);">
                <span class="countdown__num" data-unit="days" style="color:var(--navy);">--</span>
                <span class="countdown__label" style="color:var(--ink-soft);">Days</span>
            </div>
            <div class="countdown__unit" style="background:var(--cream);border-color:var(--border);">
                <span class="countdown__num" data-unit="hours" style="color:var(--navy);">--</span>
                <span class="countdown__label" style="color:var(--ink-soft);">Hours</span>
            </div>
            <div class="countdown__unit" style="background:var(--cream);border-color:var(--border);">
                <span class="countdown__num" data-unit="minutes" style="color:var(--navy);">--</span>
                <span class="countdown__label" style="color:var(--ink-soft);">Minutes</span>
            </div>
            <div class="countdown__unit" style="background:var(--cream);border-color:var(--border);">
                <span class="countdown__num" data-unit="seconds" style="color:var(--navy);">--</span>
                <span class="countdown__label" style="color:var(--ink-soft);">Seconds</span>
            </div>
        </div>
        <p class="muted">Until Kakoma Secondary School's Diamond Jubilee celebration.</p>
    </div>
</section>

<section class="section-alt">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">15 August 2026 &middot; Royal Suites, Bugolobi</span>
            <h2>The First Fundraising Dinner</h2>
            <p class="muted">The Jubilee celebrations kicked off with an evening of memories, pledges and the unveiling of the Diamond Jubilee Hall Project.</p>
        </div>
        <div class="gallery-grid">
            <?php foreach ($dinnerPhotos as $img): ?>
                <div class="gallery-item">
                    <img src="assets/photos/dinner/thumbs/<?= h($img['filename']) ?>" alt="<?= h($img['caption']) ?>" loading="lazy">
                </div>
            <?php endforeach; ?>
        </div>
        <p class="text-center" style="margin-top:24px;">
            <a href="/gallery" class="btn btn-navy">View Full Gallery</a>
            <a href="/blog-post?slug=old-students-fundraising-dinner-2026" class="btn btn-outline" style="border-color:var(--navy); color:var(--navy);">Read the Full Story</a>
        </p>
    </div>
</section>

<section class="section-navy">
    <div class="container text-center">
        <span class="coming-soon-badge">Upcoming &middot; 19 September 2026</span>
        <h2>Diamond Jubilee Hall Fundraising Dinner</h2>
        <p style="max-width:600px;margin:0 auto 20px;color:rgba(255,255,255,0.85);">
            Old students and the Board of Governors invite you to a second fundraising
            dinner dedicated to completing the Diamond Jubilee Hall — a gift from Old
            Students to mark the school's 60 years.
        </p>
        <a href="/events" class="btn btn-gold">See Tickets &amp; Payment Details</a>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">60 Years</span>
            <h2>Our Journey So Far</h2>
        </div>
        <div class="timeline">
            <div class="timeline-item">
                <span class="year">1967</span>
                <h3>Founded on Land Gifted by the Kingdom of Kooki</h3>
                <p class="muted">Kakoma Secondary School opens its doors in Rakai District, on land given by the Kingdom of Kooki through the vision of founding families. Read the full story on <a href="/history">Our History</a>.</p>
            </div>
            <div class="timeline-item">
                <span class="year">Decades of Growth</span>
                <h3>Generations of "Labour for Success"</h3>
                <p class="muted">Thousands of students pass through Kakoma's gates, many rising to lead in education, government, business and beyond.</p>
            </div>
            <div class="timeline-item">
                <span class="year">2026</span>
                <h3>Entering the Diamond Jubilee Year</h3>
                <p class="muted">Under the leadership of Head Teacher Bbale David, Kakoma Secondary School enters its 60th anniversary year.</p>
            </div>
            <div class="timeline-item">
                <span class="year">15 Aug 2026</span>
                <h3>Old Students' Fundraising Dinner — Royal Suites, Bugolobi</h3>
                <p class="muted">Old students and friends of the school gather to launch fundraising for the Diamond Jubilee Hall Project.</p>
            </div>
            <div class="timeline-item">
                <span class="year">19 Sep 2026</span>
                <h3>Diamond Jubilee Hall Fundraising Dinner — Maple Leaf Hotel, Masaka</h3>
                <p class="muted">A second fundraising dinner, hosted by old students and the Board of Governors, dedicated to completing the Diamond Jubilee Hall — see full ticket and payment details on our <a href="/events">Events</a> page.</p>
            </div>
            <div class="timeline-item">
                <span class="year">14 Nov 2026</span>
                <h3>Diamond Jubilee Celebration</h3>
                <p class="muted">Kakoma Secondary School marks 60 years — full programme details coming soon on our <a href="/events">Events</a> page.</p>
            </div>
        </div>
    </div>
</section>

<section class="section-navy text-center">
    <div class="container">
        <span class="eyebrow" style="color:var(--gold-light);">Digital Magazine</span>
        <h2>60 Pages, One Story</h2>
        <p style="max-width:600px;margin:0 auto 20px;color:rgba(255,255,255,0.85);">
            Alongside this website, Thirdsan Enterprises is producing a 60-page Diamond Jubilee magazine — in print and digital editions — hosted right here on this site.
        </p>
        <a href="/magazine" class="btn btn-gold">Read the Digital Magazine</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

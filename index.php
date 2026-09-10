<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

$db = get_db();
$latestPosts = $db->query('SELECT * FROM posts WHERE published = 1 ORDER BY published_at DESC LIMIT 3')->fetchAll();
$nextEvent = $db->query("SELECT * FROM events ORDER BY event_date ASC LIMIT 1")->fetch();

$page_title = 'Home';
$page_description = 'Official website of Kakoma Secondary School, Rakai District, Uganda — celebrating 60 years of Labour for Success.';
$body_class = 'page-home';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="container">
        <span class="eyebrow">Diamond Jubilee &middot; 1967 &ndash; 2026</span>
        <h1>Kakoma at 60: Labour for Success</h1>
        <p class="lead">
            Sixty years of shaping young people from the Kingdom of Kooki and beyond.
            Join us as Kakoma Secondary School marks its Diamond Jubilee on
            <?= h(JUBILEE_DATE_LABEL) ?>.
        </p>

        <div id="jubileeCountdown" class="countdown" data-target="<?= h(JUBILEE_DATE) ?>">
            <div class="countdown__unit"><span class="countdown__num" data-unit="days">--</span><span class="countdown__label">Days</span></div>
            <div class="countdown__unit"><span class="countdown__num" data-unit="hours">--</span><span class="countdown__label">Hours</span></div>
            <div class="countdown__unit"><span class="countdown__num" data-unit="minutes">--</span><span class="countdown__label">Minutes</span></div>
            <div class="countdown__unit"><span class="countdown__num" data-unit="seconds">--</span><span class="countdown__label">Seconds</span></div>
        </div>

        <div class="hero-actions">
            <a href="magazine.php" class="btn btn-gold">Read the Digital Magazine</a>
            <a href="anniversary.php" class="btn btn-outline">Explore Kakoma at 60</a>
        </div>
    </div>
</section>

<section class="highlight-strip">
    <div class="container">
        <div class="grid grid-4">
            <div class="highlight-item"><span class="num">60</span><span class="label">Years of Labour for Success</span></div>
            <div class="highlight-item"><span class="num">1967</span><span class="label">Founded in Rakai District</span></div>
            <div class="highlight-item"><span class="num">1000s</span><span class="label">Old Students Worldwide</span></div>
            <div class="highlight-item"><span class="num">1</span><span class="label">Jubilee Hall Being Built</span></div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">From Student to Headteacher</span>
            <h2>A School Led by Its Own</h2>
            <p class="muted">Our current Head Teacher, Bbale David, is himself a Kakoma old student — a living example of what "Labour for Success" builds over a lifetime.</p>
        </div>
        <div class="grid grid-2" style="align-items:center;">
            <img src="assets/photos/dinner/headteacher-bbale-david.jpg" alt="Head Teacher Bbale David speaking at the Diamond Jubilee celebration" style="border-radius:var(--radius); box-shadow:var(--shadow);">
            <div>
                <p>Bbale David walked these same corridors as a student before returning to lead the school into its Diamond Jubilee decade. Read his message to the Kakoma family as we mark 60 years.</p>
                <a href="headteacher-message.php" class="btn btn-navy">Read the Head Teacher's Message</a>
            </div>
        </div>
    </div>
</section>

<?php if ($nextEvent): ?>
<section class="section-navy">
    <div class="container text-center">
        <span class="coming-soon-badge">Coming Soon</span>
        <h2><?= h($nextEvent['title']) ?></h2>
        <p style="max-width:600px;margin:0 auto 20px;color:rgba(255,255,255,0.85);"><?= h($nextEvent['description']) ?></p>
        <a href="events.php" class="btn btn-gold">See All Events</a>
    </div>
</section>
<?php endif; ?>

<section class="section-alt">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Recent Activities</span>
            <h2>From Our Blog</h2>
        </div>
        <div class="grid grid-3">
            <?php foreach ($latestPosts as $post): ?>
                <article class="card">
                    <?php if ($post['cover_image']): ?>
                        <img src="<?= h($post['cover_image']) ?>" alt="<?= h($post['title']) ?>">
                    <?php endif; ?>
                    <div class="card__body">
                        <span class="card__meta"><?= h(format_date($post['published_at'])) ?></span>
                        <h3><?= h($post['title']) ?></h3>
                        <p><?= h($post['excerpt']) ?></p>
                        <a class="read-more" href="blog-post.php?slug=<?= urlencode($post['slug']) ?>">Read more &rarr;</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section>
    <div class="container text-center">
        <div class="section-header">
            <span class="eyebrow">Digital Magazine</span>
            <h2>60 Pages Marking 60 Years</h2>
            <p class="muted">Our Diamond Jubilee magazine — print and digital editions — tells the Kakoma story in full. Read it online, anytime, anywhere.</p>
        </div>
        <a href="magazine.php" class="btn btn-gold">Open the Digital Magazine</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

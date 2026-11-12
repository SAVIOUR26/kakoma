<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

$db = get_db();
$latestPosts = $db->prepare('SELECT * FROM posts WHERE published = 1 AND published_at <= :now ORDER BY published_at DESC LIMIT 3');
$latestPosts->execute([':now' => date('Y-m-d H:i:s')]);
$latestPosts = $latestPosts->fetchAll();
$nextEvent = $db->prepare("SELECT * FROM events WHERE status != 'past' AND event_date >= :today ORDER BY event_date ASC LIMIT 1");
$nextEvent->execute([':today' => date('Y-m-d')]);
$nextEvent = $nextEvent->fetch();

// Jubilee state for the hero: before, on the day, after.
$today = date('Y-m-d');
$jubileeState = $today < JUBILEE_DATE ? 'before' : ($today === JUBILEE_DATE ? 'today' : 'after');

// Hero slides: students today and the Jubilee fundraising dinners (assets/photos/hero, large + small).
$heroSlides = [
    ['students-s5-s6', 'Kakoma students today, outside the S.5/S.6 block'],
    ['royal-suites-dinner', 'Old students and friends at the Jubilee fundraising dinner, Royal Suites, Bugolobi'],
    ['students-today-1', 'Kakoma students today'],
    ['school-assembly', 'Flags over the school compound, with students assembled'],
    ['masaka-dinner', 'Old students and friends at the fundraising dinner, Maple Leaf Hotel, Masaka'],
    ['students-today-2', 'Kakoma students today'],
    ['students-gathered', 'Kakoma students gathered in front of a classroom block'],
    ['pioneer-1968', 'Rukidi Gabigogo, who enrolled with the first students in 1968, at the fundraising dinner'],
];

$page_title = 'Home';
$page_description = 'Official website of Kakoma Secondary School, Rakai District, Uganda — celebrating 60 years of Labour for Success.';
$body_class = 'page-home';
require __DIR__ . '/includes/header.php';
?>

<section class="hero hero--jubilee" aria-label="Kakoma at 60">
    <style>
        .hero-slide--first { background-image: url('assets/photos/hero/<?= h($heroSlides[0][0]) ?>-sm.jpg'); }
        @media (min-width: 900px) { .hero-slide--first { background-image: url('assets/photos/hero/<?= h($heroSlides[0][0]) ?>.jpg'); } }
    </style>
    <div class="hero-slideshow" id="heroSlideshow" aria-hidden="true">
        <?php foreach ($heroSlides as $i => [$file, $caption]): ?>
            <div class="hero-slide<?= $i === 0 ? ' hero-slide--first is-active' : '' ?>"
                 data-src="assets/photos/hero/<?= h($file) ?>.jpg"
                 data-src-small="assets/photos/hero/<?= h($file) ?>-sm.jpg"
                 data-caption="<?= h($caption) ?>"></div>
        <?php endforeach; ?>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-confetti" id="heroConfetti" aria-hidden="true"></div>
    <?php foreach ([[6, 18, 0], [16, 72, 1.1], [44, 9, 2.2], [58, 90, 0.6], [80, 30, 1.7], [88, 62, 2.6], [30, 52, 3.1], [70, 14, 0.3]] as [$x, $y, $d]): ?>
        <svg class="hero-sparkle" style="left:<?= $x ?>%;top:<?= $y ?>%;animation-delay:<?= $d ?>s;" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 0l2.4 9.6L24 12l-9.6 2.4L12 24l-2.4-9.6L0 12l9.6-2.4z" fill="currentColor"/></svg>
    <?php endforeach; ?>

    <div class="hero-inner">
        <div class="hero-copy">
            <span class="hero-chip">Diamond Jubilee &middot; 1967 &ndash; 2026</span>
            <h1>Kakoma at <span class="gold-shimmer">60</span></h1>
            <p class="hero-tagline">Sixty years of Labour for Success</p>
            <?php if ($jubileeState === 'before'): ?>
                <p class="lead">Sixty years of shaping young people from Rakai District and beyond. Join us as Kakoma Secondary School celebrates its Diamond Jubilee on Saturday <?= h(JUBILEE_DATE_LABEL) ?>.</p>
                <div id="jubileeCountdown" class="countdown" data-target="<?= h(JUBILEE_DATE) ?>">
                    <?php foreach (['days' => 'Days', 'hours' => 'Hours', 'minutes' => 'Minutes', 'seconds' => 'Seconds'] as $unit => $label): ?>
                        <div class="countdown__unit"><span class="countdown__num" data-unit="<?= $unit ?>">--</span><span class="countdown__label"><?= $label ?></span></div>
                    <?php endforeach; ?>
                </div>
            <?php elseif ($jubileeState === 'today'): ?>
                <p class="lead">Today Kakoma Secondary School celebrates sixty years of Labour for Success, with old students, parents, staff, students and friends.</p>
                <span class="hero-note">Today &middot; New school playground, Kakoma SS</span>
            <?php else: ?>
                <p class="lead">On <?= h(JUBILEE_DATE_LABEL) ?>, Kakoma Secondary School celebrated sixty years of shaping young people from Rakai District and beyond. Thank you to everyone who celebrated with us.</p>
                <span class="hero-note">Celebrated <?= h(JUBILEE_DATE_LABEL) ?></span>
            <?php endif; ?>
            <div class="hero-actions">
                <a href="/magazine" class="btn btn-gold"><?= magazine_is_live() ? 'Read the Magazine' : 'Magazine &middot; online Sun 15 Nov' ?></a>
                <a href="/anniversary" class="btn btn-outline">Explore Kakoma at 60</a>
            </div>
        </div>

        <div class="hero-emblem" aria-hidden="true">
            <div class="emblem-glow"></div>
            <svg viewBox="0 0 400 400">
                <defs>
                    <path id="emblemTextPath" d="M200,200 m-172,0 a172,172 0 1,1 344,0 a172,172 0 1,1 -344,0"/>
                    <linearGradient id="emblemGold" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0" stop-color="#F6DE8D"/><stop offset="0.45" stop-color="#D4A017"/><stop offset="0.55" stop-color="#FFF3C4"/><stop offset="1" stop-color="#9C7A12"/>
                        <animate attributeName="x1" values="-1;1" dur="5s" repeatCount="indefinite"/>
                        <animate attributeName="x2" values="0;2" dur="5s" repeatCount="indefinite"/>
                    </linearGradient>
                    <radialGradient id="emblemCore" cx="0.5" cy="0.4" r="0.65">
                        <stop offset="0" stop-color="#1F5C93"/><stop offset="1" stop-color="#0B2843"/>
                    </radialGradient>
                </defs>
                <g class="emblem-ring">
                    <text font-family="Inter, Segoe UI, Arial, sans-serif" font-size="16" font-weight="700" letter-spacing="3" fill="#F0C93B">
                        <textPath href="#emblemTextPath" textLength="1070" lengthAdjust="spacing">DIAMOND JUBILEE &#9670; 1967 &#8211; 2026 &#9670; LABOUR FOR SUCCESS &#9670; KAKOMA SECONDARY SCHOOL &#9670;</textPath>
                    </text>
                </g>
                <g class="emblem-ring emblem-ring--reverse">
                    <circle cx="200" cy="200" r="150" fill="none" stroke="#F0C93B" stroke-width="2" stroke-dasharray="1 9" stroke-linecap="round" opacity="0.9"/>
                    <g fill="#F0C93B"><path d="M200 42l6 8-6 8-6-8z"/><path d="M200 342l6 8-6 8-6-8z"/><path d="M42 200l8-6 8 6-8 6z"/><path d="M342 200l8-6 8 6-8 6z"/></g>
                </g>
                <circle cx="200" cy="200" r="128" fill="url(#emblemCore)" stroke="url(#emblemGold)" stroke-width="5"/>
                <circle cx="200" cy="200" r="116" fill="none" stroke="#F0C93B" stroke-width="1" opacity="0.5"/>
                <text x="200" y="138" text-anchor="middle" font-family="Inter, Segoe UI, Arial, sans-serif" font-size="13" font-weight="800" letter-spacing="4" fill="#F6DE8D">DIAMOND JUBILEE</text>
                <text x="200" y="250" text-anchor="middle" font-family="Playfair Display, Georgia, serif" font-size="148" font-weight="800" fill="url(#emblemGold)">60</text>
                <text x="200" y="282" text-anchor="middle" font-family="Inter, Segoe UI, Arial, sans-serif" font-size="13" font-weight="700" letter-spacing="5" fill="#FFFFFF" opacity="0.9">1967 &#183; 2026</text>
            </svg>
        </div>
    </div>

    <div class="hero-footer">
        <p class="hero-caption" id="heroCaption"><?= h($heroSlides[0][1]) ?></p>
        <div class="hero-dots" id="heroDots" role="tablist" aria-label="Photos">
            <?php foreach ($heroSlides as $i => $slide): ?>
                <button type="button" class="<?= $i === 0 ? 'is-active' : '' ?>" aria-label="Photo <?= $i + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="highlight-strip">
    <div class="container">
        <div class="grid grid-4">
            <div class="highlight-item"><span class="num">60</span><span class="label">Years of Labour for Success</span></div>
            <div class="highlight-item"><span class="num">1967</span><span class="label">Founded in Rakai District</span></div>
            <div class="highlight-item"><span class="num">1000s</span><span class="label">Old Students Worldwide</span></div>
            <div class="highlight-item"><span class="num">1</span><span class="label">Diamond Hall Planned</span></div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Leading Into the Diamond Jubilee</span>
            <h2>A Message From Our Head Teacher</h2>
            <p class="muted">Mr. Bbaale David, Head Teacher, writes to the Kakoma family as the school marks sixty years of Labour for Success.</p>
        </div>
        <div class="grid grid-2" style="align-items:center;">
            <img src="assets/photos/people/headteacher-bbaale-david.jpg" alt="Mr. Bbaale David, Head Teacher" style="border-radius:var(--radius); box-shadow:var(--shadow);">
            <div>
                <p class="pull-quote">Labour for Success is not only our motto; it is our daily practice.</p>
                <p>Read the Head Teacher&rsquo;s message, and the Jubilee messages from HRH the Kamuswaga of Kooki, the Bishop of West Buganda Diocese, the Board Chairman and the Organising Committee.</p>
                <a href="/headteacher-message" class="btn btn-navy">Read the Head Teacher's Message</a>
                <a href="/messages" class="btn btn-gold">All Jubilee Messages</a>
            </div>
        </div>
    </div>
</section>

<?php if ($nextEvent): ?>
<section class="section-navy">
    <div class="container text-center">
        <span class="coming-soon-badge"><?= $nextEvent['status'] === 'coming_soon' ? 'Coming Soon' : 'Upcoming' ?></span>
        <span class="card__meta" style="color:rgba(255,255,255,0.7); display:block; margin-top:10px;"><?= h(format_date($nextEvent['event_date'])) ?></span>
        <h2><?= h($nextEvent['title']) ?></h2>
        <p style="max-width:600px;margin:0 auto 20px;color:rgba(255,255,255,0.85);"><?= h($nextEvent['description']) ?></p>
        <a href="/anniversary#programme" class="btn btn-gold">See the Programme</a>
        <a href="/events" class="btn btn-outline">All Events</a>
    </div>
</section>
<?php endif; ?>

<section class="section-alt">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Recent Activities</span>
            <h2>From Our Blog</h2>
        </div>
        <?php if (count($latestPosts) === 1): $post = $latestPosts[0]; ?>
            <article class="card card--feature">
                <?php if ($post['cover_image']): ?>
                    <a href="/blog-post?slug=<?= urlencode($post['slug']) ?>" class="card--feature__img"><img src="<?= h($post['cover_image']) ?>" alt="<?= h($post['title']) ?>" loading="lazy"></a>
                <?php endif; ?>
                <div class="card__body">
                    <span class="card__meta"><?= h(format_date($post['published_at'])) ?></span>
                    <h3><?= h($post['title']) ?></h3>
                    <p><?= h($post['excerpt']) ?></p>
                    <a class="btn btn-navy" href="/blog-post?slug=<?= urlencode($post['slug']) ?>">Read the story</a>
                </div>
            </article>
        <?php else: ?>
            <div class="grid grid-<?= max(2, count($latestPosts)) ?>">
                <?php foreach ($latestPosts as $post): ?>
                    <article class="card">
                        <?php if ($post['cover_image']): ?>
                            <img src="<?= h($post['cover_image']) ?>" alt="<?= h($post['title']) ?>" loading="lazy">
                        <?php endif; ?>
                        <div class="card__body">
                            <span class="card__meta"><?= h(format_date($post['published_at'])) ?></span>
                            <h3><?= h($post['title']) ?></h3>
                            <p><?= h($post['excerpt']) ?></p>
                            <a class="read-more" href="/blog-post?slug=<?= urlencode($post['slug']) ?>">Read more &rarr;</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <p class="text-center" style="margin:28px 0 0;"><a href="/blog" class="read-more">All news &amp; activities &rarr;</a></p>
    </div>
</section>

<section class="mag-promo">
    <div class="container">
        <div class="mag-promo__grid">
            <a href="/magazine" class="mag-promo__cover"><img src="assets/magazine-cover.jpg" alt="Front cover of Kakoma at Sixty" loading="lazy" width="420" height="594"></a>
            <div>
                <span class="eyebrow mag-promo__eyebrow">Digital Magazine</span>
                <h2>Kakoma at Sixty: 32 Pages, One Story</h2>
                <p>The Diamond Jubilee magazine tells the Kakoma story: the land and the founding families, ten head teachers, the old students and the journey ahead.</p>
                <p class="muted"><?= magazine_is_live() ? 'Read it online, page by page, or download it.' : 'Printed copies at the Jubilee on ' . h(JUBILEE_DATE_LABEL) . '. The digital edition opens here on ' . h(MAGAZINE_LAUNCH_LABEL) . '.' ?></p>
                <a href="/magazine" class="btn btn-gold"><?= h(magazine_cta()) ?></a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

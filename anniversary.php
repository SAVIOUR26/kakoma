<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/magazine.php';

$m = mag();
$prog = $m['programme'];
$ack = $m['acknowledgements'];
$jubileePassed = date('Y-m-d') > JUBILEE_DATE;

$dinnerPicks = [
    ['guest-of-honour-katikkiro-of-kooki.jpg', 'Royal Suites, Bugolobi'],
    ['fundraising-group-photo.jpg', 'Royal Suites, Bugolobi'],
    ['hall-project-board.jpg', 'Royal Suites, Bugolobi'],
    ['masaka-guest-of-honour-jamil-ssempijja.jpg', 'Maple Leaf Hotel, Masaka'],
    ['masaka-dinner-group-photo.jpg', 'Maple Leaf Hotel, Masaka'],
    ['masaka-samson-wamala-kakembo.jpg', 'Maple Leaf Hotel, Masaka'],
];
$captions = load_captions('dinner');

$timeline = [
    ['1938', 'A primary school at Kakoma', 'The Church at Kakoma runs a primary school, and many of its pupils finish with nowhere to go next.'],
    ['1965', 'Kakoma Junior Secondary School', 'A junior secondary school opens as an extension of the primary school, teaching Junior One to Junior Three.'],
    ['1967', 'Kakoma Secondary School is established', 'Kakoma Church of Uganda Parish gives 93 acres, land the Kingdom of Kooki had given to the Church long before, so that a secondary school can rise.'],
    ['1968', 'The first students enrol', 'Among them is Rukidi Gabigogo, who returned 58 years later to speak at the Diamond Jubilee fundraising dinner.'],
    ['1976', 'Government-aided', 'Kakoma becomes a government-aided school.'],
    ['1979', 'First national examination candidates', 'The first candidates sit their examinations under the East African Examinations Council, before UNEB was set up in 1980.'],
    ['1984', 'A-Level opens', 'The A-Level section opens with four students, one of whom, the late Muganga Kabiswa, joined Makerere.'],
    ['15 Aug 2026', 'Fundraising dinner, Royal Suites, Bugolobi', 'Guest of Honour: Owek. Kiwanuka Ahmed, Katikkiro of Kooki. The Diamond Jubilee Hall Project is launched.'],
    ['2026', 'Fundraising dinner, Maple Leaf Hotel, Masaka', 'Guest of Honour: Hajji Jamil Ssempijja.'],
    ['14 Nov 2026', 'The Diamond Jubilee', 'Sixty years of Labour for Success, celebrated at the school.'],
];

$page_title = 'Kakoma at 60';
$page_description = 'The Diamond Jubilee of Kakoma Secondary School, 14 November 2026: the programme, the fundraising dinners, our timeline, the Diamond Hall and the digital magazine.';
$page_image = 'assets/magazine-cover.jpg';
$body_class = 'page-anniversary';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Kakoma at 60</h1>
        <p>Diamond Jubilee &middot; <?= h(JUBILEE_DATE_LABEL) ?> &middot; <?= h($prog['venue']) ?></p>
    </div>
</section>

<?php if (!$jubileePassed): ?>
<section>
    <div class="container text-center">
        <div id="jubileeCountdown" class="countdown" data-target="<?= h(JUBILEE_DATE) ?>" style="color:var(--navy);">
            <?php foreach (['days' => 'Days', 'hours' => 'Hours', 'minutes' => 'Minutes', 'seconds' => 'Seconds'] as $unit => $label): ?>
                <div class="countdown__unit" style="background:var(--cream);border-color:var(--border);">
                    <span class="countdown__num" data-unit="<?= $unit ?>" style="color:var(--navy);">--</span>
                    <span class="countdown__label" style="color:var(--ink-soft);"><?= $label ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="muted">Until Kakoma Secondary School's Diamond Jubilee celebration.</p>
    </div>
</section>
<?php endif; ?>

<section class="section-alt" id="programme">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Saturday 14 November 2026</span>
            <h2>Jubilee Day Programme</h2>
            <p class="muted">
                Guest of Honour: <?= h($prog['guest']) ?><br>
                Thanksgiving service: <?= h($prog['celebrant']) ?><br>
                Patron: <?= h($prog['patron']) ?><br>
                Venue: <?= h($prog['venue']) ?>
            </p>
        </div>
        <table class="programme-table">
            <?php foreach ($prog['items'] as $item): ?>
                <tr>
                    <td><?= h($item['time']) ?></td>
                    <td><strong><?= h($item['item']) ?></strong><span class="who"><?= h($item['who']) ?></span></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Dining for a Diamond</span>
            <h2>The Fundraising Dinners</h2>
            <?php foreach ($m['dinners'] as $p): ?><p class="muted" style="max-width:720px;margin:0 auto;"><?= h($p) ?></p><?php endforeach; ?>
        </div>
        <div class="gallery-grid">
            <?php foreach ($dinnerPicks as [$file, $venue]): $cap = $captions[$file]['caption'] ?? $venue; ?>
                <figure class="gallery-item" style="margin:0;">
                    <img src="assets/photos/dinner/thumbs/<?= h($file) ?>" alt="<?= h($cap) ?>" loading="lazy">
                </figure>
            <?php endforeach; ?>
        </div>
        <p class="text-center" style="margin-top:24px;">
            <a href="/gallery" class="btn btn-navy">See all the photos</a>
            <a href="/blog-post?slug=old-students-fundraising-dinner-2026" class="btn btn-outline" style="border-color:var(--navy); color:var(--navy);">Read the story</a>
        </p>
    </div>
</section>

<section class="section-alt">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">1967 &ndash; 2026</span>
            <h2>Our Journey So Far</h2>
        </div>
        <div class="timeline">
            <?php foreach ($timeline as [$year, $title, $text]): ?>
                <div class="timeline-item">
                    <span class="year"><?= h($year) ?></span>
                    <h3><?= h($title) ?></h3>
                    <p class="muted"><?= h($text) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="text-center"><a class="btn btn-navy" href="/history">Read the full history</a></p>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Sixty Years On</span>
            <h2>Kakoma Today</h2>
        </div>
        <div class="grid grid-2" style="align-items:start;">
            <div class="prose" style="margin:0;">
                <?php foreach ($m['today'] as $p): ?><p><?= h($p) ?></p><?php endforeach; ?>
            </div>
            <figure style="margin:0;">
                <img src="assets/photos/campus/students-gathered.jpg" alt="Kakoma students gathered in front of a classroom block" style="border-radius:var(--radius);box-shadow:var(--shadow);" loading="lazy">
                <figcaption class="photo-caption">Kakoma students gathered in front of a classroom block.</figcaption>
            </figure>
        </div>

        <h3 style="margin-top:40px;"><?= h($m['teachers']['title']) ?></h3>
        <p class="muted"><?= h($m['teachers']['intro']) ?></p>
        <div class="grid grid-2">
            <?php foreach ($m['teachers']['people'] as $t): ?>
                <div class="card"><div class="card__body">
                    <h3><?= h($t['name']) ?></h3>
                    <span class="card__meta"><?= h($t['sub']) ?></span>
                    <p><?= h($t['text']) ?></p>
                </div></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-navy">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow" style="color:var(--gold-light);">The Journey Ahead</span>
            <h2>The Diamond Hall</h2>
        </div>
        <div class="grid grid-2" style="align-items:center;">
            <figure style="margin:0;">
                <img src="assets/photos/campus/diamond-hall-project-board.jpg" alt="The Diamond Jubilee Hall Project board, artist's impression" style="border-radius:var(--radius);" loading="lazy">
                <figcaption class="photo-caption" style="color:rgba(255,255,255,0.75);">From where we are to where we want to be. Artist&rsquo;s impression.</figcaption>
            </figure>
            <div>
                <?php foreach ($m['journey']['intro'] as $p): ?><p style="color:rgba(255,255,255,0.9);"><?= h($p) ?></p><?php endforeach; ?>
                <?php foreach ($m['journey']['ideas'] as $idea): ?>
                    <p style="color:rgba(255,255,255,0.8);font-style:italic;"><?= h($idea['text']) ?> <span style="font-style:normal;color:var(--gold-light);">&mdash; <?= h($idea['by']) ?></span></p>
                <?php endforeach; ?>
                <a href="/give" class="btn btn-gold">Support the Diamond Hall</a>
            </div>
        </div>
    </div>
</section>

<section id="acknowledgements">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">With Thanks</span>
            <h2>The People Behind the Jubilee</h2>
        </div>
        <div class="grid grid-2" style="max-width:980px;margin:0 auto;">
            <div>
                <h3>Diamond Jubilee Organising Committee</h3>
                <ul class="name-list" style="columns:1;">
                    <?php foreach ($ack['committee'] as $p): ?><li><strong><?= h($p['name']) ?></strong> &middot; <span class="muted"><?= h($p['role']) ?></span></li><?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h3>Board of Governors</h3>
                <ul class="name-list" style="columns:1;">
                    <?php foreach ($ack['board'] as $p): ?><li><strong><?= h($p['name']) ?></strong> &middot; <span class="muted"><?= h($p['role']) ?></span></li><?php endforeach; ?>
                </ul>
            </div>
        </div>
        <h3 class="text-center" style="margin-top:36px;">Founding Contributors</h3>
        <p class="text-center muted">The first to give to the Diamond Jubilee fund. Thank you for starting the journey.</p>
        <ul class="name-list text-center">
            <?php foreach ($ack['contributors'] as $name): ?><li><?= h($name) ?></li><?php endforeach; ?>
        </ul>
    </div>
</section>

<section class="section-navy text-center">
    <div class="container">
        <span class="eyebrow" style="color:var(--gold-light);">Digital Magazine</span>
        <h2>Kakoma at Sixty: 32 Pages, One Story</h2>
        <p style="max-width:600px;margin:0 auto 20px;color:rgba(255,255,255,0.85);">
            The Diamond Jubilee magazine, produced by Thirdsan Enterprises for the Organising Committee.
            <?= magazine_is_live() ? 'Read it online or download it.' : 'Printed copies at the celebration on ' . h(JUBILEE_DATE_LABEL) . '; the digital edition opens here on ' . h(MAGAZINE_LAUNCH_LABEL) . '.' ?>
        </p>
        <a href="/magazine" class="btn btn-gold"><?= h(magazine_cta()) ?></a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

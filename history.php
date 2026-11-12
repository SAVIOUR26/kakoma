<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/magazine.php';

$m = mag();
$history = $m['history'];
$families = $m['families'];
$ht = $m['headteachers'];

$page_title = 'Our History';
$page_description = 'How Kakoma Secondary School began: the land given by the Kingdom of Kooki to the Church at Kakoma, the 93 acres given by Kakoma Church of Uganda Parish in 1967, the founding families, the eras and the ten head teachers.';
$page_image = 'assets/photos/people/livingstone-kintu-mwanje.jpg';
$body_class = 'page-history';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Our History</h1>
        <p>From a gift of land to a Diamond Jubilee &middot; 1967&ndash;2026</p>
    </div>
</section>

<section>
    <div class="container prose">
        <h2 class="mt-0">How It Began</h2>
        <figure style="margin:0 0 20px;">
            <img src="assets/photos/people/livingstone-kintu-mwanje.jpg" alt="Livingstone Kintu Mwanje" style="margin:0;" loading="lazy">
            <figcaption class="photo-caption">Livingstone Kintu Mwanje, a former PTA chairman who studied at Kakoma in 1969 and has seen every head teacher since.</figcaption>
        </figure>
        <?php foreach ($history['opening'] as $p): ?><p><?= h($p) ?></p><?php endforeach; ?>

        <h2>The Land</h2>
        <?php foreach ($history['land'] as $p): ?><p><?= h($p) ?></p><?php endforeach; ?>
        <p class="form-note">This is the account kept by the family of Blasio Kisuule Mugenyi in his diary. Kakoma Church of Uganda Parish gave the 93 acres on which the school was founded in 1967.</p>
    </div>
</section>

<section class="section-alt">
    <div class="container prose">
        <h2 class="mt-0">The Founding Families</h2>
        <?php foreach (['kisuule', 'nabulime'] as $key): $person = $families[$key]; ?>
            <h3><?= h($person['name']) ?> <span class="muted" style="font-weight:400;font-size:0.9em;">&middot; <?= h($person['sub']) ?></span></h3>
            <?php if ($key === 'kisuule'): ?>
                <img src="assets/photos/archive/blasio-kisuule-mugenyi.jpg" alt="Blasio Kisuule Mugenyi" style="max-width:220px;" loading="lazy">
            <?php else: ?>
                <figure style="margin:0 0 16px;">
                    <img src="assets/photos/archive/student-card-1972.jpg" alt="Nabulime Joyce's Kakoma student card, 1972" style="max-width:420px;margin:0;" loading="lazy">
                    <figcaption class="photo-caption">Her Kakoma student card, stamped 1 December 1972 and signed by Mr. Kayongo.</figcaption>
                </figure>
            <?php endif; ?>
            <?php foreach ($person['paras'] as $p): ?><p><?= h($p) ?></p><?php endforeach; ?>
        <?php endforeach; ?>
        <?php foreach ($families['others'] as $o): ?>
            <h3><?= h($o['name']) ?></h3>
            <p><?= h($o['text']) ?></p>
        <?php endforeach; ?>
        <?php foreach ($families['legacy'] as $p): ?><p><em><?= h($p) ?></em></p><?php endforeach; ?>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Sixty Years</span>
            <h2>The Eras of Kakoma</h2>
        </div>
        <div class="timeline">
            <?php foreach ($history['eras'] as $era): ?>
                <div class="timeline-item">
                    <span class="year"><?= h($era['years']) ?></span>
                    <h3><?= h($era['title']) ?></h3>
                    <p class="muted"><?= h($era['text']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-alt" id="head-teachers">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Leadership</span>
            <h2>Head Teachers Through the Years</h2>
            <p class="muted">Ten head teachers have led Kakoma since 1967. Each brought the school through its own season, from the founding years to the Diamond Jubilee.</p>
        </div>
        <ol class="ht-list">
            <?php foreach ($ht['list'] as $t): ?>
                <li><span class="ht-name"><?= h($t['name']) ?></span><span class="ht-years"><?= h($t['years']) ?></span></li>
            <?php endforeach; ?>
        </ol>

        <div class="prose" style="margin-top:48px;">
            <h3><?= h($ht['feature_title']) ?></h3>
            <p class="pull-quote" style="font-size:1.05rem;"><?= h($ht['feature_dek']) ?></p>
            <?php foreach ($ht['feature'] as $p): ?><p><?= h($p) ?></p><?php endforeach; ?>
            <?php foreach ($ht['eyewitness'] as $p): ?><p><em><?= h($p) ?></em></p><?php endforeach; ?>
            <div class="grid grid-2" style="margin-top:12px;">
                <figure style="margin:0;">
                    <img src="assets/photos/archive/kayongo-namutamba-certificate.jpg" alt="Namutamba TTC certificate of thanks" style="margin:0;" loading="lazy">
                    <figcaption class="photo-caption">Certificate of thanks from the Namutamba TTC Old Students Club, for his service as Principal, 1945&ndash;1959.</figcaption>
                </figure>
                <figure style="margin:0;">
                    <img src="assets/photos/archive/kayongo-coronation-medal-letter.jpg" alt="Buckingham Palace letter, 1953" style="margin:0;max-width:320px;" loading="lazy">
                    <figcaption class="photo-caption">The 1953 letter from Buckingham Palace forwarding his Coronation Medal.</figcaption>
                </figure>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container prose">
        <h2 class="mt-0">Labour for Success</h2>
        <p class="pull-quote"><?= h($history['appeal']['text']) ?><br><span style="font-size:0.85rem;font-style:normal;">&mdash; <?= h($history['appeal']['by']) ?></span></p>
        <p>
            Through every era, one thread has held: the motto <strong>&ldquo;Labour for Success&rdquo;</strong>,
            which Kakoma&rsquo;s old students carry with them long after they leave the school.
        </p>
        <p class="form-note">
            This history is drawn from &ldquo;Kakoma at Sixty&rdquo;, the Diamond Jubilee magazine
            (<a href="/magazine">read it online</a>). Some names and dates are still being gathered.
            Have photos, documents or memories to add? <a href="/contact">Get in touch</a>, or
            <a href="/alumni#register">join the Old Students directory</a>.
        </p>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

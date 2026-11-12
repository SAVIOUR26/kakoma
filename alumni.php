<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/magazine.php';

$db = get_db();
$mag = mag();
$testimonies = $db->query("SELECT * FROM alumni WHERE approved = 1 ORDER BY featured DESC, submitted_at DESC")->fetchAll();

$page_title = 'Old Students / Alumni';
$page_description = 'Kakoma old students: the 1968 pioneers, voices and memories, where they are now, and the Old Students directory.';
$page_image = 'assets/photos/people/rukidi-gabigogo.jpg';
$body_class = 'page-alumni';
require __DIR__ . '/includes/header.php';

$success = flash_get('alumni_success');
$error = flash_get('alumni_error');
?>

<section class="page-header">
    <div class="container">
        <h1>Old Students / Alumni</h1>
        <p>Sixty years of Kakoma old students, worldwide</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="grid grid-2" style="align-items:center;max-width:980px;margin:0 auto;">
            <figure style="margin:0;">
                <img src="assets/photos/people/rukidi-gabigogo.jpg" alt="Rukidi Gabigogo at the Diamond Jubilee fundraising dinner" style="border-radius:var(--radius);box-shadow:var(--shadow);" loading="lazy">
            </figure>
            <div>
                <span class="eyebrow" style="color:var(--gold);font-weight:700;text-transform:uppercase;letter-spacing:.08em;font-size:.8rem;">Where It All Began</span>
                <h2>Rukidi Gabigogo, 1968</h2>
                <?php foreach ($mag['pioneer'] as $p): ?><p><?= h($p) ?></p><?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="section-alt">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">In Their Words</span>
            <h2>Voices &amp; Memories</h2>
            <p class="muted">From the &ldquo;Share Your Kakoma Story&rdquo; forms filled in by old students at the fundraising dinners.</p>
        </div>
        <div class="grid grid-3">
            <?php foreach ($mag['voices'] as $v): ?>
                <div class="card alumni-card">
                    <p class="quote">&ldquo;<?= h($v['quote']) ?>&rdquo;</p>
                    <p class="name"><?= h($v['name']) ?></p>
                    <p class="role"><?= h($v['years']) ?><?= !empty($v['now']) ? ' &middot; ' . h($v['now']) : '' ?></p>
                </div>
            <?php endforeach; ?>
            <?php foreach ($testimonies as $alum): ?>
                <div class="card alumni-card">
                    <?php if (!empty($alum['quote'])): ?>
                        <p class="quote">&ldquo;<?= h($alum['quote']) ?>&rdquo;</p>
                    <?php endif; ?>
                    <p class="name"><?= h($alum['full_name']) ?></p>
                    <p class="role">
                        <?= h($alum['class_year'] ? 'Class of ' . $alum['class_year'] : '') ?>
                        <?= $alum['class_year'] && $alum['current_role'] ? ' &middot; ' : '' ?>
                        <?= h($alum['current_role']) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Labour for Success</span>
            <h2>Old Students: Where Are They Now</h2>
            <p class="muted">A roll of honour of Kakoma old students, from the Organising Committee&rsquo;s list and the old students&rsquo; own story forms.</p>
        </div>
        <div class="roll-grid">
            <?php foreach ($mag['roll'] as $r): ?>
                <div>
                    <div class="name"><?= h($r['name']) ?></div>
                    <div class="meta"><?= $r['years'] !== '—' ? h($r['years']) . ' &middot; ' : '' ?><?= h($r['now']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="text-center form-note" style="margin-top:20px;">Are you an old student? Add your name and story below.</p>
    </div>
</section>

<section class="section-alt" id="register">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Join the Directory</span>
            <h2>Register as an Old Student</h2>
            <p class="muted">Help us grow our Old Students directory — it only takes a minute.</p>
        </div>

        <div class="form-box">
            <?php if ($success): ?><div class="alert alert-success"><?= h($success) ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-error"><?= h($error) ?></div><?php endif; ?>

            <form action="/alumni-register" method="post">
                <div class="field">
                    <label for="full_name">Full Name *</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                <div class="grid grid-2">
                    <div class="field">
                        <label for="class_year">Class Year</label>
                        <input type="text" id="class_year" name="class_year" placeholder="e.g. 1998">
                    </div>
                    <div class="field">
                        <label for="current_role">Current Role / Occupation</label>
                        <input type="text" id="current_role" name="current_role" placeholder="e.g. Teacher, Engineer...">
                    </div>
                </div>
                <div class="grid grid-2">
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="field">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                </div>
                <div class="field">
                    <label for="quote">Your Kakoma Story / Quote</label>
                    <textarea id="quote" name="quote" placeholder="Share a memory, message, or word of encouragement for current students..."></textarea>
                </div>
                <button type="submit" class="btn btn-navy btn-block">Submit My Registration</button>
                <p class="form-note" style="margin-top:12px;">
                    Submissions are reviewed by the school before appearing publicly on this page.
                </p>
            </form>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

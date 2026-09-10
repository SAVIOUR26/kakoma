<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

$db = get_db();
$testimonies = $db->query("SELECT * FROM alumni WHERE approved = 1 ORDER BY featured DESC, submitted_at DESC")->fetchAll();

$page_title = 'Old Students / Alumni';
$page_description = 'Meet Kakoma old students, read their testimonies, and register to join our growing Old Students directory.';
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
        <div class="section-header">
            <span class="eyebrow">In Their Words</span>
            <h2>Testimonies from Our Old Students</h2>
            <p class="muted">Gathered at our fundraising dinner and during our Rakai field visits.</p>
        </div>

        <?php if ($testimonies): ?>
            <div class="grid grid-3">
                <?php foreach ($testimonies as $alum): ?>
                    <div class="card alumni-card">
                        <?php if (!empty($alum['photo'])): ?>
                            <img src="<?= h($alum['photo']) ?>" alt="<?= h($alum['full_name']) ?>">
                        <?php else: ?>
                            <div class="avatar-fallback"><?= h(strtoupper(substr($alum['full_name'], 0, 1))) ?></div>
                        <?php endif; ?>
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
        <?php else: ?>
            <p class="text-center muted">
                Testimonies from our Old Students' fundraising dinner and Rakai field trip
                are being compiled and will appear here shortly. Meanwhile, see photos from
                the dinner in our <a href="gallery.php">gallery</a>, or add your own story
                using the form below.
            </p>
        <?php endif; ?>
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

            <form action="alumni-register.php" method="post">
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

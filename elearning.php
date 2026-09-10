<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

$page_title = 'E-Learning — Coming Soon';
$page_description = 'Kakoma Secondary School is bringing e-learning to students, in partnership with elibrary.africa. Register your interest.';
$body_class = 'page-elearning';
require __DIR__ . '/includes/header.php';

$success = flash_get('elearning_success');
$error = flash_get('elearning_error');
?>

<section class="page-header">
    <div class="container">
        <span class="coming-soon-badge">Coming Soon</span>
        <h1>E-Learning at Kakoma</h1>
        <p>Bringing digital learning resources to our students</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="grid grid-2" style="align-items:center;">
            <div>
                <h2>A New Way to Learn</h2>
                <p>
                    Kakoma Secondary School is working on an e-learning offering for our
                    students, in partnership with <strong>elibrary.africa</strong>. This will
                    give students access to digital learning resources alongside their
                    regular studies — details on scope, timing and access will be shared here
                    as they're finalized.
                </p>
                <p class="muted">Leave your email or phone number below and we'll notify you as soon as this launches.</p>
            </div>
            <div class="form-box">
                <?php if ($success): ?><div class="alert alert-success"><?= h($success) ?></div><?php endif; ?>
                <?php if ($error): ?><div class="alert alert-error"><?= h($error) ?></div><?php endif; ?>
                <form action="elearning-interest.php" method="post">
                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name">
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="field">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <button type="submit" class="btn btn-navy btn-block">Notify Me When It's Ready</button>
                    <p class="form-note" style="margin-top:12px;">Please provide at least an email or phone number.</p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';

$page_title = 'Contact';
$page_description = 'Get in touch with Kakoma Secondary School — address, phone, email, and social media.';
$body_class = 'page-contact';
require __DIR__ . '/includes/header.php';

$success = flash_get('contact_success');
$error = flash_get('contact_error');
?>

<section class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="grid grid-2" style="align-items:start;">
            <div class="form-box">
                <?php if ($success): ?><div class="alert alert-success"><?= h($success) ?></div><?php endif; ?>
                <?php if ($error): ?><div class="alert alert-error"><?= h($error) ?></div><?php endif; ?>

                <form action="/contact-handler" method="post">
                    <div class="field">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="field">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="field">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-navy btn-block">Send Message</button>
                </form>
            </div>

            <div>
                <h3>Visit or Write to Us</h3>
                <p><?= h(SCHOOL_ADDRESS) ?></p>
                <p><strong>Phone:</strong> <a href="tel:<?= h(SCHOOL_PHONE) ?>"><?= h(SCHOOL_PHONE) ?></a></p>
                <p><strong>Email:</strong> <a href="mailto:<?= h(SCHOOL_EMAIL) ?>"><?= h(SCHOOL_EMAIL) ?></a></p>

                <div style="border-radius:var(--radius); overflow:hidden; box-shadow:var(--shadow); margin-top:20px;">
                    <iframe
                        title="Map to Kakoma Secondary School"
                        src="https://www.google.com/maps?q=<?= urlencode(SCHOOL_MAP_QUERY) ?>&output=embed"
                        width="100%" height="300" style="border:0;" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <p class="form-note" style="margin-top:10px;">Map location is approximate and will be refined with exact GPS coordinates.</p>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

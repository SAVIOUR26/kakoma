</main>

<footer class="site-footer">
    <div class="site-footer__inner">
        <div class="footer-col footer-col--brand">
            <img src="assets/logo/kakoma-crest.jpg" alt="Kakoma S.S. crest" class="footer-crest">
            <p class="footer-name"><?= h(SITE_NAME) ?></p>
            <p class="footer-motto">&ldquo;<?= h(SITE_MOTTO) ?>&rdquo;</p>
            <p class="footer-copy">&copy; <?= date('Y') ?> Kakoma Secondary School. Diamond Jubilee 1967&ndash;2026.</p>
        </div>

        <div class="footer-col">
            <h4>Explore</h4>
            <ul>
                <li><a href="anniversary.php">Kakoma at 60</a></li>
                <li><a href="history.php">Our History</a></li>
                <li><a href="alumni.php">Old Students</a></li>
                <li><a href="magazine.php">Digital Magazine</a></li>
                <li><a href="blog.php">Blog</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Get in Touch</h4>
            <ul>
                <li><?= h(SCHOOL_ADDRESS) ?></li>
                <li><a href="tel:<?= h(SCHOOL_PHONE) ?>"><?= h(SCHOOL_PHONE) ?></a></li>
                <li><a href="mailto:<?= h(SCHOOL_EMAIL) ?>"><?= h(SCHOOL_EMAIL) ?></a></li>
            </ul>
            <?php
            $socials = [
                'Facebook' => SOCIAL_FACEBOOK,
                'Twitter' => SOCIAL_TWITTER,
                'Instagram' => SOCIAL_INSTAGRAM,
                'YouTube' => SOCIAL_YOUTUBE,
                'WhatsApp' => SOCIAL_WHATSAPP,
            ];
            $activeSocials = array_filter($socials);
            ?>
            <?php if ($activeSocials): ?>
            <div class="footer-social">
                <?php foreach ($activeSocials as $label => $url): ?>
                    <a href="<?= h($url) ?>" target="_blank" rel="noopener"><?= h($label) ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="footer-col">
            <h4>Coming Soon</h4>
            <ul>
                <li><a href="elearning.php">E-Learning</a></li>
                <li><a href="admissions.php">Academics &amp; Admissions</a></li>
                <li><a href="give.php">Give / Support</a></li>
            </ul>
        </div>
    </div>
    <div class="site-footer__bottom">
        Built by Thirdsan Enterprises for the Kakoma Diamond Jubilee.
    </div>
</footer>

<script src="assets/js/main.js"></script>
</body>
</html>

<?php $current = current_page(); ?>
<header class="site-header">
    <div class="site-header__inner">
        <a href="index.php" class="brand">
            <img src="assets/logo/kakoma-crest.jpg" alt="Kakoma S.S. crest" class="brand__crest">
            <span class="brand__text">
                <span class="brand__name">Kakoma Secondary School</span>
                <span class="brand__motto"><?= h(SITE_MOTTO) ?></span>
            </span>
        </a>

        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        <nav class="site-nav" id="siteNav">
            <ul>
                <?php foreach ($GLOBALS['NAV_ITEMS'] as $item): ?>
                    <li>
                        <a href="<?= h($item['href']) ?>" class="<?= $current === $item['href'] ? 'is-active' : '' ?>">
                            <?= h($item['label']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</header>

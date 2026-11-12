<?php
$current = current_page();
$navMain = array_filter($GLOBALS['NAV_ITEMS'], fn($i) => empty($i['group']) && empty($i['cta']));
$navMore = array_filter($GLOBALS['NAV_ITEMS'], fn($i) => ($i['group'] ?? '') === 'more');
$navCta = array_values(array_filter($GLOBALS['NAV_ITEMS'], fn($i) => !empty($i['cta'])))[0] ?? null;
$moreActive = in_array($current, array_column($navMore, 'page'), true);
?>
<header class="site-header" id="siteHeader">
    <div class="site-header__inner">
        <a href="/" class="brand" aria-label="Kakoma Secondary School, home">
            <img src="assets/logo/kakoma-crest.svg" alt="" class="brand__crest" width="48" height="48">
            <span class="brand__text">
                <span class="brand__name">Kakoma Secondary School</span>
                <span class="brand__motto"><?= h(SITE_MOTTO) ?> &middot; Est. 1967</span>
            </span>
        </a>

        <nav class="site-nav" id="siteNav" aria-label="Main">
            <ul class="site-nav__list">
                <?php foreach ($navMain as $item): ?>
                    <li><a href="<?= h($item['href']) ?>" class="<?= $current === $item['page'] ? 'is-active' : '' ?>"<?= $current === $item['page'] ? ' aria-current="page"' : '' ?>><?= h($item['label']) ?></a></li>
                <?php endforeach; ?>
                <?php if ($navMore): ?>
                    <li class="nav-more" id="navMore">
                        <button type="button" class="nav-more__toggle<?= $moreActive ? ' is-active' : '' ?>" aria-expanded="false" aria-controls="navMoreMenu">
                            More <svg width="10" height="10" viewBox="0 0 10 10" aria-hidden="true"><path d="M1 3l4 4 4-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                        </button>
                        <ul class="nav-more__menu" id="navMoreMenu">
                            <?php foreach ($navMore as $item): ?>
                                <li><a href="<?= h($item['href']) ?>" class="<?= $current === $item['page'] ? 'is-active' : '' ?>"><?= h($item['label']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <?php if ($navCta): ?>
                <a href="<?= h($navCta['href']) ?>" class="nav-cta<?= $current === $navCta['page'] ? ' is-active' : '' ?>">
                    <svg width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5C6.5 4 9.5 4 12 6c2.5-2 5.5-2 8-.5V19c-2.5-1.5-5.5-1.5-8 .5-2.5-2-5.5-2-8-.5z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M12 6v13.5" stroke="currentColor" stroke-width="2"/></svg>
                    <?= h($navCta['label']) ?>
                </a>
            <?php endif; ?>
        </nav>

        <button class="nav-toggle" id="navToggle" aria-label="Open menu" aria-expanded="false" aria-controls="siteNav">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

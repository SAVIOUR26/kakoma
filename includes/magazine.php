<?php
/**
 * Helpers for text taken from the printed Diamond Jubilee magazine
 * (see includes/magazine-content.php).
 */

function mag(): array
{
    static $content = null;
    if ($content === null) {
        $content = require __DIR__ . '/magazine-content.php';
    }
    return $content;
}

/** Messages in protocol order: HRH, the Bishop, the Board Chairman, the Organising Committee Chairman, the Head Teacher. */
function mag_messages(): array
{
    $photos = [
        'royal' => 'assets/photos/people/hrh-kamuswaga.jpg',
        'bishop' => 'assets/photos/people/bishop-gaster-nsereko.jpg',
        'board' => 'assets/photos/people/board-chairman.jpg',
        'committee' => 'assets/photos/people/dr-isaac-nsereko.jpg',
        'headteacher' => 'assets/photos/people/headteacher-bbaale-david.jpg',
    ];
    $out = [];
    foreach (mag()['messages'] as $m) {
        $m['photo'] = $photos[$m['key']] ?? null;
        $out[$m['key']] = $m;
    }
    return $out;
}

function render_message(array $m, bool $showTitle = true): void
{
    ?>
    <article class="message-block" id="<?= h($m['key']) ?>">
        <div class="message-block__head">
            <div class="message-block__photo">
                <?php if ($m['photo']): ?>
                    <img src="<?= h($m['photo']) ?>" alt="<?= h($m['author']) ?>" loading="lazy">
                <?php endif; ?>
                <p class="message-block__name"><?= h($m['author']) ?><br><span class="muted" style="font-weight:400;"><?= h($m['role']) ?></span></p>
            </div>
            <div>
                <?php if ($showTitle): ?><h2><?= h($m['title']) ?></h2><?php endif; ?>
                <?php if ($m['pull']): ?><p class="pull-quote"><?= h($m['pull']) ?></p><?php endif; ?>
                <?php foreach ($m['paras'] as $p): ?>
                    <p><?= h($p) ?></p>
                <?php endforeach; ?>
                <p><em>&mdash; <?= h($m['author']) ?>, <?= h($m['role']) ?></em></p>
            </div>
        </div>
    </article>
    <?php
}

<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

$db = get_db();
$events = $db->query("SELECT * FROM events ORDER BY event_date ASC")->fetchAll();

$page_title = 'Events';
$page_description = 'Upcoming events at Kakoma Secondary School, including the Diamond Jubilee celebration.';
$body_class = 'page-events';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Events</h1>
        <p>What's coming up at Kakoma</p>
    </div>
</section>

<section>
    <div class="container">
        <?php if ($events): ?>
            <div class="grid grid-3">
                <?php foreach ($events as $event): ?>
                    <div class="card">
                        <div class="card__body">
                            <?php if ($event['status'] === 'coming_soon'): ?>
                                <span class="coming-soon-badge">Coming Soon</span>
                            <?php endif; ?>
                            <span class="card__meta"><?= h(format_date($event['event_date'])) ?></span>
                            <h3><?= h($event['title']) ?></h3>
                            <p><?= h($event['description']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center muted">No events scheduled at the moment — check back soon.</p>
        <?php endif; ?>

        <p class="text-center muted" style="margin-top:32px;">
            Full programme details for the Diamond Jubilee celebration will be published here as they're confirmed.
        </p>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

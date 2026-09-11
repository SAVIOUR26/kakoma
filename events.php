<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

$db = get_db();
$allEvents = $db->query("SELECT * FROM events ORDER BY event_date ASC")->fetchAll();

$upcomingEvents = array_filter($allEvents, fn($e) => $e['status'] !== 'past');
$pastEvents = array_filter($allEvents, fn($e) => $e['status'] === 'past');

$page_title = 'Events';
$page_description = 'Upcoming and past events at Kakoma Secondary School, including the Diamond Jubilee Hall fundraising dinners and the Diamond Jubilee celebration itself.';
$body_class = 'page-events';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Events</h1>
        <p>What's coming up — and what's already happened — at Kakoma</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Upcoming</span>
            <h2>Save the Date</h2>
        </div>

        <?php if ($upcomingEvents): ?>
            <div class="event-list">
                <?php foreach ($upcomingEvents as $event): ?>
                    <article class="card event-card">
                        <div class="card__body">
                            <?php if ($event['status'] === 'coming_soon'): ?>
                                <span class="coming-soon-badge">Coming Soon</span>
                            <?php else: ?>
                                <span class="coming-soon-badge">Upcoming</span>
                            <?php endif; ?>
                            <span class="card__meta"><?= h(format_date($event['event_date'])) ?></span>
                            <h3><?= h($event['title']) ?></h3>
                            <p><?= h($event['description']) ?></p>
                            <?php if (!empty($event['details_html'])): ?>
                                <?= $event['details_html'] /* admin-authored HTML, not raw user input */ ?>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center muted">No upcoming events scheduled at the moment — check back soon.</p>
        <?php endif; ?>

        <p class="text-center muted" style="margin-top:32px;">
            Full programme details for the Diamond Jubilee celebration will be published here as they're confirmed.
        </p>
    </div>
</section>

<?php if ($pastEvents): ?>
<section class="section-alt">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Past</span>
            <h2>Recent Events</h2>
        </div>
        <div class="grid grid-3">
            <?php foreach ($pastEvents as $event): ?>
                <div class="card">
                    <div class="card__body">
                        <span class="card__meta"><?= h(format_date($event['event_date'])) ?></span>
                        <h3><?= h($event['title']) ?></h3>
                        <p><?= h($event['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

$db = get_db();
$posts = $db->query("SELECT * FROM posts WHERE published = 1 ORDER BY published_at DESC")->fetchAll();

$page_title = 'Blog / Recent Activities';
$page_description = 'Recent activities at Kakoma Secondary School — starting with the Old Students\' fundraising dinner.';
$body_class = 'page-blog';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Blog / Recent Activities</h1>
        <p>What's happening at Kakoma, as it happens</p>
    </div>
</section>

<section>
    <div class="container">
        <?php if ($posts): ?>
            <div class="grid grid-3">
                <?php foreach ($posts as $post): ?>
                    <article class="card">
                        <?php if ($post['cover_image']): ?>
                            <img src="<?= h($post['cover_image']) ?>" alt="<?= h($post['title']) ?>">
                        <?php endif; ?>
                        <div class="card__body">
                            <span class="card__meta"><?= h(format_date($post['published_at'])) ?></span>
                            <h3><?= h($post['title']) ?></h3>
                            <p><?= h($post['excerpt']) ?></p>
                            <a class="read-more" href="/blog-post?slug=<?= urlencode($post['slug']) ?>">Read more &rarr;</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center muted">No posts yet — check back soon.</p>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

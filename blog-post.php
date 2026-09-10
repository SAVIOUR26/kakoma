<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

$db = get_db();
$slug = $_GET['slug'] ?? '';
$stmt = $db->prepare('SELECT * FROM posts WHERE slug = :slug AND published = 1');
$stmt->execute([':slug' => $slug]);
$post = $stmt->fetch();

if (!$post) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$page_title = $post['title'];
$page_description = $post['excerpt'];
$body_class = 'page-blog-post';
require __DIR__ . '/includes/header.php';

$shareUrl = SITE_URL . '/blog-post.php?slug=' . urlencode($post['slug']);
?>

<section class="page-header">
    <div class="container">
        <div class="breadcrumb"><a href="blog.php">&larr; Back to Blog</a></div>
        <h1><?= h($post['title']) ?></h1>
        <p><?= h(format_date($post['published_at'])) ?></p>
    </div>
</section>

<section>
    <div class="container prose">
        <?php if ($post['cover_image']): ?>
            <img src="<?= h($post['cover_image']) ?>" alt="<?= h($post['title']) ?>">
        <?php endif; ?>

        <?= $post['body'] /* admin-authored HTML, not raw user input */ ?>

        <div class="social-share">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($shareUrl) ?>" target="_blank" rel="noopener">Share on Facebook</a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode($shareUrl) ?>&text=<?= urlencode($post['title']) ?>" target="_blank" rel="noopener">Share on X</a>
            <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' — ' . $shareUrl) ?>" target="_blank" rel="noopener">Share on WhatsApp</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

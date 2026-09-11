<?php
require __DIR__ . '/includes/bootstrap.php';
require_admin_login();

$db = get_db();

if (isset($_GET['delete'])) {
    $db->prepare('DELETE FROM posts WHERE id = :id')->execute([':id' => (int) $_GET['delete']]);
    flash_set('admin_success', 'Post deleted.');
    header('Location: /admin/posts');
    exit;
}

$posts = $db->query('SELECT * FROM posts ORDER BY published_at DESC')->fetchAll();

$page_title = 'Blog Posts';
$active = 'posts';
require __DIR__ . '/includes/layout-header.php';
?>

<p style="margin-bottom:18px;"><a href="/admin/post-edit" class="btn btn-navy">+ New Post</a></p>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr><th>Title</th><th>Published</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= h($post['title']) ?></td>
                    <td><?= h(format_date($post['published_at'])) ?></td>
                    <td>
                        <?php if ($post['published']): ?>
                            <span class="badge badge-yes">Published</span>
                        <?php else: ?>
                            <span class="badge badge-no">Draft</span>
                        <?php endif; ?>
                    </td>
                    <td class="action-links">
                        <a href="/admin/post-edit?id=<?= (int) $post['id'] ?>">Edit</a>
                        <a href="/blog-post?slug=<?= urlencode($post['slug']) ?>" target="_blank">View</a>
                        <a href="/admin/posts?delete=<?= (int) $post['id'] ?>" class="danger" onclick="return confirm('Delete this post?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$posts): ?>
                <tr><td colspan="4" class="muted">No posts yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/includes/layout-footer.php'; ?>

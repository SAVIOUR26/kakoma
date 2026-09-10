<?php
require __DIR__ . '/includes/bootstrap.php';
require_admin_login();

$db = get_db();
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$post = null;
if ($id) {
    $stmt = $db->prepare('SELECT * FROM posts WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $post = $stmt->fetch();
    if (!$post) {
        flash_set('admin_error', 'Post not found.');
        header('Location: posts.php');
        exit;
    }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $coverImage = trim($_POST['cover_image'] ?? '');
    $published = isset($_POST['published']) ? 1 : 0;
    $publishedAt = trim($_POST['published_at'] ?? '') ?: date('Y-m-d H:i:s');
    $slugInput = trim($_POST['slug'] ?? '');

    if ($title === '') {
        $errors[] = 'Title is required.';
    }
    if ($body === '') {
        $errors[] = 'Body is required.';
    }

    $slug = $slugInput !== '' ? slugify($slugInput) : slugify($title);

    if (!$errors) {
        // Ensure slug uniqueness (excluding this post if editing).
        $checkStmt = $db->prepare('SELECT id FROM posts WHERE slug = :slug AND id != :id');
        $checkStmt->execute([':slug' => $slug, ':id' => $id ?? 0]);
        if ($checkStmt->fetch()) {
            $slug .= '-' . substr(md5(uniqid('', true)), 0, 5);
        }

        if ($post) {
            $db->prepare(
                'UPDATE posts SET slug=:slug, title=:title, excerpt=:excerpt, body=:body,
                 cover_image=:cover, published=:published, published_at=:pub WHERE id=:id'
            )->execute([
                ':slug' => $slug, ':title' => $title, ':excerpt' => $excerpt, ':body' => $body,
                ':cover' => $coverImage ?: null, ':published' => $published, ':pub' => $publishedAt,
                ':id' => $post['id'],
            ]);
            flash_set('admin_success', 'Post updated.');
        } else {
            $db->prepare(
                'INSERT INTO posts (slug, title, excerpt, body, cover_image, published, published_at)
                 VALUES (:slug, :title, :excerpt, :body, :cover, :published, :pub)'
            )->execute([
                ':slug' => $slug, ':title' => $title, ':excerpt' => $excerpt, ':body' => $body,
                ':cover' => $coverImage ?: null, ':published' => $published, ':pub' => $publishedAt,
            ]);
            flash_set('admin_success', 'Post created.');
        }
        header('Location: posts.php');
        exit;
    }
}

$page_title = $post ? 'Edit Post' : 'New Post';
$active = 'posts';
require __DIR__ . '/includes/layout-header.php';
?>

<div class="admin-card">
    <?php foreach ($errors as $err): ?>
        <div class="alert alert-error"><?= h($err) ?></div>
    <?php endforeach; ?>

    <form method="post">
        <div class="field">
            <label for="title">Title *</label>
            <input type="text" id="title" name="title" required value="<?= h($post['title'] ?? ($_POST['title'] ?? '')) ?>">
        </div>
        <div class="field">
            <label for="slug">URL Slug (leave blank to auto-generate from title)</label>
            <input type="text" id="slug" name="slug" value="<?= h($post['slug'] ?? ($_POST['slug'] ?? '')) ?>">
        </div>
        <div class="field">
            <label for="excerpt">Excerpt (short summary shown on listing cards)</label>
            <textarea id="excerpt" name="excerpt" style="min-height:70px;"><?= h($post['excerpt'] ?? ($_POST['excerpt'] ?? '')) ?></textarea>
        </div>
        <div class="field">
            <label for="cover_image">Cover Image Path (e.g. assets/photos/dinner/fundraising-group-photo.jpg)</label>
            <input type="text" id="cover_image" name="cover_image" value="<?= h($post['cover_image'] ?? ($_POST['cover_image'] ?? '')) ?>">
        </div>
        <div class="field">
            <label for="body">Body (HTML allowed — paragraphs, bold, links, images)</label>
            <textarea id="body" name="body" style="min-height:260px; font-family:monospace;"><?= h($post['body'] ?? ($_POST['body'] ?? '')) ?></textarea>
        </div>
        <div class="field">
            <label for="published_at">Published Date/Time</label>
            <input type="text" id="published_at" name="published_at" placeholder="YYYY-MM-DD HH:MM:SS"
                   value="<?= h($post['published_at'] ?? date('Y-m-d H:i:s')) ?>">
        </div>
        <div class="field">
            <label>
                <input type="checkbox" name="published" value="1" style="width:auto;display:inline-block;"
                    <?= (!$post || $post['published']) ? 'checked' : '' ?>>
                Published (visible on the site)
            </label>
        </div>
        <button type="submit" class="btn btn-navy">Save Post</button>
        <a href="posts.php" class="btn btn-outline" style="border-color:var(--navy); color:var(--navy);">Cancel</a>
    </form>
</div>

<?php require __DIR__ . '/includes/layout-footer.php'; ?>

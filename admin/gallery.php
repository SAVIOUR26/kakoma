<?php
require __DIR__ . '/includes/bootstrap.php';
require_admin_login();

$db = get_db();
$albums = ['dinner', 'rakai', 'campus', 'archive'];

function ensure_thumb(string $album, string $filename): void
{
    $full = BASE_PATH . "/assets/photos/{$album}/{$filename}";
    $thumbDir = BASE_PATH . "/assets/photos/{$album}/thumbs";
    $thumb = "{$thumbDir}/{$filename}";
    if (!file_exists($full) || file_exists($thumb)) {
        return;
    }
    if (!is_dir($thumbDir)) {
        mkdir($thumbDir, 0775, true);
    }
    $info = @getimagesize($full);
    if (!$info) {
        return;
    }
    $src = match ($info['mime']) {
        'image/jpeg' => imagecreatefromjpeg($full),
        'image/png' => imagecreatefrompng($full),
        default => null,
    };
    if (!$src) {
        return;
    }
    $w = imagesx($src);
    $h = imagesy($src);
    $newW = 480;
    $newH = (int) round($h * (480 / $w));
    $dst = imagecreatetruecolor($newW, $newH);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $w, $h);
    imagejpeg($dst, $thumb, 72);
    imagedestroy($src);
    imagedestroy($dst);
}

// Handle: delete
if (isset($_GET['delete'])) {
    $db->prepare('DELETE FROM gallery_images WHERE id = :id')->execute([':id' => (int) $_GET['delete']]);
    flash_set('admin_success', 'Photo removed from gallery.');
    header('Location: gallery.php');
    exit;
}

// Handle: update caption
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_caption') {
    $db->prepare('UPDATE gallery_images SET caption=:c, people=:p, photo_date=:d, location=:l WHERE id=:id')
        ->execute([
            ':c' => trim($_POST['caption'] ?? ''),
            ':p' => trim($_POST['people'] ?? ''),
            ':d' => trim($_POST['photo_date'] ?? ''),
            ':l' => trim($_POST['location'] ?? ''),
            ':id' => (int) $_POST['id'],
        ]);
    flash_set('admin_success', 'Caption updated.');
    header('Location: gallery.php');
    exit;
}

// Handle: import from captions.csv (photos already placed in the album folder)
if (isset($_GET['import'])) {
    $album = in_array($_GET['import'], $albums, true) ? $_GET['import'] : null;
    if ($album) {
        $captions = load_captions($album);
        $existing = $db->prepare('SELECT filename FROM gallery_images WHERE album = :a');
        $existing->execute([':a' => $album]);
        $existingFiles = array_column($existing->fetchAll(), 'filename');

        $maxOrderStmt = $db->prepare('SELECT COALESCE(MAX(sort_order), -1) FROM gallery_images WHERE album = :a');
        $maxOrderStmt->execute([':a' => $album]);
        $nextOrder = (int) $maxOrderStmt->fetchColumn() + 1;

        $imported = 0;
        $insert = $db->prepare(
            'INSERT INTO gallery_images (album, filename, caption, people, photo_date, location, sort_order)
             VALUES (:album, :filename, :caption, :people, :date, :location, :sort)'
        );
        foreach ($captions as $filename => $row) {
            if (in_array($filename, $existingFiles, true)) {
                continue;
            }
            ensure_thumb($album, $filename);
            $insert->execute([
                ':album' => $album,
                ':filename' => $filename,
                ':caption' => $row['caption'] ?? '',
                ':people' => $row['people'] ?? '',
                ':date' => $row['date'] ?? '',
                ':location' => $row['location'] ?? '',
                ':sort' => $nextOrder++,
            ]);
            $imported++;
        }
        flash_set('admin_success', "Imported {$imported} new photo(s) from {$album}/captions.csv.");
    }
    header('Location: gallery.php');
    exit;
}

// Handle: manual upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload') {
    $album = in_array($_POST['album'] ?? '', $albums, true) ? $_POST['album'] : null;
    $caption = trim($_POST['caption'] ?? '');

    if (!$album) {
        flash_set('admin_error', 'Please choose a valid album.');
    } elseif (empty($_FILES['photo']['name'])) {
        flash_set('admin_error', 'Please choose a photo to upload.');
    } else {
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
            flash_set('admin_error', 'Only JPG and PNG photos are supported.');
        } else {
            $filename = slugify(pathinfo($_FILES['photo']['name'], PATHINFO_FILENAME)) . '-' . substr(md5(uniqid('', true)), 0, 6) . '.' . $ext;
            $destDir = BASE_PATH . "/assets/photos/{$album}";
            if (!is_dir($destDir)) {
                mkdir($destDir, 0775, true);
            }
            if (move_uploaded_file($_FILES['photo']['tmp_name'], "{$destDir}/{$filename}")) {
                ensure_thumb($album, $filename);
                $maxOrderStmt = $db->prepare('SELECT COALESCE(MAX(sort_order), -1) FROM gallery_images WHERE album = :a');
                $maxOrderStmt->execute([':a' => $album]);
                $nextOrder = (int) $maxOrderStmt->fetchColumn() + 1;
                $db->prepare(
                    'INSERT INTO gallery_images (album, filename, caption, sort_order) VALUES (:a, :f, :c, :s)'
                )->execute([':a' => $album, ':f' => $filename, ':c' => $caption, ':s' => $nextOrder]);
                flash_set('admin_success', 'Photo uploaded.');
            } else {
                flash_set('admin_error', 'Upload failed — please try again.');
            }
        }
    }
    header('Location: gallery.php');
    exit;
}

$images = $db->query('SELECT * FROM gallery_images ORDER BY album ASC, sort_order ASC')->fetchAll();

$page_title = 'Gallery';
$active = 'gallery';
require __DIR__ . '/includes/layout-header.php';
?>

<div class="admin-card">
    <h3 class="mt-0">Upload a Photo</h3>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="upload">
        <div class="grid grid-2">
            <div class="field">
                <label for="album">Album</label>
                <select id="album" name="album">
                    <?php foreach ($albums as $a): ?>
                        <option value="<?= h($a) ?>"><?= h(ucfirst($a)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="photo">Photo (JPG/PNG)</label>
                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png" required>
            </div>
        </div>
        <div class="field">
            <label for="caption">Caption</label>
            <input type="text" id="caption" name="caption">
        </div>
        <button type="submit" class="btn btn-navy">Upload Photo</button>
    </form>

    <p class="form-note" style="margin-top:18px;">
        Prefer bulk-adding photos? Drop them into <code>assets/photos/&lt;album&gt;/</code>
        along with a matching <code>captions.csv</code> (columns: filename, caption, people,
        date, location), then import here:
    </p>
    <p class="action-links">
        <?php foreach ($albums as $a): ?>
            <a href="gallery.php?import=<?= h($a) ?>" class="btn btn-outline" style="border-color:var(--navy); color:var(--navy); margin:0 8px 8px 0; display:inline-block;">Import from <?= h($a) ?>/captions.csv</a>
        <?php endforeach; ?>
    </p>
</div>

<div class="admin-card">
    <h3 class="mt-0">All Photos</h3>
    <table class="admin-table">
        <thead><tr><th>Photo</th><th>Album</th><th>Caption</th><th>People / Date / Location</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($images as $img): ?>
                <tr>
                    <td><img class="thumb" src="../assets/photos/<?= h($img['album']) ?>/thumbs/<?= h($img['filename']) ?>" alt=""></td>
                    <td><?= h(ucfirst($img['album'])) ?></td>
                    <td style="min-width:220px;">
                        <form method="post" style="display:flex; flex-direction:column; gap:6px;">
                            <input type="hidden" name="action" value="update_caption">
                            <input type="hidden" name="id" value="<?= (int) $img['id'] ?>">
                            <input type="text" name="caption" value="<?= h($img['caption']) ?>" placeholder="Caption">
                            <input type="text" name="people" value="<?= h($img['people']) ?>" placeholder="People">
                            <div style="display:flex; gap:6px;">
                                <input type="text" name="photo_date" value="<?= h($img['photo_date']) ?>" placeholder="Date">
                                <input type="text" name="location" value="<?= h($img['location']) ?>" placeholder="Location">
                            </div>
                            <button type="submit" class="btn btn-outline" style="border-color:var(--navy); color:var(--navy); padding:6px 12px; font-size:0.8rem; align-self:flex-start;">Save</button>
                        </form>
                    </td>
                    <td class="muted" style="font-size:0.82rem;"><?= h($img['people']) ?><br><?= h($img['photo_date']) ?><br><?= h($img['location']) ?></td>
                    <td class="action-links">
                        <a href="gallery.php?delete=<?= (int) $img['id'] ?>" class="danger" onclick="return confirm('Remove this photo from the gallery?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$images): ?><tr><td colspan="5" class="muted">No photos yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/includes/layout-footer.php'; ?>

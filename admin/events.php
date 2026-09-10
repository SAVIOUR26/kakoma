<?php
require __DIR__ . '/includes/bootstrap.php';
require_admin_login();

$db = get_db();

if (isset($_GET['delete'])) {
    $db->prepare('DELETE FROM events WHERE id = :id')->execute([':id' => (int) $_GET['delete']]);
    flash_set('admin_success', 'Event deleted.');
    header('Location: /admin/events');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $eventDate = trim($_POST['event_date'] ?? '');
    $status = in_array($_POST['status'] ?? '', ['upcoming', 'coming_soon', 'past'], true) ? $_POST['status'] : 'upcoming';
    $detailsHtml = trim($_POST['details_html'] ?? '');

    if ($title !== '') {
        if ($id) {
            $db->prepare('UPDATE events SET title=:t, description=:d, event_date=:e, status=:s, details_html=:dh WHERE id=:id')
                ->execute([':t' => $title, ':d' => $description, ':e' => $eventDate ?: null, ':s' => $status, ':dh' => $detailsHtml ?: null, ':id' => $id]);
            flash_set('admin_success', 'Event updated.');
        } else {
            $db->prepare('INSERT INTO events (title, description, event_date, status, details_html) VALUES (:t, :d, :e, :s, :dh)')
                ->execute([':t' => $title, ':d' => $description, ':e' => $eventDate ?: null, ':s' => $status, ':dh' => $detailsHtml ?: null]);
            flash_set('admin_success', 'Event added.');
        }
    } else {
        flash_set('admin_error', 'Title is required.');
    }
    header('Location: /admin/events');
    exit;
}

$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : null;
$editEvent = null;
if ($editId) {
    $stmt = $db->prepare('SELECT * FROM events WHERE id = :id');
    $stmt->execute([':id' => $editId]);
    $editEvent = $stmt->fetch();
}

$events = $db->query('SELECT * FROM events ORDER BY event_date ASC')->fetchAll();

$page_title = 'Events';
$active = 'events';
require __DIR__ . '/includes/layout-header.php';
?>

<div class="admin-card">
    <h3 class="mt-0"><?= $editEvent ? 'Edit Event' : 'Add Event' ?></h3>
    <form method="post">
        <input type="hidden" name="id" value="<?= h((string) ($editEvent['id'] ?? '')) ?>">
        <div class="field">
            <label for="title">Title *</label>
            <input type="text" id="title" name="title" required value="<?= h($editEvent['title'] ?? '') ?>">
        </div>
        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" style="min-height:80px;"><?= h($editEvent['description'] ?? '') ?></textarea>
        </div>
        <div class="grid grid-2">
            <div class="field">
                <label for="event_date">Date (YYYY-MM-DD)</label>
                <input type="text" id="event_date" name="event_date" value="<?= h($editEvent['event_date'] ?? '') ?>">
            </div>
            <div class="field">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <?php foreach (['upcoming' => 'Upcoming', 'coming_soon' => 'Coming Soon', 'past' => 'Past'] as $val => $label): ?>
                        <option value="<?= h($val) ?>" <?= ($editEvent['status'] ?? 'upcoming') === $val ? 'selected' : '' ?>><?= h($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="field">
            <label for="details_html">Extra Details (HTML, optional — ticket tiers, payment info, RSVP contacts)</label>
            <textarea id="details_html" name="details_html" style="min-height:140px; font-family:monospace;"><?= h($editEvent['details_html'] ?? '') ?></textarea>
            <p class="form-note">Wrap ticket lists in <code>&lt;table class="simple-table"&gt;</code> and contact lists in <code>&lt;ul&gt;</code> to match the site's styling.</p>
        </div>
        <button type="submit" class="btn btn-navy"><?= $editEvent ? 'Update Event' : 'Add Event' ?></button>
        <?php if ($editEvent): ?><a href="/admin/events" class="btn btn-outline" style="border-color:var(--navy); color:var(--navy);">Cancel</a><?php endif; ?>
    </form>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= h($event['title']) ?></td>
                    <td><?= h(format_date($event['event_date'])) ?></td>
                    <td><?= h(ucwords(str_replace('_', ' ', $event['status']))) ?></td>
                    <td class="action-links">
                        <a href="/admin/events?edit=<?= (int) $event['id'] ?>">Edit</a>
                        <a href="/admin/events?delete=<?= (int) $event['id'] ?>" class="danger" onclick="return confirm('Delete this event?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$events): ?><tr><td colspan="4" class="muted">No events yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/includes/layout-footer.php'; ?>

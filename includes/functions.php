<?php
/** Small shared helpers used across public pages and the admin panel. */

function h(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

function format_date(?string $dateStr, string $format = 'j F Y'): string
{
    if (!$dateStr) {
        return '';
    }
    $ts = strtotime($dateStr);
    return $ts ? date($format, $ts) : '';
}

function flash_set(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

function flash_get(string $key): ?string
{
    if (!empty($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}

function is_admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}

function require_admin_login(): void
{
    if (!is_admin_logged_in()) {
        header('Location: /admin/login');
        exit;
    }
}

function current_page(): string
{
    return basename($_SERVER['SCRIPT_NAME']);
}

/** Days/hours/minutes/seconds until the Diamond Jubilee, for the countdown widget. */
function jubilee_countdown_parts(): array
{
    $now = new DateTime('now');
    $target = new DateTime(JUBILEE_DATE . ' 00:00:00');
    if ($now > $target) {
        return ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0, 'passed' => true];
    }
    $diff = $now->diff($target);
    $totalDays = (int) $now->diff($target)->days;
    return [
        'days' => $totalDays,
        'hours' => (int) $diff->h,
        'minutes' => (int) $diff->i,
        'seconds' => (int) $diff->s,
        'passed' => false,
    ];
}

/**
 * Reads a photo album's captions.csv into an associative array keyed by
 * filename, per the convention documented in CLAUDE.md.
 */
function load_captions(string $album): array
{
    $path = BASE_PATH . "/assets/photos/{$album}/captions.csv";
    $captions = [];
    if (!file_exists($path)) {
        return $captions;
    }
    if (($handle = fopen($path, 'r')) !== false) {
        $header = fgetcsv($handle);
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < count($header)) {
                continue;
            }
            $entry = array_combine($header, $row);
            $captions[$entry['filename']] = $entry;
        }
        fclose($handle);
    }
    return $captions;
}

/** True once the digital magazine is open to the public (see MAGAZINE_LAUNCH). */
function magazine_is_live(): bool
{
    return date('Y-m-d H:i:s') >= MAGAZINE_LAUNCH;
}

/** Public, or previewed by a signed-in admin. */
function magazine_can_read(): bool
{
    return magazine_is_live() || is_admin_logged_in();
}

/** Launch moment as an ISO date for the countdown script. */
function magazine_launch_iso(): string
{
    return (new DateTime(MAGAZINE_LAUNCH, new DateTimeZone('Africa/Kampala')))->format(DATE_ATOM);
}

/** Wording for links to the magazine: "Read" once launched, the launch date before. */
function magazine_cta(): string
{
    return magazine_is_live() ? 'Read the Digital Magazine' : 'Digital Magazine: launching ' . MAGAZINE_LAUNCH_LABEL;
}

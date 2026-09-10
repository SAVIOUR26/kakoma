<?php
/**
 * One-time, idempotent content/schema fixups. Each migration runs at most
 * once (tracked in the `migrations` table), so it's safe to deploy this
 * file to a site that already has a live, seeded database — new
 * migrations apply automatically on the next request, existing ones are
 * skipped. Add new migrations to the bottom of the list; never edit or
 * remove an already-shipped one.
 */

function run_migrations(PDO $db): void
{
    $applied = $db->query('SELECT name FROM migrations')->fetchAll(PDO::FETCH_COLUMN);

    $migrations = [
        '2026_09_10_remove_headteacher_old_student_claim' => function (PDO $db) {
            $db->prepare(
                "UPDATE gallery_images SET caption = 'Head Teacher Bbale David speaks at the fundraising dinner.'
                 WHERE album = 'dinner' AND filename = 'headteacher-bbale-david.jpg'"
            )->execute();

            $db->prepare(
                "UPDATE posts SET body = REPLACE(
                    body,
                    'Head Teacher <strong>Bbale David</strong> — himself a Kakoma old student — spoke about what it means to now lead the school that shaped him, and shared the Board''s vision for the Jubilee Hall.',
                    'Head Teacher <strong>Bbale David</strong> spoke about the Board''s vision for the Jubilee Hall and thanked old students for their generosity.'
                 ) WHERE slug = 'old-students-fundraising-dinner-2026'"
            )->execute();
        },

        '2026_09_10_add_dinner_venue' => function (PDO $db) {
            $db->prepare(
                "UPDATE gallery_images SET location = 'Royal Suites, Bugolobi'
                 WHERE album = 'dinner' AND (location IS NULL OR location = '' OR location LIKE '%TBC%')"
            )->execute();

            $db->prepare(
                "UPDATE posts SET
                    excerpt = REPLACE(excerpt, 'gathered for a fundraising dinner', 'gathered at Royal Suites, Bugolobi for a fundraising dinner'),
                    body = REPLACE(body, 'came together for an evening fundraising dinner', 'came together at <strong>Royal Suites, Bugolobi</strong> for an evening fundraising dinner')
                 WHERE slug = 'old-students-fundraising-dinner-2026'"
            )->execute();
        },

        '2026_09_10_add_past_and_upcoming_dinner_events' => function (PDO $db) {
            // The original fundraising dinner is now in the past.
            $db->prepare(
                "INSERT INTO events (title, description, event_date, status)
                 VALUES (:title, :desc, :date, 'past')"
            )->execute([
                ':title' => "Old Students' Fundraising Dinner — Royal Suites, Bugolobi",
                ':desc' => 'Old students, board members and staff gathered to launch fundraising for the Diamond Jubilee Hall Project.',
                ':date' => '2026-08-15',
            ]);

            // A second, ticketed fundraising dinner dedicated to the Hall.
            $ticketDetails = '<div class="event-details">'
                . '<h4>Tickets</h4>'
                . '<table class="simple-table">'
                . '<tr><td>Table (5 people)</td><td>UGX 500,000</td></tr>'
                . '<tr><td>Couple</td><td>UGX 180,000</td></tr>'
                . '<tr><td>Individual</td><td>UGX 100,000</td></tr>'
                . '<tr><td>Student</td><td>UGX 50,000</td></tr>'
                . '</table>'
                . '<h4>Payment</h4>'
                . '<ul>'
                . '<li>Centenary Bank A/C 3100126734 — Kakoma Secondary School Project Account</li>'
                . '<li>MoMo Pay 66241886 — Kakoma Secondary School</li>'
                . '</ul>'
                . '<h4>RSVP</h4>'
                . '<ul>'
                . '<li>Mrs. Margaret Kaliisa — 0701 883032</li>'
                . '<li>Samson W. Kakembo — 0772 433398</li>'
                . '<li>Hajj Jamil Sempijja — 0752 460047</li>'
                . '</ul>'
                . '</div>';

            $db->prepare(
                "INSERT INTO events (title, description, event_date, status, details_html)
                 VALUES (:title, :desc, :date, 'upcoming', :details)"
            )->execute([
                ':title' => 'Diamond Jubilee Hall Fundraising Dinner — Maple Leaf Hotel, Masaka',
                ':desc' => "Old students of Kakoma Secondary School, together with the Board of Governors, invite you to a fundraising dinner in celebration of 60 years of the school's existence. Proceeds fund the proposed Diamond Jubilee Hall, a gift from old students. Saturday 19 September 2026, 3:00 PM.",
                ':date' => '2026-09-19',
                ':details' => $ticketDetails,
            ]);
        },
    ];

    foreach ($migrations as $name => $migration) {
        if (in_array($name, $applied, true)) {
            continue;
        }
        $db->beginTransaction();
        try {
            $migration($db);
            $db->prepare('INSERT INTO migrations (name) VALUES (:name)')->execute([':name' => $name]);
            $db->commit();
        } catch (Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }
}

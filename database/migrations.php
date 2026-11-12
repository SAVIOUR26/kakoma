<?php
/**
 * One-time, idempotent content/schema fixups. Each migration runs at most
 * once (tracked in the `migrations` table), so it's safe to deploy this
 * file to a site that already has a live, seeded database — new
 * migrations apply automatically on the next request, existing ones are
 * skipped. Add new migrations to the bottom of the list; never edit or
 * remove an already-shipped one.
 */

/**
 * schema.sql uses CREATE TABLE IF NOT EXISTS, which does nothing to a
 * table that already exists on a live site — it does NOT retrofit new
 * columns. Any migration that relies on a column added after a table's
 * first release must add it first, via this helper.
 */
function column_exists(PDO $db, string $table, string $column): bool
{
    $stmt = $db->query('PRAGMA table_info(' . $table . ')');
    foreach ($stmt->fetchAll() as $row) {
        if ($row['name'] === $column) {
            return true;
        }
    }
    return false;
}

function run_migrations(PDO $db): void
{
    $applied = $db->query('SELECT name FROM migrations')->fetchAll(PDO::FETCH_COLUMN);

    $migrations = [
        '2026_09_10_add_events_details_html_column' => function (PDO $db) {
            if (!column_exists($db, 'events', 'details_html')) {
                $db->exec('ALTER TABLE events ADD COLUMN details_html TEXT');
            }
        },

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

        // Facts and names as printed in the Diamond Jubilee magazine "Kakoma at Sixty" (Nov 2026).
        '2026_11_12_jubilee_magazine_facts_and_events' => function (PDO $db) {
            // Names and roles: Mr. Bbaale David (not "Bbale"); Dr. Isaac Nsereko chairs the
            // Diamond Jubilee Organising Committee (the Board Chairman is Owek. Richard Sseggwanyi).
            foreach (['title', 'excerpt', 'body'] as $col) {
                $db->exec("UPDATE posts SET {$col} = REPLACE({$col}, 'Bbale David', 'Mr. Bbaale David')");
                $db->exec("UPDATE posts SET {$col} = REPLACE({$col}, 'Mr. Mr. Bbaale', 'Mr. Bbaale')");
            }
            $db->exec("UPDATE posts SET body = REPLACE(body, 'Board Chairman <strong>Dr. Isaac Nsereko</strong>', 'Organising Committee Chairman <strong>Dr. Isaac Nsereko</strong>')");
            $db->exec("UPDATE posts SET body = REPLACE(body, 'a modern hall pictured in architectural renders', 'a modern hall, pictured in an artist''s impression')");
            $db->exec("UPDATE posts SET body = REPLACE(body, 'including a guest from the Class of 1968', 'including Rukidi Gabigogo, who enrolled with the first students in 1968')");
            $db->prepare("UPDATE posts SET body = REPLACE(body, :old, :new) WHERE slug = 'old-students-fundraising-dinner-2026'")->execute([
                ':old' => "<p>The fundraising continues at a second dinner on <strong>19 September 2026</strong> at the Maple Leaf Hotel, Masaka — see full ticket and payment details on our <a href=\"/events\">Events</a> page.</p>",
                ':new' => "<p>The Guest of Honour was <strong>Owek. Kiwanuka Ahmed, Katikkiro of Kooki</strong>. A second dinner followed at <strong>Maple Leaf Hotel, Masaka</strong>, where <strong>Hajji Jamil Ssempijja</strong> was Guest of Honour.</p>",
            ]);

            // The Masaka dinner has taken place: move it to past events and drop the ticket/RSVP block.
            $db->prepare("UPDATE events SET status = 'past', details_html = NULL, description = :desc
                          WHERE event_date = '2026-09-19' AND title LIKE '%Maple Leaf%'")->execute([
                ':desc' => 'Old students and friends of Kakoma gathered at Maple Leaf Hotel, Masaka, with Hajji Jamil Ssempijja as Guest of Honour, to raise support for the Diamond Hall.',
            ]);
            $db->prepare("UPDATE events SET description = :desc WHERE event_date = '2026-08-15' AND status = 'past'")->execute([
                ':desc' => 'Old students, board members and staff gathered at Royal Suites, Bugolobi, with Owek. Kiwanuka Ahmed, Katikkiro of Kooki, as Guest of Honour, to launch the Diamond Jubilee Hall Project.',
            ]);

            // The Jubilee itself: programme confirmed.
            $details = '<div class="event-details">'
                . '<ul>'
                . '<li><strong>Date:</strong> Saturday 14 November 2026, from 8:00 am</li>'
                . '<li><strong>Venue:</strong> New school playground, Kakoma SS</li>'
                . '<li><strong>Guest of Honour:</strong> Rt. Hon. Robinah Nabbanja, Prime Minister of Uganda</li>'
                . '<li><strong>Thanksgiving service:</strong> Most Rev. Dr. Stephen Samuel Kazimba Mugalu, Archbishop of the Church of Uganda</li>'
                . '<li><strong>Patron:</strong> His Royal Highness the Kamuswaga of Kooki</li>'
                . '</ul>'
                . '<p>Thanksgiving service, speeches, the Royal Message, awards, the grand fundraising for the Diamond Hall, '
                . 'cake slicing and the groundbreaking for the Main Hall. <a href="/anniversary#programme">See the full programme &rarr;</a></p>'
                . '</div>';
            $db->prepare("UPDATE events SET status = 'upcoming', details_html = :details, description = :desc
                          WHERE event_date = :date AND title LIKE '%Diamond Jubilee%'")->execute([
                ':details' => $details,
                ':desc' => 'Kakoma Secondary School celebrates sixty years of Labour for Success with a thanksgiving service and Diamond Jubilee celebration at the school.',
                ':date' => JUBILEE_DATE,
            ]);
        },

        // Gallery: sync captions and new photos from assets/photos/<album>/captions.csv
        // (dinner, campus and archive albums, curated from the magazine's photo library).
        '2026_11_12_gallery_from_magazine_photos' => function (PDO $db) {
            if (!function_exists('load_captions')) {
                require_once BASE_PATH . '/includes/functions.php';
            }
            $db->exec("UPDATE gallery_images SET filename = 'headteacher-bbaale-david.jpg' WHERE filename = 'headteacher-bbale-david.jpg'");
            $find = $db->prepare('SELECT id FROM gallery_images WHERE album = :album AND filename = :filename');
            $update = $db->prepare('UPDATE gallery_images SET caption = :caption, people = :people, photo_date = :date,
                                    location = :location, sort_order = :sort WHERE id = :id');
            $insert = $db->prepare('INSERT INTO gallery_images (album, filename, caption, people, photo_date, location, sort_order)
                                    VALUES (:album, :filename, :caption, :people, :date, :location, :sort)');
            foreach (['dinner', 'campus', 'archive'] as $album) {
                $sort = 0;
                foreach (load_captions($album) as $filename => $row) {
                    $values = [
                        ':caption' => $row['caption'],
                        ':people' => $row['people'] ?: null,
                        ':date' => $row['date'] ?: null,
                        ':location' => $row['location'] ?: null,
                        ':sort' => $sort++,
                    ];
                    $find->execute([':album' => $album, ':filename' => $filename]);
                    $id = $find->fetchColumn();
                    if ($id) {
                        $update->execute($values + [':id' => $id]);
                    } else {
                        $insert->execute($values + [':album' => $album, ':filename' => $filename]);
                    }
                }
            }
        },

        // Announce the digital edition of the magazine.
        '2026_11_12_digital_magazine_post' => function (PDO $db) {
            $exists = $db->query("SELECT COUNT(*) FROM posts WHERE slug = 'kakoma-at-sixty-digital-magazine'")->fetchColumn();
            if ($exists) {
                return;
            }
            $db->prepare(
                'INSERT INTO posts (slug, title, excerpt, body, cover_image, published, published_at)
                 VALUES (:slug, :title, :excerpt, :body, :cover, 1, :pub)'
            )->execute([
                ':slug' => 'kakoma-at-sixty-digital-magazine',
                ':title' => 'Kakoma at Sixty: Read the Diamond Jubilee Magazine Online',
                ':excerpt' => 'The 32-page Diamond Jubilee magazine tells the Kakoma story: the land and the founding families, ten head teachers, the old students and the journey ahead. Read it online or download it.',
                ':body' => '<p>The Diamond Jubilee magazine, <strong>Kakoma at Sixty</strong>, is now available online. In 32 pages it tells the story of Kakoma Secondary School, from the land the Kingdom of Kooki gave to the Church at Kakoma, and the 93 acres Kakoma Church of Uganda Parish gave for the school in 1967, to the Diamond Hall planned for the generations to come.</p>'
                    . '<p>Inside: messages from His Royal Highness the Kamuswaga of Kooki, the Bishop of West Buganda Diocese, the Board Chairman, the Chairman of the Organising Committee and the Head Teacher; the school history and the founding families; the ten head teachers since 1967; the 1968 pioneers; old students\' voices and memories; the fundraising dinners; Kakoma today; and the Jubilee Day programme.</p>'
                    . '<p><a href="/magazine">Read the magazine online</a>, download it, and share it with every old student and friend of Kakoma.</p>',
                ':cover' => 'assets/magazine/pages/page-01.jpg',
                ':pub' => date('Y-m-d H:i:s'),
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

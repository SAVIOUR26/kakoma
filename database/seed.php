<?php
/**
 * Seeds a brand-new database with the content we already have on hand
 * (the Old Students' fundraising dinner) plus one default admin account.
 * Runs automatically the first time the site is visited after install.
 */

function seed_database(PDO $db): void
{
    // Default admin account. CHANGE THIS PASSWORD immediately after first
    // login — see README.md for instructions.
    $defaultUsername = 'admin';
    $defaultPassword = 'KakomaJubilee2026!';
    $stmt = $db->prepare(
        'INSERT INTO admin_users (username, password_hash) VALUES (:u, :p)'
    );
    $stmt->execute([
        ':u' => $defaultUsername,
        ':p' => password_hash($defaultPassword, PASSWORD_DEFAULT),
    ]);

    // First blog post: the Old Students' fundraising dinner.
    $db->prepare(
        'INSERT INTO posts (slug, title, excerpt, body, cover_image, published, published_at)
         VALUES (:slug, :title, :excerpt, :body, :cover, 1, :pub)'
    )->execute([
        ':slug' => 'old-students-fundraising-dinner-2026',
        ':title' => "Old Students Rally Behind the Diamond Jubilee Hall Project",
        ':excerpt' => "On 15 August 2026, old students, board members and staff gathered for a fundraising dinner in support of the Diamond Jubilee Hall Project — a new milestone as Kakoma S.S. approaches its 60th anniversary.",
        ':body' => "<p>On <strong>15 August 2026</strong>, old students, board members and friends of Kakoma Secondary School came together for an evening fundraising dinner in support of the <strong>Diamond Jubilee Hall Project</strong> — a new hall for the school, timed to mark our 60th anniversary on 14 November 2026.</p>"
            . "<p>Board Chairman <strong>Dr. Isaac Nsereko</strong> welcomed guests and thanked old students for continuing to \"labour for success\" long after leaving Kakoma's gates. Head Teacher <strong>Bbale David</strong> — himself a Kakoma old student — spoke about what it means to now lead the school that shaped him, and shared the Board's vision for the Jubilee Hall.</p>"
            . "<p>The evening's highlight was the unveiling of the Diamond Jubilee Hall Project board: a visual journey \"from where we are\" — the school's current, aging facilities — \"to where we want to be\" — a modern hall pictured in architectural renders. Old students, including a guest from the Class of 1968, shared memories from their own years at Kakoma before pledging their support.</p>"
            . "<p>More photos from the evening are in our <a href=\"gallery.php\">gallery</a>. If you attended and would like to be added to our growing Old Students directory, please <a href=\"alumni.php#register\">register here</a>.</p>",
        ':cover' => 'assets/photos/dinner/fundraising-group-photo.jpg',
        ':pub' => '2026-08-16 09:00:00',
    ]);

    // Signature Phase-1 event: the Diamond Jubilee itself.
    $db->prepare(
        'INSERT INTO events (title, description, event_date, status)
         VALUES (:title, :desc, :date, :status)'
    )->execute([
        ':title' => 'Kakoma Diamond Jubilee — 60th Anniversary Celebration',
        ':desc' => 'Kakoma Secondary School marks 60 years of "Labour for Success" with a Diamond Jubilee celebration. Full programme details coming soon.',
        ':date' => JUBILEE_DATE,
        ':status' => 'coming_soon',
    ]);

    // Gallery entries for the dinner album, matching assets/photos/dinner/captions.csv
    $dinnerPhotos = [
        ['chairman-isaac-nsereko.jpg', 'Board Chairman Dr. Isaac Nsereko addresses guests during the Old Students\' Diamond Jubilee fundraising dinner.', 'Dr. Isaac Nsereko (Board Chairman)'],
        ['headteacher-bbale-david.jpg', 'Head Teacher Bbale David — himself a Kakoma old student — speaks at the fundraising dinner.', 'Bbale David (Head Teacher)'],
        ['old-student-1968-testimony.jpg', 'An old student from the Class of 1968 shares memories of his time at Kakoma S.S.', 'Old Student, Class of 1968'],
        ['fundraising-group-photo.jpg', 'Board members, staff, old students and guests gather for a group photo at the fundraising dinner.', 'Board members, Old Students, Guests'],
        ['jubilee-hall-project-unveiling.jpg', 'Old students unveil the Diamond Jubilee Hall Project board, showing the journey from where the school is to where it wants to be.', 'Old Students'],
        ['jubilee-hall-project-presentation.jpg', 'The Diamond Jubilee Hall Project proposal is presented to the Board Chairman, Head Teacher and guests for signing and pledges.', 'Board Chairman, Head Teacher, Guests'],
    ];
    $stmt = $db->prepare(
        'INSERT INTO gallery_images (album, filename, caption, people, photo_date, location, sort_order)
         VALUES (:album, :filename, :caption, :people, :date, :location, :sort)'
    );
    foreach ($dinnerPhotos as $i => $photo) {
        $stmt->execute([
            ':album' => 'dinner',
            ':filename' => $photo[0],
            ':caption' => $photo[1],
            ':people' => $photo[2],
            ':date' => '2026-08-15',
            ':location' => 'Kampala (venue TBC)',
            ':sort' => $i,
        ]);
    }
}

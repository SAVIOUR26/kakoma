<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';

$page_title = 'Word From the Board';
$page_description = 'A message from the Kakoma Secondary School Board Chairman, Dr. Isaac Nsereko, as the school marks 60 years.';
$body_class = 'page-board';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Word From the Board</h1>
        <p>A message from our Board Chairman</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="grid grid-2" style="align-items:start; max-width:900px; margin:0 auto;">
            <div>
                <img src="assets/photos/dinner/chairman-isaac-nsereko.jpg" alt="Dr. Isaac Nsereko, Board Chairman" style="border-radius:var(--radius); box-shadow:var(--shadow);">
                <p class="text-center" style="margin-top:12px;">
                    <strong style="color:var(--navy);">Dr. Isaac Nsereko</strong><br>
                    <span class="muted">Board Chairman, Kakoma Secondary School</span>
                </p>
            </div>
            <div class="prose">
                <p>
                    On behalf of the Board of Governors, it is my pleasure to welcome you to
                    the official Kakoma Secondary School website, launched as we prepare to
                    celebrate our Diamond Jubilee — sixty years of "Labour for Success."
                </p>
                <p>
                    At our recent Old Students' fundraising dinner, I was reminded once again
                    of what makes Kakoma special: a community of old students, staff, board
                    members and friends who continue to give back, long after their own time
                    at the school has ended. That evening's launch of the Diamond Jubilee Hall
                    Project — moving us "from where we are to where we want to be" — reflects
                    exactly the spirit this anniversary calls for.
                </p>
                <p>
                    As we approach 14 November 2026, the Board's priority is simple: to honor
                    the founders and families who made Kakoma possible in 1967, and to build a
                    stronger foundation for the next sixty years. We invite every old student,
                    parent and friend of Kakoma to join us — whether by attending our events,
                    contributing your story to our Old Students directory, or supporting the
                    Jubilee Hall Project.
                </p>
                <p><em>— Dr. Isaac Nsereko, Board Chairman</em></p>
                <p class="form-note">
                    <em>This message will be updated with the Chairman's full remarks and any
                    additional Board statements as they are provided.</em>
                </p>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';

$page_title = "Head Teacher's Message";
$page_description = "A message from Head Teacher Bbale David — a Kakoma old student now leading the school he once studied at.";
$body_class = 'page-headteacher';
require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Head Teacher's Message</h1>
        <p>From student to headteacher</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="grid grid-2" style="align-items:start; max-width:900px; margin:0 auto;">
            <div>
                <img src="assets/photos/dinner/headteacher-bbale-david.jpg" alt="Bbale David, Head Teacher" style="border-radius:var(--radius); box-shadow:var(--shadow);">
                <p class="text-center" style="margin-top:12px;">
                    <strong style="color:var(--navy);">Bbale David</strong><br>
                    <span class="muted">Head Teacher, Kakoma Secondary School</span><br>
                    <span class="coming-soon-badge" style="margin-top:8px;">Kakoma Old Student</span>
                </p>
            </div>
            <div class="prose">
                <p>
                    I still remember walking through Kakoma's gates for the first time as a
                    student, long before I imagined I would one day return to lead this
                    school. To now serve as Head Teacher — in our Diamond Jubilee year — is
                    one of the greatest honors of my life.
                </p>
                <p>
                    Kakoma shaped me. The discipline behind our motto, <em>"Labour for
                    Success,"</em> was not just something we recited — it was something our
                    teachers modeled for us every day. Standing before old students and
                    friends at our recent fundraising dinner, hearing their memories and
                    watching their generosity toward the Diamond Jubilee Hall Project, I saw
                    that same spirit alive and well, sixty years on.
                </p>
                <p>
                    As we build toward 14 November 2026, my commitment to our students,
                    parents and staff is simple: to give today's Kakoma students the same
                    foundation that was given to me — and to keep building on it, so the next
                    sixty years are even stronger than the last.
                </p>
                <p>
                    Thank you for visiting our new website. I invite you to explore our
                    history, meet our Old Students community, and join us as we celebrate
                    this milestone together.
                </p>
                <p><em>— Bbale David, Head Teacher</em></p>
                <p class="form-note">
                    <em>This message will be updated with the Head Teacher's full remarks as
                    they are provided.</em>
                </p>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Meet Darren Chong Khai Chen, a Computer Science student from Kuching, Sarawak.">
    <meta name="keywords" content="Plantify, Darren, user profile, computer science">
    <meta name="author" content="Darren">
    <title>Darren's Profile - Plantify</title>

    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="contribute-page user-page darren-profile">

    <?php
        include("header.php");
        ?>
        <main class="explore-main classification-main">

        <?php
            include("user-aside.php");
            ?>
        <section class="userprofile-content">
        <h1>User Profile</h1>

        <section class="profile-summary" aria-labelledby="darren-name">
            <p class="profile-name" id="darren-name">DARREN CHONG KHAI CHEN</p>
            <div class="darren-intro">
                <div class="darren-bio">
                    <p class="darren-eyebrow">Kuching, Sarawak · Computer Science</p>
                    <h2>A little about me</h2>
                    <p>I'm Darren, a Computer Science student who enjoys gaming, travelling and exploring AI-generated content. I keep working towards my goals, one step at a time.</p>
                    <dl class="darren-details">
                        <div><dt>Student number</dt><dd>104406534</dd></div>
                        <div><dt>Current course</dt><dd>Bachelor in Computer Science</dd></div>
                    </dl>
                    <ul class="darren-interests" aria-label="My interests">
                        <li>Gaming</li>
                        <li>Travel</li>
                        <li>AI-generated content</li>
                    </ul>
                </div>
                <figure class="darren-portrait">
                    <img class="profile-photo" src="images/user/user1.jpeg" alt="Photo of Darren Chong Khai Chen">
                    <figcaption>Computer Science student<br>From Kuching, Sarawak</figcaption>
                </figure>
            </div>
            <dl class="darren-education" aria-label="My education journey">
                <div><dt>2025 · Graduated</dt><dd>Diploma in Computer Science</dd></div>
                <div><dt>Now · Continuing my studies</dt><dd>Bachelor in Computer Science</dd></div>
            </dl>
        </section>

        <section class="personal-profile">
            <h2>Personal Profile</h2>

             <table class="profile-table" id="profile-table">
                <thead>
                    <tr>
                        <th>Information</th>
                        <th>About Me</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Demographic Information</td>
                        <td>I am a 22-year-old male. I tend to be introverted, but I also have an outgoing side.
                            Looking ahead, I hope to achieve financial independence and build a stable,
                            successful future for myself.</td>
                    </tr>
                    <tr>
                        <td>Hometown</td>
                        <td>I was born in Kuching, Sarawak.</td>
                    </tr>
                    <tr>
                        <td>Hobbies</td>
                        <td>I enjoy playing gun fight games such as Valorant, Counter-Strike and Delta Force
                            and traveling around the world and also watching some AIGC content video for now.</td>
                    </tr>
                    <tr>
                        <td>Fun Facts</td>
                        <td>I tried went back home at 5am, and then my flight schedule is at 6.30am. No time to sleep</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            For more information <a class="email-button" id="email-button" href="mailto:your-email@example.com">Email Me</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </section>
        </section>
    </main>
        <?php
        include("footer.php");
        ?>

</body>

</html>

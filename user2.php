<?php
	session_start();
	?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plantify User Profile">
    <meta name="keywords" content="Plantify, user profile, profile">
    <meta name="author" content="Chin Jii Ann">
    <title>User Profile - Chin Jii Ann</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="contribute-page user-page user2-theme">
    <?php
        include("header.php");
        ?>
    <main class="explore-main classification-main">

        <aside class="userprofile-rail" id="rail">
            <p class="userprofile-title">User Profile<br>Levels</p>

            <nav aria-label="User Profile pages">
                <a href="user1.html">User 1</a>
                <a href="user2.html" aria-current="page">User 2</a>
                <a href="user3.html">User 3</a>
                <a href="user4.html">User 4</a>
            </nav>
        </aside>

        <section class="userprofile-content">

            <h1>User Profile</h1>

            <section class="profile-summary">
                <p class="profile-name">Chin Jii Ann</p>

                <img class="profile-photo"
                    src="images/user/user2.jpeg"
                    alt="Photo of Chin Jii Ann">

                <p><strong>Student Number:</strong> 106764962</p>

                <p class="course">
                    <strong>Course:</strong> Bachelor in Computer Science
                </p>
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
                            <td>
                                I am currently studying for a Bachelor's degree in Computer Science.
                                I chose Computer Science because I am interested in technology and
                                want to develop my skills in the computing field. I hope to build a
                                successful career in the future, whether that means joining a large
                                technology company such as HoYoverse or eventually creating my own
                                brand and starting a personal company.
                            </td>
                        </tr>

                        <tr>
                            <td>Hometown</td>
                            <td>I was born in Kuching, Sarawak.</td>
                        </tr>

                        <tr>
                            <td>Hobbies</td>
                            <td>
                                I enjoy playing games such as Honor of Kings and Honkai: Star Rail,
                                spending time with my close friends and gaming friends, and
                                exploring new games in my free time.
                            </td>
                        </tr>

                        <tr>
                            <td>Fun Facts</td>
                            <td>
                                Three girls mistook my car for their Grab.(￣Д￣;;)
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="2">
                                For more information
                                <a class="email-button" id="email-button" href="mailto:106764962@students.swinburne.edu.my">Email Me</a>
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
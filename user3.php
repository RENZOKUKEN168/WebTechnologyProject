<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plantify user profile 3">
    <meta name="keywords" content="Plantify, user profile, profile, member">
    <meta name="author" content="Tiaw Le-San">
    <title>User Profile - Tiaw Le-San</title>

    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="contribute-page user-page user3-theme">

    <?php
        include("header.php");
        ?>
    <main class="explore-main classification-main">
        <aside class="userprofile-rail" id="rail">
            <p class="userprofile-title">User Profile<br>Levels</p>

            <nav aria-label="User Profile pages">
                <a href="user1.php">User 1</a>
                <a href="user2.php">User 2</a>
                <a href="user3.php" aria-current="page">User 3</a>
                <a href="user4.php">User 4</a>
            </nav>
        </aside>
        <section class="userprofile-content">
        <h1>User Profile</h1>

        <section class="profile-summary">
            <p class="profile-name">Tiaw Le-San</p>
            <img class="profile-photo" src="images/user/user3.jpeg" alt="Photo of Tiaw Le-San">
            <p><strong>Student Number:</strong> 106766492</p>   
            <p class="course-user3"><strong>Course:</strong> Bachelor of Data Science</p>
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
                        <td>Currently 18, I strive to do my best in my degree, Bachelor of Data Science. I hope that I do not regret taking this course &#128517; as my main passion and strength is for mathematics, but realistically speaking I do not know of the job market condition for math majors, hence I landed here.</td>
                    </tr>
                    <tr>
                        <td>Hometown</td>
                        <td>Born in Shanghai, China. Spent 11 years there before moving to Kuching in 2019, right before the pandemic. </td>
                    </tr>
                    <tr>
                        <td>Hobbies</td>
                        <td>Avid gamer, anime and manhwa/manga enthusiast. Enjoys roller skating and ice skating.</td>
                    </tr>
                    <tr>
                        <td>Fun Facts</td>
                        <td>Even though I spent so many years in China, my Mandarin skills are still subpar.</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            For more information <a class="email-button" id="email-button" href="mailto:106766492@students.swinburne.edu.my">Email Me</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </section>
        </section>
    </main>
<?php 
    include ("footer.php");
    ?>

</body>

</html>

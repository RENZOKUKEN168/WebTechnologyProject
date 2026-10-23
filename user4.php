<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plant Contribution Form">
    <meta name="keywords" content="contribution, form">
    <meta name="author" content="">
    <title>Contribution Form</title>

    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="contribute-page user-page">

    <?php
        include("header.php");
        ?>
        <main class="explore-main classification-main">
            <aside class="userprofile-rail" id="rail">
                <p class="userprofile-title">User Profile<br>Levels</p>

                <nav aria-label="User Profile pages">
                    <a href="user1.php">User 1</a>
                    <a href="user2.php">User 2</a>
                    <a href="user3.php">User 3</a>
                    <a href="user4.php" aria-current="page">User 4</a>
                </nav>
            </aside>

        <section class="userprofile-content">
        <h1>User Profile</h1>

        <section class="profile-summary">
            <p class="profile-name">Suvasis Giri</p>
            <img class="profile-photo" src="images/user/User4.jpeg" alt="Photo of Suvasis Giri">
            <p><strong>Student Number:</strong> 106759735 </p>
            <p class="course"><strong>Course:</strong> Bachelor of Computer Science in Software Development</p>
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
                        <td>Hey, I'm Suvasis, currently pursuing to enter the realms of Computer Science and hopefully not end up homeless. Until then, I feel free as a bird!!</td>
                    </tr>
                    <tr>
                        <td>Hometown</td>
                        <td>Kathmandu, Nepal</td>
                    </tr>
                    <tr>
                        <td>Hobbies</td>
                        <td>Speedrun Minecraft, read Manga, flipbooks and traveling to new areas.</td>
                    </tr>
                    <tr>
                        <td>Fun Facts</td>
                        <td><a href="https://www.youtube.com/shorts/zqMyIkc6VYw">Are you all alright? No, you are all left ✌️😂😂😂</a></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            For more information <a class="email-button" id="email-button" href="mailto:suvasisgiri.10@gmail.com">Email Me</a>
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

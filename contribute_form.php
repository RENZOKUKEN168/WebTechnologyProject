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
    <meta name="author" content="Darren">
    <title>Contribution Form</title>

    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="contribute-page">

    <?php
        include("header.php");
        ?>

    <main id="contribute-form">
        <h2>Plant Contribution Form</h2>
        <p class="form-intro">Share a plant you have discovered with the Plantify community.</p>

        <form id="form" action="#" method="post" enctype="multipart/form-data">


            <p>
                <label for="contributor">Name of Contributor:</label><br>
                <input type="text"
                       id="contributor"
                       name="contributor"
                       maxlength="25"
                       pattern="[A-Za-z ]+"
                       title="Use alphabetic characters only."
                       placeholder="(Required)"
                       required>
            </p>


            <p>
                <label for="plantname">Plant's Name:</label><br>
                <input type="text"
                    id="plantname"
                    name="plantname"
                    maxlength="25"
                    pattern="[A-Za-z ]+"
                    title="Use alphabetic characters only."
                    placeholder="(Required)"
                    required>
            </p>


            <p>
                <label for="photo">Upload Plant Photo(s):</label><br>
                <input type="file"
                    id="photo"
                    name="photo"
                    accept="image/*"
                    multiple>
            </p>


            <p>
                <label for="comments">Comments:</label><br>
                <textarea id="comments"
                    name="comments"
                    rows="6"
                    cols="40"
                    placeholder="(Optional) Enter information about the plant..."></textarea>
            </p>


            <p>
                <input type="submit" value="Submit Contribution">
                <input type="reset" value="Clear Form">
            </p>

        </form>
    </main>

    <?php
        include("footer.php");
        ?>
</body>

</html>

<?php
    session_start();
    require "connection.php";
    mysqli_report(MYSQLI_REPORT_OFF);
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS contributions (id INT AUTO_INCREMENT PRIMARY KEY, contributor VARCHAR(25) NOT NULL, plantname VARCHAR(25) NOT NULL, photos TEXT NULL, comments TEXT NULL, status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, committed_at DATETIME NULL)");
    $formMessage = "";
    $submissionSuccess = false;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $contributor = trim((string)($_POST["contributor"] ?? ""));
        $plantname = trim((string)($_POST["plantname"] ?? ""));
        $comments = trim((string)($_POST["comments"] ?? ""));
        if ($contributor === "" || $plantname === "" || strlen($contributor) > 25 || strlen($plantname) > 25 || strlen($comments) > 5000) {
            $formMessage = "Please check your name, plant name and comment.";
        } else {
            $savedPhotos = [];
            $uploadDir = __DIR__ . "/uploads/contributions";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $allowedTypes = ["image/jpeg" => "jpg", "image/png" => "png", "image/gif" => "gif", "image/webp" => "webp"];
            $uploadError = "";
            if (isset($_FILES["photo"]) && isset($_FILES["photo"]["name"])) {
                $photoFiles = $_FILES["photo"];
                if (!is_array($photoFiles["name"])) {
                    foreach (["name", "type", "tmp_name", "error", "size"] as $fileField) {
                        $photoFiles[$fileField] = [$photoFiles[$fileField] ?? ""];
                    }
                }
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                foreach ($photoFiles["name"] as $i => $originalName) {
                    $error = $photoFiles["error"][$i] ?? UPLOAD_ERR_NO_FILE;
                    if ($error === UPLOAD_ERR_NO_FILE) continue;
                    $tmp = $photoFiles["tmp_name"][$i] ?? "";
                    $mime = $tmp !== "" ? $finfo->file($tmp) : false;
                    if ($error !== UPLOAD_ERR_OK || !isset($allowedTypes[$mime]) || (int)($photoFiles["size"][$i] ?? 0) > 5 * 1024 * 1024) { $uploadError = "Use JPG, PNG, GIF or WebP photos up to 5 MB each."; break; }
                    $filename = bin2hex(random_bytes(12)) . "." . $allowedTypes[$mime];
                    if (!move_uploaded_file($tmp, $uploadDir . "/" . $filename)) { $uploadError = "A photo could not be saved."; break; }
                    $savedPhotos[] = "uploads/contributions/" . $filename;
                }
            }
            if ($uploadError !== "") $formMessage = $uploadError;
            else {
                $photos = json_encode($savedPhotos, JSON_UNESCAPED_SLASHES);
                $stmt = mysqli_prepare($conn, "INSERT INTO contributions (contributor, plantname, photos, comments, status) VALUES (?, ?, ?, ?, 'pending')");
                mysqli_stmt_bind_param($stmt, "ssss", $contributor, $plantname, $photos, $comments);
                $submissionSuccess = mysqli_stmt_execute($stmt);
                $formMessage = $submissionSuccess ? "Thank you. Your plant submission is waiting for admin review." : "Your submission could not be saved. Please try again.";
            }
        }
    }
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

    <link rel="stylesheet" href="styles/style.css?v=contribute-popup-2">
</head>

<body class="contribute-page">

    <?php
        include("header.php");
        ?>

    <main id="contribute-form">
        <h2>Plant Contribution Form</h2>
        <p class="form-intro">Share a plant you have discovered with the Plantify community.</p>
        <?php if ($formMessage !== "" && !$submissionSuccess): ?><p class="admin-error" role="alert"><?= htmlspecialchars($formMessage, ENT_QUOTES, "UTF-8") ?></p><?php endif; ?>

        <form id="form" action="contribute_form.php" method="post" enctype="multipart/form-data">


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
                    name="photo[]"
                    accept="image/jpeg,image/png,image/gif,image/webp"
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

    <?php if ($submissionSuccess): ?>
        <div class="contribution-success-backdrop">
            <section class="contribution-success-popup" role="dialog" aria-modal="true" aria-labelledby="contribution-success-title">
                <h2 id="contribution-success-title">Contribution submitted</h2>
                <p><?= htmlspecialchars($formMessage, ENT_QUOTES, "UTF-8") ?></p>
                <a class="contribution-success-ok" href="contribute_form.php">OK</a>
            </section>
        </div>
    <?php endif; ?>

    <?php
        include("footer.php");
        ?>
</body>

</html>

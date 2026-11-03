<?php
    session_start();
    require "connection.php";
    mysqli_report(MYSQLI_REPORT_OFF);
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS contributions (id INT AUTO_INCREMENT PRIMARY KEY, contributor VARCHAR(25) NOT NULL, plantname VARCHAR(25) NOT NULL, photos TEXT NULL, comments TEXT NULL, status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, committed_at DATETIME NULL)");
    $hasCommitted = mysqli_query($conn, "SHOW COLUMNS FROM contributions LIKE 'committed_at'");
    if ($hasCommitted && mysqli_num_rows($hasCommitted) === 0) mysqli_query($conn, "ALTER TABLE contributions ADD COLUMN committed_at DATETIME NULL");
    $publicContributions = mysqli_query($conn, "SELECT contributor, plantname, photos, comments FROM contributions WHERE committed_at IS NOT NULL ORDER BY committed_at DESC");
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plantify User Profile">
    <meta name="keywords" content="Plantify, user profile, profile">
    <meta name="author" content="Chin Jii Ann">
    <title>Contribute - Chin Jii Ann</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="contribute-page">
    <?php
        include("header.php");
        ?>
    <main class="contributor-page">
        <h1>Contribute to Plantify</h1>
        <section class="intro-section">
            <h2>You Don't Need to Be a Plant Expert</h2>
            <p>
                Plantify is a community for anyone who enjoys discovering
                and learning about plants. Students, gardeners, travellers
                and plant lovers can share their plant observations with others.
            </p>

            <p>
                A clear photograph, the location where you found the plant
                and a short description can help others learn more about
                plants around Malaysia.
            </p>

            <figure>
                <img src="images/contributor/contribute-plant.jpg"
                    alt="Green tropical plant">
                <figcaption>
                    Share your plant observations with the Plantify community.
                </figcaption>
            </figure>
        </section>

        <section class="contributions-section">
            <h2>Recent Community Contributions</h2>
            <p>
                Explore some of the plants recently shared by our contributors.
            </p>
            <div class="contributor-card">

                <figure>
                    <img src="images/contributor/dipterocarp.jpg"
                        alt="Tropical plant leaves">
                    <figcaption>Photo contributed by Amy</figcaption>
                </figure>

                <h3>Amy</h3>

                <dl>
                    <dt>Plant Name</dt>
                    <dd>Dipterocarp Seedling</dd>

                    <dt>Location</dt>
                    <dd>Kinabalu Park, Sabah</dd>

                    <dt>Comments</dt>
                    <dd>Found after rain. Plant left in place.</dd>
                </dl>

            </div>

            <div class="contributor-card">

                <figure>
                    <img src="images/contributor/resak-rawa.jpg"
                        alt="Forest plant leaves">
                    <figcaption>Photo contributed by Calvin</figcaption>
                </figure>

                <h3>Calvin</h3>

                <dl>
                    <dt>Plant Name</dt>
                    <dd>Resak Rawa</dd>

                    <dt>Location</dt>
                    <dd>Kuala Lumpur, Malaysia</dd>

                    <dt>Comments</dt>
                    <dd>The leaf shape is the most noticeable feature.</dd>
                </dl>

            </div>
            <?php if ($publicContributions): while ($communityPlant = mysqli_fetch_assoc($publicContributions)): $communityPhotos = json_decode((string)($communityPlant["photos"] ?? ""), true); $communityPhotos = is_array($communityPhotos) ? $communityPhotos : []; ?>
            <div class="contributor-card">
                <?php if ($communityPhotos): ?><figure><img src="<?= htmlspecialchars($communityPhotos[0], ENT_QUOTES, "UTF-8") ?>" alt="Photo of <?= htmlspecialchars($communityPlant["plantname"], ENT_QUOTES, "UTF-8") ?>"><figcaption>Community contribution</figcaption></figure><?php endif; ?>
                <h3><?= htmlspecialchars($communityPlant["contributor"], ENT_QUOTES, "UTF-8") ?></h3>
                <dl><dt>Plant Name</dt><dd><?= htmlspecialchars($communityPlant["plantname"], ENT_QUOTES, "UTF-8") ?></dd><dt>Comments</dt><dd><?= nl2br(htmlspecialchars($communityPlant["comments"] ?? "", ENT_QUOTES, "UTF-8")) ?></dd></dl>
            </div>
            <?php endwhile; endif; ?>

        </section>

        <section class="how-to-section">

            <h2>How to Contribute</h2>

            <ol>
                <li>Choose a plant you would like to share.</li>
                <li>Take a clear photograph of the plant.</li>
                <li>Enter the plant name and location if known.</li>
                <li>Add a short comment about your observation.</li>
                <li>Submit your contribution to Plantify.</li>
            </ol>

            <a href="contribute_form.php" id="contribute-btn" class="contribute-btn">
                Contribute a Plant
            </a>

        </section>

        <aside class="contributor-aside">

            <h2>Plant Contribution Tips</h2>

            <p>
                Keep these tips in mind when making your contribution.
            </p>

            <ul>
                <li>Take a clear photo of the whole plant.</li>
                <li>Include a close-up of the leaves or flowers.</li>
                <li>Record the location where you found the plant.</li>
                <li>Do not damage or remove protected plants.</li>
                <li>Write your observation while you remember it.</li>
            </ul>

            <p>
                Ready to share?
                <a href="contribute_form.php">Add a plant now.</a>
            </p>

        </aside>
    </main>

    <?php
        include("footer.php");
        ?>
</body>
</html>

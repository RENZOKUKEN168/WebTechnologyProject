<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
include "createdatabase_table.php";
@include "connection.php";

$needConn = true;
if (isset($conn) && $conn instanceof mysqli) {
    try {
        if (mysqli_thread_id($conn)) {
            $needConn = false;
        }
    } catch (Throwable $e) {
        $needConn = true;
    }
}
if ($needConn) {
    $conn = mysqli_connect("localhost", "root", "", "plantify_db");
}

if ($conn) {
    $createPlantTableSql = "CREATE TABLE IF NOT EXISTS plant (
        id INT AUTO_INCREMENT PRIMARY KEY,
        scientific_name VARCHAR(100) NOT NULL UNIQUE,
        common_name VARCHAR(100) NOT NULL,
        family VARCHAR(50) NOT NULL,
        genus VARCHAR(50) NOT NULL,
        main_feature ENUM('leaves','flowers','fruit','bark') NOT NULL,
        habitat_location VARCHAR(150) NOT NULL,
        care_instructions TEXT NOT NULL,
        description TEXT NOT NULL,
        keywords VARCHAR(255) NOT NULL,
        image_path VARCHAR(255) NOT NULL,
        species_link VARCHAR(120) NOT NULL
    )";
    mysqli_query($conn, $createPlantTableSql);

    $seedPlants = [
        ["Vatica borneensis", "Resak Borneo", "Dipterocarpaceae", "Vatica", "leaves", "Borneo, Sarawak, lowland dipterocarp forest", "Thrives in well-drained acidic forest soil with high humidity and partial shade when young.", "A tree endemic to Borneo's dipterocarp forests growing to about 35 metres, with leathery elliptic leaves and dense clusters of pinkish-brown flowers. Conservation: Near Threatened.", "borneo sarawak kuching dipterocarp leathery elliptic pinkish brown flower near threatened", "images/species/vatica-borneensis.jpg", "species.php#vatica-borneensis-species"],
        ["Vatica flavida", "Resak Padi", "Dipterocarpaceae", "Vatica", "flowers", "Peninsular Malaysia, wet tropical lowland and swamp forest", "Requires consistently moist or swampy tropical soil and filtered sunlight.", "Known as resak padi, this evergreen tree is native to Peninsular Malaysia. It bears yellow flowers and grows in wet tropical lowland forest, including swampy habitats. Conservation: Critically Endangered.", "resak padi peninsular malaysia yellow flower swamp wet lowland critically endangered", "images/species/vatica-flavida.jpg", "species.php#vatica-flavida-species"],
        ["Dipterocarpus alatus", "Keruing Putih", "Dipterocarpaceae", "Dipterocarpus", "fruit", "Southeast Asia, Sarawak, lowland rainforest and riverbanks", "Prefers deep alluvial soil near rivers with high tropical rainfall.", "A large Southeast Asian rainforest tree recognised by its straight trunk, resin and two-winged fruits. It often grows in lowland forest and near rivers.", "southeast asia sarawak straight trunk resin two-winged winged fruit lowland river", "images/species/dipterocarpus-alatus.jpeg", "species.php#dipterocarpus-alatus-species"],
        ["Dipterocarpus grandiflorus", "Alakal / Keruing", "Dipterocarpaceae", "Dipterocarpus", "bark", "South and Southeast Asia, Borneo, hill dipterocarp forest", "Needs full canopy sunlight at maturity and well-drained ridge soil.", "This medium to large hardwood tree occurs across South and Southeast Asia. Its timber is sold as keruing, while its gum has traditionally been used as a waterproofing varnish.", "alakal keruing hardwood gum resin varnish south asia southeast asia borneo sarawak", "images/species/dipterocarpus-grandiflorus.jpeg", "species.php#dipterocarpus-grandiflorus-species"],
        ["Actinodaphne mushaensis", "Musha Laurel", "Lauraceae", "Actinodaphne", "leaves", "Taiwan, evergreen mountain forest", "Grows well in cool-to-warm humid conditions with humus-rich, well-drained soil.", "An evergreen laurel native to Taiwan, carrying glossy leaves in clusters near the ends of its branches with small flowers and drupes.", "laurel taiwan glossy cluster branch drupe small flower", "images/species/actinodaphne-mushaensis.jpeg", "species.php#actinodaphne-mushaensis-species"],
        ["Actinodaphne wightiana", "Medang Kunyit", "Lauraceae", "Actinodaphne", "leaves", "Southern India, evergreen tropical forest", "Requires partial shade, moist acidic soil, and organic mulch.", "This evergreen tree is associated with the forests of southern India. Aromatic foliage and compact flower clusters identify it as a member of the laurel family.", "southern india india aromatic foliage compact flower cluster laurel", "images/species/actinodaphne-wightiana.jpeg", "species.php#actinodaphne-wightiana-species"],
        ["Endiandra sieberi", "Hard Corkwood", "Lauraceae", "Endiandra", "bark", "Eastern Australia, coastal rainforest", "Tolerates sandy coastal soils once established; requires good drainage.", "Commonly called hard corkwood, this evergreen rainforest tree grows along Australia's eastern coast and develops dark fleshy fruits containing a single large seed.", "hard corkwood corky australia coast coastal dark fleshy fruit large seed", "images/species/endiandra-sieberi.jpg", "species.php#endiandra-sieberi-species"],
        ["Endiandra discolor", "Domatia Tree", "Lauraceae", "Endiandra", "leaves", "Eastern Australia, lowland rainforest", "Keep soil consistently moist and rich in organic leaf litter; tolerates shade.", "The domatia tree is an eastern Australian rainforest species, named for the tiny sheltered pockets where its leaf veins meet.", "domatia vein pocket australia rainforest leaf vein", "images/species/endiandra-discolor.jpg", "species.php#endiandra-discolor-species"],
        ["Canarium album", "Chinese Olive", "Burseraceae", "Canarium", "fruit", "Malaysia and Southern Asia, lowland forest and orchards", "Water regularly during dry periods; thrives in loamy soil with full sun.", "The Chinese olive is an evergreen tree cultivated for its edible oval fruit, which has a distinctive resinous flavour.", "chinese olive edible oval green fruit resinous cultivated", "images/species/canarium-album.jpeg", "species.php#canarium-album-species"],
        ["Canarium australasicum", "Brown Cudgerie", "Burseraceae", "Canarium", "leaves", "Northern Australia and Malesian tropical rainforest", "Requires rich organic soil, warm temperatures, and shelter from strong wind.", "Known as brown cudgerie, this rainforest tree is native to northern Australia and nearby tropical regions, bearing compound leaves and dark fleshy fruits.", "brown cudgerie compound leaf dark fruit fleshy northern australia tropical", "images/species/canarium-australasicum.jpeg", "species.php#canarium-australasicum-species"],
        ["Dacryodes excelsa", "Gommier", "Burseraceae", "Dacryodes", "bark", "Caribbean humid mountain rainforest", "Prefers well-drained hillside soils and high ambient humidity.", "This tall Caribbean forest tree is commonly called gommier. Its pale aromatic resin was traditionally used for torches, incense and sealing wooden boats.", "gommier pale aromatic resin incense caribbean tall bark", "images/species/dacryodes-excelsa.jpeg", "species.php#dacryodes-excelsa-species"],
        ["Dacryodes rostrata", "Kembayau", "Burseraceae", "Dacryodes", "fruit", "Southeast Asia, Sarawak, Borneo, humid lowland forest", "Grows best in deep, fertile tropical clay-loam with high annual rainfall.", "A tropical Southeast Asian tree of humid lowland forest that produces resin and fleshy drupes with a characteristic beak-like tip.", "beak drupe fleshy resin lowland humid southeast asia sarawak borneo kuching purple black", "images/species/dacryodes-rostrata.jpg", "species.php#dacryodes-rostrata-species"],
        ["Horsfieldia irya", "Penarahan Pianggu", "Myristicaceae", "Horsfieldia", "fruit", "Tropical Asia, Sarawak, riverine and lowland forest", "Thrives in wet, muddy, or riverside soils with full sun to partial shade.", "This nutmeg relative grows in tropical Asian lowland and riverine forests. Its fruit opens to display a dark seed partly covered by a colourful aril.", "nutmeg aril colourful orange red dark seed riverine river lowland tropical asia sarawak kuching", "images/species/horsfieldia-irya.jpg", "species.php#horsfieldia-irya-species"],
        ["Horsfieldia superba", "Penarahan Daun Besar", "Myristicaceae", "Horsfieldia", "leaves", "Southeast Asia, Peninsular Malaysia, Borneo rainforest", "Needs warm temperatures, high humidity, and deep well-drained forest soil.", "An evergreen Southeast Asian rainforest tree with simple leathery leaves, fleshy fruits, and separate male and female flowers.", "leathery simple leaf large leaf fleshy fruit southeast asia malaysia sarawak rainforest", "images/species/horsfieldia-superba.jpg", "species.php#horsfieldia-superba-species"],
        ["Knema attenuata", "Wild Nutmeg", "Myristicaceae", "Knema", "fruit", "India, Western Ghats evergreen forest", "Best grown in shaded, humid understory conditions with rich organic soil.", "Often called wild nutmeg, this evergreen tree is native to India's Western Ghats. Its fruit splits to expose a glossy seed enclosed by a bright red aril.", "wild nutmeg bright red aril glossy seed western ghats india", "images/species/knema-attenuata.jpg", "species.php#knema-attenuata-species"],
        ["Knema conferta", "Penarahan Pipit", "Myristicaceae", "Knema", "flowers", "Tropical Asia, Sarawak, Borneo peat swamp and lowland forest", "Adapts well to moist peat and alluvial soils under filtered canopy light.", "A tropical Asian evergreen tree in the nutmeg family that produces small clustered flowers and arillate seeds.", "clustered flower arillate aril nutmeg tropical asia sarawak borneo kuching", "images/species/knema-conferta.jpeg", "species.php#knema-conferta-species"]
    ];

    $seedStmt = mysqli_prepare($conn, "INSERT IGNORE INTO plant (scientific_name, common_name, family, genus, main_feature, habitat_location, care_instructions, description, keywords, image_path, species_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($seedStmt) {
        foreach ($seedPlants as $sp) {
            mysqli_stmt_bind_param($seedStmt, " sssssssssss", $sp[0], $sp[1], $sp[2], $sp[3], $sp[4], $sp[5], $sp[6], $sp[7], $sp[8], $sp[9], $sp[10]);
            mysqli_stmt_execute($seedStmt);
        }
        mysqli_stmt_close($seedStmt);
    }
}

$isAuthenticated = !empty($_SESSION["user_id"]);

$formErrors = [];
$matches = [];
$hasSearched = false;
$uploadedPhotoPath = "";
$locationInput = trim((string)($_POST["location"] ?? ""));
$featureInput = trim((string)($_POST["feature"] ?? ""));
$notesInput = trim((string)($_POST["notes"] ?? ""));

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!$isAuthenticated) {
        $formErrors[] = "Authentication required. Please log in before identifying plants.";
    } else {
        $validFeatures = ["leaves", "flowers", "fruit", "bark"];

        if ($locationInput === "" && $notesInput === "" && $featureInput === "") {
            $formErrors[] = "Please provide a location, visible feature, or observation keywords to search.";
        }
        if ($featureInput !== "" && !in_array($featureInput, $validFeatures, true)) {
            $formErrors[] = "Please select a valid visible feature.";
        }

        if (isset($_FILES["plant_photo"]) && ($_FILES["plant_photo"]["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
            $fileErr = $_FILES["plant_photo"]["error"] ?? UPLOAD_ERR_NO_FILE;
            $tmpPath = $_FILES["plant_photo"]["tmp_name"] ?? "";
            $allowedTypes = ["image/jpeg" => "jpg", "image/png" => "png", "image/gif" => "gif", "image/webp" => "webp"];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $tmpPath !== "" ? $finfo->file($tmpPath) : false;

            if ($fileErr !== UPLOAD_ERR_OK || !isset($allowedTypes[$mime]) || (int)($_FILES["plant_photo"]["size"] ?? 0) > 5 * 1024 * 1024) {
                $formErrors[] = "Use a JPG, PNG, GIF or WebP photo up to 5 MB.";
            } else {
                $uploadDir = __DIR__ . "/uploads/identifications";
                if (!is_dir($uploadDir)) {
                    @mkdir($uploadDir, 0775, true);
                }
                $savedName = bin2hex(random_bytes(12)) . "." . $allowedTypes[$mime];
                if (move_uploaded_file($tmpPath, $uploadDir . "/" . $savedName)) {
                    $uploadedPhotoPath = "uploads/identifications/" . $savedName;
                } else {
                    $formErrors[] = "The uploaded photo could not be saved.";
                }
            }
        }

        if (empty($formErrors) && $conn) {
            $hasSearched = true;
            $conditions = [];
            $params = [];
            $types = "";

            if ($featureInput !== "") {
                $conditions[] = "main_feature = ?";
                $params[] = $featureInput;
                $types .= "s";
            }

            if ($locationInput !== "") {
                $conditions[] = "(habitat_location LIKE ? OR keywords LIKE ?)";
                $locLike = "%" . $locationInput . "%";
                $params[] = $locLike;
                $params[] = $locLike;
                $types .= "ss";
            }

            if ($notesInput !== "") {
                $terms = array_values(array_filter(preg_split('/[\s,]+/', $notesInput)));
                foreach (array_slice($terms, 0, 5) as $term) {
                    $conditions[] = "(scientific_name LIKE ? OR common_name LIKE ? OR family LIKE ? OR genus LIKE ? OR description LIKE ? OR keywords LIKE ?)";
                    $termLike = "%" . $term . "%";
                    for ($k = 0; $k < 6; $k++) {
                        $params[] = $termLike;
                        $types .= "s";
                    }
                }
            }

            $whereClause = !empty($conditions) ? "WHERE " . implode(" OR ", $conditions) : "";
            $searchSql = "SELECT id, scientific_name, common_name, family, genus, main_feature, habitat_location, care_instructions, description, keywords, image_path, species_link FROM plant " . $whereClause;
            $searchStmt = mysqli_prepare($conn, $searchSql);

            if ($searchStmt) {
                if ($types !== "") {
                    mysqli_stmt_bind_param($searchStmt, $types, ...$params);
                }
                mysqli_stmt_execute($searchStmt);
                $searchRes = mysqli_stmt_get_result($searchStmt);

                $rawTokens = array_values(array_filter(preg_split('/[\s,]+/', strtolower($locationInput . " " . $notesInput))));
                while ($searchRes && ($row = mysqli_fetch_assoc($searchRes))) {
                    $score = 0;
                    if ($featureInput !== "" && $row["main_feature"] === $featureInput) {
                        $score += 30;
                    }
                    $haystack = strtolower($row["scientific_name"] . " " . $row["common_name"] . " " . $row["family"] . " " . $row["genus"] . " " . $row["habitat_location"] . " " . $row["description"] . " " . $row["keywords"]);
                    foreach ($rawTokens as $tok) {
                        if (strlen($tok) >= 2 && strpos($haystack, $tok) !== false) {
                            $score += 15;
                        }
                    }
                    $row["relevance"] = $score;
                    $matches[] = $row;
                }
                mysqli_stmt_close($searchStmt);
            }

            if ($notesInput !== "") {
                $contribStmt = mysqli_prepare($conn, "SELECT contributor, plantname, photos, comments FROM contribute WHERE status = 'approved' AND (plantname LIKE ? OR comments LIKE ?)");
                if ($contribStmt) {
                    $noteLike = "%" . $notesInput . "%";
                    mysqli_stmt_bind_param($contribStmt, "ss", $noteLike, $noteLike);
                    mysqli_stmt_execute($contribStmt);
                    $contribRes = mysqli_stmt_get_result($contribStmt);
                    while ($contribRes && ($cRow = mysqli_fetch_assoc($contribRes))) {
                        $decodedPhotos = json_decode((string)($cRow["photos"] ?? ""), true);
                        $firstPhoto = (is_array($decodedPhotos) && !empty($decodedPhotos[0])) ? $decodedPhotos[0] : "images/contributor/contribute-plant.jpg";
                        $matches[] = [
                            "scientific_name" => $cRow["plantname"],
                            "common_name" => "Community Submission",
                            "family" => "Community Repository",
                            "genus" => "Approved Record",
                            "main_feature" => $featureInput !== "" ? $featureInput : "leaves",
                            "habitat_location" => "Contributed by " . $cRow["contributor"],
                            "care_instructions" => "Verified community submission from Plantify contributors.",
                            "description" => (string)($cRow["comments"] ?? ""),
                            "image_path" => $firstPhoto,
                            "species_link" => "contribute.php",
                            "relevance" => 25
                        ];
                    }
                    mysqli_stmt_close($contribStmt);
                }
            }

            usort($matches, function ($a, $b) {
                return $b["relevance"] <=> $a["relevance"];
            });
            $matches = array_slice($matches, 0, 5);
        }
    }
}

if (isset($conn) && $conn instanceof mysqli) {
    try {
        mysqli_close($conn);
    } catch (Throwable $e) {
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn how to identify Malaysian plants using photographs and their visible characteristics with Plantify.">
    <meta name="keywords" content="Plantify, plant identifier, biodiversity, Malaysia">
    <meta name="author" content="Plantify Team">
    <title>Identify Plants - Plantify</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="contribute-page identify-page">

    <?php include ("header.php"); ?>

    <main id="main-content" class="identifier-main">

        <section class="identifier-hero" aria-labelledby="identifier-heading">
            <img class="identifier-hero-background" src="images/explore-background1.png" alt="Lush green tropical plant leaves">
            <div class="identifier-hero-shade" aria-hidden="true"></div>

            <div class="identifier-hero-content">
                <p class="identifier-eyebrow">DISCOVER THE WORLD AROUND YOU</p>
                <h1 id="identifier-heading">Identify<br>a plant<span class="identifier-dot">.</span></h1>
                <p class="identifier-hero-description">Not sure which plant you have discovered? Start with a clear photograph, observe its unique features, and explore the plant families, genera and species documented by Plantify.</p>
                <p class="identifier-hero-detail">Once identified, a plant's name, care instructions, preferred environment and geographical location can be displayed.</p>
                <a class="identifier-hero-link" href="#identify-form">Start identifying <span aria-hidden="true">↓</span></a>
            </div>

            <div class="identifier-hero-index" aria-hidden="true">01 / DISCOVER</div>
        </section>

        <div class="identifier-workspace" id="identify-form">
            <div class="identifier-section-heading">
                <p class="identifier-eyebrow">01 / YOUR DISCOVERY</p>
                <h2>Every plant has a story.</h2>
                <p>Search the Plantify MySQL botanical repository by plant name, habitat location, primary visible feature, or field observations.</p>
            </div>

            <div class="identifier-layout">
                <section class="identifier-form-section" aria-labelledby="identify-form-heading">

                    <div class="identifier-form-title">
                        <span class="identifier-step">01</span>
                        <div>
                            <h3 id="identify-form-heading">Describe your plant</h3>
                            <p>Signed-in members can search the plant database and preview uploaded specimen photos.</p>
                        </div>
                    </div>

                    <?php if (!$isAuthenticated): ?>
                        <div class="admin-error" role="alert">
                            <p><strong>Login Required:</strong> Please <a href="login.php">log in to your Plantify account</a> to access the database plant identification search.</p>
                        </div>
                    <?php else: ?>
                        <p class="admin-message">Signed in as <strong><?= htmlspecialchars((string)($_SESSION["username"] ?? "Member"), ENT_QUOTES, "UTF-8") ?></strong>. Ready to search the plant database.</p>

                        <?php if (!empty($formErrors)): ?>
                            <div class="admin-error" role="alert">
                                <?php foreach ($formErrors as $err): ?>
                                    <p><?= htmlspecialchars($err, ENT_QUOTES, "UTF-8") ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form action="identify.php#identify-results" method="post" enctype="multipart/form-data" class="identifier-form">
                            <fieldset>
                                <legend>Plant observations</legend>

                                <div class="identifier-field identifier-field-wide">
                                    <label for="identifier-photo">Choose a plant photograph (Optional preview)</label>
                                    <input type="file" id="identifier-photo" name="plant_photo" accept="image/jpeg,image/png,image/gif,image/webp">
                                    <small>A close, well-lit photograph of the leaves or flowers works best.</small>
                                </div>

                                <div class="identifier-field">
                                    <label for="identifier-location">Where was it found?</label>
                                    <input type="text" id="identifier-location" name="location" maxlength="80" placeholder="e.g. Kuching, Sarawak" value="<?= htmlspecialchars($locationInput, ENT_QUOTES, "UTF-8") ?>">
                                </div>

                                <div class="identifier-field">
                                    <label for="identifier-feature">Main visible feature</label>
                                    <select id="identifier-feature" name="feature">
                                        <option value="">Select a feature</option>
                                        <option value="leaves" <?= $featureInput === "leaves" ? "selected" : "" ?>>Leaves or leaf pattern</option>
                                        <option value="flowers" <?= $featureInput === "flowers" ? "selected" : "" ?>>Flowers</option>
                                        <option value="fruit" <?= $featureInput === "fruit" ? "selected" : "" ?>>Fruit or seeds</option>
                                        <option value="bark" <?= $featureInput === "bark" ? "selected" : "" ?>>Bark or trunk</option>
                                    </select>
                                </div>

                                <div class="identifier-field identifier-field-wide">
                                    <label for="identifier-notes">Other observations</label>
                                    <textarea id="identifier-notes" name="notes" rows="4" cols="45" maxlength="500" placeholder="Describe its colour, size, growing environment or plant name (e.g. Vatica, Keruing, Sarawak, yellow flower)."><?= htmlspecialchars($notesInput, ENT_QUOTES, "UTF-8") ?></textarea>
                                </div>
                            </fieldset>

                            <div class="identifier-actions">
                                <button type="submit" class="identifier-submit">Search plant <span aria-hidden="true">↗</span></button>
                                <button type="reset" class="identifier-reset">Clear form</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </section>

                <aside class="identifier-tips" aria-labelledby="identifier-tips-heading">
                    <p class="identifier-eyebrow">FIELD GUIDE</p>
                    <h3 id="identifier-tips-heading">A better photo.<br>A better start.</h3>

                    <figure class="identifier-tips-photo">
                        <img src="images/explore-families.jpg" alt="Green tropical leaves showing distinct shapes and texture">
                        <figcaption>Observe leaf shapes, patterns and surroundings.</figcaption>
                    </figure>

                    <ol>
                        <li><strong>Find good light.</strong> Keep the plant clearly in focus.</li>
                        <li><strong>Check its features.</strong> Photograph leaves, flowers or fruit.</li>
                        <li><strong>Note the habitat.</strong> Record where it is growing.</li>
                        <li><strong>Leave it growing.</strong> Avoid removing protected plants.</li>
                    </ol>

                    <p class="identifier-tip-footnote">Similar-looking plants may need expert verification before their identity is confirmed.</p>
                </aside>
            </div>

            <?php if ($hasSearched): ?>
                <div class="family-list" id="identify-results">
                    <div class="classification-divider">
                        <p>Database Search Results</p>
                        <h3>Matching Plants</h3>
                        <span><?= count($matches) ?> match(es) found</span>
                    </div>

                    <?php if ($uploadedPhotoPath !== ""): ?>
                        <article class="family-row">
                            <div class="family-image">
                                <img src="<?= htmlspecialchars($uploadedPhotoPath, ENT_QUOTES, "UTF-8") ?>" alt="Uploaded specimen photo">
                                <span>00</span>
                            </div>
                            <div class="family-copy">
                                <p class="family-label">Uploaded Specimen</p>
                                <h3>Your Observation</h3>
                                <?php if ($notesInput !== ""): ?>
                                    <p class="family-description"><?= htmlspecialchars($notesInput, ENT_QUOTES, "UTF-8") ?></p>
                                <?php endif; ?>
                                <?php if ($locationInput !== ""): ?>
                                    <p class="family-genera"><strong>Location:</strong> <?= htmlspecialchars($locationInput, ENT_QUOTES, "UTF-8") ?></p>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endif; ?>

                    <?php if (empty($matches)): ?>
                        <p class="admin-error">No matching plants were found in the database for your search terms. Try broader keywords such as <strong>Vatica</strong>, <strong>Sarawak</strong>, <strong>resin</strong>, or <strong>nutmeg</strong>.</p>
                    <?php else: ?>
                        <?php foreach ($matches as $idx => $plant): ?>
                            <article class="family-row">
                                <div class="family-image">
                                    <img src="<?= htmlspecialchars($plant["image_path"], ENT_QUOTES, "UTF-8") ?>" alt="<?= htmlspecialchars($plant["scientific_name"], ENT_QUOTES, "UTF-8") ?>">
                                    <span>0<?= $idx + 1 ?></span>
                                </div>
                                <div class="family-copy">
                                    <p class="family-label"><?= htmlspecialchars($plant["family"], ENT_QUOTES, "UTF-8") ?> · <?= htmlspecialchars($plant["genus"], ENT_QUOTES, "UTF-8") ?></p>
                                    <h3><i><?= htmlspecialchars($plant["scientific_name"], ENT_QUOTES, "UTF-8") ?></i> (<?= htmlspecialchars($plant["common_name"], ENT_QUOTES, "UTF-8") ?>)</h3>
                                    <p class="family-description"><?= htmlspecialchars($plant["description"], ENT_QUOTES, "UTF-8") ?></p>
                                    <p class="family-genera"><strong>Preferred Environment &amp; Location:</strong> <?= htmlspecialchars($plant["habitat_location"], ENT_QUOTES, "UTF-8") ?></p>
                                    <p class="family-genera"><strong>Care Instructions:</strong> <?= htmlspecialchars($plant["care_instructions"], ENT_QUOTES, "UTF-8") ?></p>
                                    <a href="<?= htmlspecialchars($plant["species_link"], ENT_QUOTES, "UTF-8") ?>">View in Species Catalogue ↗</a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <section class="identifier-explore" aria-labelledby="identifier-explore-heading">
            <div class="identifier-section-heading">
                <p class="identifier-eyebrow">02 / KEEP EXPLORING</p>
                <h2 id="identifier-explore-heading">From family to species.</h2>
                <p>Follow the branches of plant classification and compare photographs with the Plantify collection.</p>
            </div>

            <div class="identifier-cards">
                <a class="identifier-card" href="families.php#families-list">
                    <article>
                        <img src="images/explore-families.jpg" alt="Lush green tropical leaves">
                        <div class="identifier-card-content">
                            <p class="identifier-card-number">01 / BROAD CLASSIFICATION</p>
                            <h3>Families</h3>
                            <p>Discover characteristics shared across larger groups of related plants.</p>
                            <span class="identifier-card-action">Explore families <b aria-hidden="true">↗</b></span>
                        </div>
                    </article>
                </a>

                <a class="identifier-card" href="genera.php#genera-list">
                    <article>
                        <img src="images/explore-genera.jpg" alt="Green leaves and flowers">
                        <div class="identifier-card-content">
                            <p class="identifier-card-number">02 / CLOSER RELATIVES</p>
                            <h3>Genera</h3>
                            <p>Narrow down the possibilities by studying plants with closer similarities.</p>
                            <span class="identifier-card-action">Explore genera <b aria-hidden="true">↗</b></span>
                        </div>
                    </article>
                </a>

                <a class="identifier-card" href="species.php#species-list">
                    <article>
                        <img src="images/explore-species.jpg" alt="Bright flowers and green foliage">
                        <div class="identifier-card-content">
                            <p class="identifier-card-number">03 / PLANT IDENTITY</p>
                            <h3>Species</h3>
                            <p>Explore individual plant types through images and botanical descriptions.</p>
                            <span class="identifier-card-action">Explore species <b aria-hidden="true">↗</b></span>
                        </div>
                    </article>
                </a>
            </div>
        </section>

        <section class="identifier-glossary" aria-labelledby="identifier-glossary-heading">
            <div class="identifier-glossary-heading">
                <p class="identifier-eyebrow">THE BASICS</p>
                <h2 id="identifier-glossary-heading">A quick identification glossary</h2>
            </div>

            <dl>
                <div><dt>Family</dt><dd>A broad group of related plant genera.</dd></div>
                <div><dt>Genus</dt><dd>A group of closely related species.</dd></div>
                <div><dt>Species</dt><dd>A particular kind of plant within a genus.</dd></div>
            </dl>
        </section>

    </main>

    <?php include ("footer.php"); ?>

</body>
</html>
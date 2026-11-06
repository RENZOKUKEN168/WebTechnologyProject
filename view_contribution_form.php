<?php
session_start();

if (($_SESSION["role"] ?? "") !== "admin" || empty($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

include "connection.php";
mysqli_report(MYSQLI_REPORT_OFF);

function plantEscape($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

if (empty($_SESSION["admin_csrf"])) {
    $_SESSION["admin_csrf"] = bin2hex(random_bytes(32));
}

$csrf = $_SESSION["admin_csrf"];
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        !isset($_POST["csrf_token"]) ||
        !hash_equals($csrf, (string)$_POST["csrf_token"])
    ) {
        http_response_code(400);
        exit("Invalid form token.");
    }

    $id = (int)($_POST["id"] ?? 0);
    $action = (string)($_POST["action"] ?? "");

    if ($action === "review") {
        $status = (string)($_POST["status"] ?? "pending");

        if (!in_array($status, ["pending", "approved", "rejected"], true)) {
            $message = "Invalid review status.";
        } else {
            $statement = mysqli_prepare(
                $conn,
                "UPDATE contribute SET status = ? WHERE id = ?"
            );
            mysqli_stmt_bind_param($statement, "si", $status, $id);
            $message = mysqli_stmt_execute($statement)
                ? "Review status updated."
                : "Could not update the status.";
        }
    } elseif ($action === "commit") {
        $statement = mysqli_prepare(
            $conn,
            "UPDATE contribute
             SET committed_at = NOW()
             WHERE id = ? AND status = 'approved' AND committed_at IS NULL"
        );
        mysqli_stmt_bind_param($statement, "i", $id);

        $message = mysqli_stmt_execute($statement) && mysqli_stmt_affected_rows($statement) === 1
            ? "Plant committed to the public Contribution page."
            : "Approve the submission before committing it.";
    } elseif ($action === "delete") {
        $findStatement = mysqli_prepare(
            $conn,
            "SELECT photos FROM contribute WHERE id = ?"
        );
        mysqli_stmt_bind_param($findStatement, "i", $id);
        mysqli_stmt_execute($findStatement);
        $row = mysqli_fetch_assoc(mysqli_stmt_get_result($findStatement));

        $deleteStatement = mysqli_prepare(
            $conn,
            "DELETE FROM contribute WHERE id = ?"
        );
        mysqli_stmt_bind_param($deleteStatement, "i", $id);
        $message = mysqli_stmt_execute($deleteStatement)
            ? "Submission deleted."
            : "Could not delete submission.";

        if ($row) {
            $photos = json_decode((string)$row["photos"], true) ?: [];

            foreach ($photos as $photo) {
                $file = __DIR__ . "/" . ltrim((string)$photo, "/");
                $base = realpath(__DIR__ . "/uploads/contributions");
                $realFile = realpath($file);

                if (
                    $realFile &&
                    $base &&
                    strpos($realFile, $base . DIRECTORY_SEPARATOR) === 0 &&
                    is_file($realFile)
                ) {
                    @unlink($realFile);
                }
            }
        }
    } elseif ($action === "edit") {
        $name = trim((string)($_POST["plantname"] ?? ""));
        $person = trim((string)($_POST["contributor"] ?? ""));
        $comments = trim((string)($_POST["comments"] ?? ""));

        if (
            $name === "" ||
            $person === "" ||
            strlen($name) > 25 ||
            strlen($person) > 25 ||
            strlen($comments) > 5000
        ) {
            $message = "Check the plant name, contributor and comments.";
        } else {
            $statement = mysqli_prepare(
                $conn,
                "UPDATE contribute
                 SET plantname = ?, contributor = ?, comments = ?
                 WHERE id = ?"
            );
            mysqli_stmt_bind_param($statement, "sssi", $name, $person, $comments, $id);
            $message = mysqli_stmt_execute($statement)
                ? "Submission details updated."
                : "Could not update submission.";
        }
    }
}

$edit = null;

if (isset($_GET["edit"])) {
    $id = (int)$_GET["edit"];
    $statement = mysqli_prepare(
        $conn,
        "SELECT * FROM contribute WHERE id = ?"
    );
    mysqli_stmt_bind_param($statement, "i", $id);
    mysqli_stmt_execute($statement);
    $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($statement)) ?: null;
}

$rows = mysqli_query(
    $conn,
    "SELECT id, contributor, plantname, photos, comments, status, created_at, committed_at
     FROM contribute
     ORDER BY created_at DESC, id DESC"
);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plant Contributions | Plantify Admin</title>
    <link rel="stylesheet" href="styles/style.css?v=contribution-review-flow-1">
</head>
<body class="admin-page">
    <?php include "admin_header.php"; ?>

    <main class="admin-shell">
        <h1>Plant submissions</h1>
        <p>Check the submitted plant details and photos before publishing them on the public Contribution page.</p>

        <?php if ($message !== ""): ?>
            <p class="admin-message" role="status"><?= plantEscape($message) ?></p>
        <?php endif; ?>

        <?php if ($edit): ?>
            <section class="admin-card">
                <h2>Edit submission</h2>

                <form class="admin-form" method="post">
                    <input type="hidden" name="csrf_token" value="<?= plantEscape($csrf) ?>">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= (int)$edit["id"] ?>">

                    <label>
                        Plant name
                        <input
                            name="plantname"
                            maxlength="25"
                            required
                            value="<?= plantEscape($edit["plantname"]) ?>"
                        >
                    </label>

                    <label>
                        Contributor
                        <input
                            name="contributor"
                            maxlength="25"
                            required
                            value="<?= plantEscape($edit["contributor"]) ?>"
                        >
                    </label>

                    <label class="admin-wide">
                        Comments
                        <textarea name="comments" rows="4"><?= plantEscape($edit["comments"] ?? "") ?></textarea>
                    </label>

                    <div class="admin-actions">
                        <button type="submit">Save changes</button>
                        <a href="view_contribution_form.php">Cancel</a>
                    </div>
                </form>
            </section>
        <?php endif; ?>

        <section class="admin-card">
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Plant / contributor</th>
                            <th>Submitted photos</th>
                            <th>Comments</th>
                            <th>Submitted</th>
                            <th>Review</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($rows && mysqli_num_rows($rows)): ?>
                            <?php while ($row = mysqli_fetch_assoc($rows)): ?>
                                <?php
                                $photos = json_decode((string)($row["photos"] ?? ""), true);
                                $photos = is_array($photos) ? $photos : [];
                                $currentStatus = (string)($row["status"] ?? "pending");
                                $isPublished = !empty($row["committed_at"]);
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= plantEscape($row["plantname"]) ?></strong><br>
                                        <?= plantEscape($row["contributor"]) ?>
                                    </td>
                                    <td>
                                        <?php foreach ($photos as $photo): ?>
                                            <a href="<?= plantEscape($photo) ?>" target="_blank" rel="noopener">
                                                <img
                                                    class="admin-submission-photo"
                                                    src="<?= plantEscape($photo) ?>"
                                                    alt="Submitted plant photo"
                                                >
                                            </a>
                                        <?php endforeach; ?>

                                        <?php if (!$photos): ?>
                                            No photos
                                        <?php endif; ?>
                                    </td>
                                    <td><?= nl2br(plantEscape($row["comments"] ?? "")) ?></td>
                                    <td><?= plantEscape($row["created_at"] ?? "") ?></td>
                                    <td>
                                        <?= plantEscape(ucfirst($currentStatus)) ?>
                                        <?php if ($isPublished): ?>
                                            <br><small>Published</small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="admin-row-actions">
                                        <a href="view_contribution_form.php?edit=<?= (int)$row["id"] ?>">Edit</a>

                                        <?php if (!$isPublished): ?>
                                            <form class="review-status-form" method="post">
                                                <input type="hidden" name="csrf_token" value="<?= plantEscape($csrf) ?>">
                                                <input type="hidden" name="action" value="review">
                                                <input type="hidden" name="id" value="<?= (int)$row["id"] ?>">

                                                <select
                                                    name="status"
                                                    required
                                                    aria-label="Change review status for <?= plantEscape($row["plantname"]) ?>"
                                                >
                                                    <option value="" selected disabled>Change status...</option>
                                                    <?php foreach (["pending" => "Pending", "approved" => "Approved", "rejected" => "Rejected"] as $statusValue => $statusLabel): ?>
                                                        <?php if ($statusValue !== $currentStatus): ?>
                                                            <option value="<?= $statusValue ?>"><?= $statusLabel ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>

                                                <button class="review-save-status" type="submit">Save status</button>
                                            </form>

                                            <?php if ($currentStatus === "approved"): ?>
                                                <form method="post">
                                                    <input type="hidden" name="csrf_token" value="<?= plantEscape($csrf) ?>">
                                                    <input type="hidden" name="action" value="commit">
                                                    <input type="hidden" name="id" value="<?= (int)$row["id"] ?>">
                                                    <button type="submit">Commit</button>
                                                </form>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <form method="post">
                                            <input type="hidden" name="csrf_token" value="<?= plantEscape($csrf) ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= (int)$row["id"] ?>">
                                            <button type="submit" class="admin-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No contribution submissions yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>

<?php
session_start();

if (($_SESSION["role"] ?? "") !== "admin" || empty($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

include "connection.php";
mysqli_report(MYSQLI_REPORT_OFF);

function enquiryEscape($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

function enquiryToken(): string
{
    if (empty($_SESSION["admin_csrf"])) {
        $_SESSION["admin_csrf"] = bin2hex(random_bytes(32));
    }

    return $_SESSION["admin_csrf"];
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        !isset($_POST["csrf_token"], $_SESSION["admin_csrf"]) ||
        !hash_equals($_SESSION["admin_csrf"], (string)$_POST["csrf_token"])
    ) {
        http_response_code(400);
        exit("Invalid form token.");
    }

    $id = (int)($_POST["id"] ?? 0);
    $action = (string)($_POST["action"] ?? "");

    if ($action === "delete") {
        $statement = mysqli_prepare(
            $conn,
            "DELETE FROM enquiry WHERE id = ?"
        );
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);
        $message = "Enquiry deleted.";
    } elseif ($action === "read") {
        $statement = mysqli_prepare(
            $conn,
            "UPDATE enquiry SET is_read = 1 WHERE id = ?"
        );
        mysqli_stmt_bind_param($statement, "i", $id);
        mysqli_stmt_execute($statement);
        $message = "Enquiry marked as read.";
    } elseif ($action === "save") {
        $first = trim((string)($_POST["firstname"] ?? ""));
        $last = trim((string)($_POST["lastname"] ?? ""));
        $email = trim((string)($_POST["email"] ?? ""));
        $phone = trim((string)($_POST["phone"] ?? ""));
        $family = trim((string)($_POST["family"] ?? ""));
        $genus = trim((string)($_POST["genus"] ?? ""));
        $species = trim((string)($_POST["species"] ?? ""));
        $comment = trim((string)($_POST["comment"] ?? ""));
        $reply = trim((string)($_POST["admin_reply"] ?? ""));

        if (
            $first === "" ||
            $last === "" ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            strlen($first) > 25 ||
            strlen($last) > 25 ||
            strlen($phone) > 11 ||
            strlen($comment) > 10000 ||
            strlen($reply) > 10000
        ) {
            $message = "Please check the enquiry details and try again.";
        } else {
            $statement = mysqli_prepare(
                $conn,
                "UPDATE enquiry
                 SET firstname = ?,
                     lastname = ?,
                     email = ?,
                     phone = ?,
                     family = NULLIF(?, ''),
                     genus = NULLIF(?, ''),
                     species = NULLIF(?, ''),
                     comment = ?,
                     admin_reply = ?,
                     replied_at = IF(? = '', NULL, NOW()),
                     is_read = 1
                 WHERE id = ?"
            );
            mysqli_stmt_bind_param(
                $statement,
                "ssssssssssi",
                $first,
                $last,
                $email,
                $phone,
                $family,
                $genus,
                $species,
                $comment,
                $reply,
                $reply,
                $id
            );

            if (mysqli_stmt_execute($statement)) {
                $message = "Enquiry updated and marked as read.";
            } else {
                $message = "The enquiry could not be updated. Check that it still exists.";
            }
        }
    }
}

$edit = null;

if (isset($_GET["edit"])) {
    $id = (int)$_GET["edit"];
    $statement = mysqli_prepare(
        $conn,
        "SELECT * FROM enquiry WHERE id = ?"
    );
    mysqli_stmt_bind_param($statement, "i", $id);
    mysqli_stmt_execute($statement);
    $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($statement)) ?: null;
}

$rows = mysqli_query(
    $conn,
    "SELECT * FROM enquiry ORDER BY created_at DESC, id DESC"
);
$csrf = enquiryToken();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Enquiries | Plantify Admin</title>
    <link rel="stylesheet" href="styles/style.css?v=admin-style-2">
</head>
<body class="admin-page">
    <?php include "admin_header.php"; ?>

    <main class="admin-shell">
        <h1>Enquiries</h1>
        <p>Read, update, reply to, or remove messages sent through the enquiry form.</p>

        <?php if ($message !== ""): ?>
            <p class="admin-message" role="status"><?= enquiryEscape($message) ?></p>
        <?php endif; ?>

        <?php if ($edit): ?>
            <section class="admin-card">
                <h2>Edit and reply</h2>
                <form class="admin-form" method="post">
                    <input type="hidden" name="csrf_token" value="<?= enquiryEscape($csrf) ?>">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" value="<?= (int)$edit["id"] ?>">

                    <label>
                        First name
                        <input name="firstname" maxlength="25" required value="<?= enquiryEscape($edit["firstname"]) ?>">
                    </label>
                    <label>
                        Last name
                        <input name="lastname" maxlength="25" required value="<?= enquiryEscape($edit["lastname"]) ?>">
                    </label>
                    <label>
                        Email
                        <input type="email" name="email" required value="<?= enquiryEscape($edit["email"]) ?>">
                    </label>
                    <label>
                        Phone
                        <input name="phone" maxlength="11" value="<?= enquiryEscape($edit["phone"]) ?>">
                    </label>
                    <label>
                        Family
                        <input name="family" value="<?= enquiryEscape($edit["family"] ?? "") ?>">
                    </label>
                    <label>
                        Genus
                        <input name="genus" value="<?= enquiryEscape($edit["genus"] ?? "") ?>">
                    </label>
                    <label>
                        Species
                        <input name="species" value="<?= enquiryEscape($edit["species"] ?? "") ?>">
                    </label>
                    <label class="admin-wide">
                        Enquiry
                        <textarea name="comment" rows="4"><?= enquiryEscape($edit["comment"] ?? "") ?></textarea>
                    </label>
                    <label class="admin-wide">
                        Reply
                        <textarea name="admin_reply" rows="4" placeholder="Write your reply here"><?= enquiryEscape($edit["admin_reply"] ?? "") ?></textarea>
                    </label>

                    <div class="admin-actions">
                        <button type="submit">Save and mark read</button>
                        <a href="view_enquiry.php">Cancel</a>
                    </div>
                </form>
            </section>
        <?php endif; ?>

        <section class="admin-card">
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Sender</th>
                            <th>Enquiry</th>
                            <th>Sent</th>
                            <th>Status / reply</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($rows && mysqli_num_rows($rows)): ?>
                            <?php while ($row = mysqli_fetch_assoc($rows)): ?>
                                <tr>
                                    <td>
                                        <strong><?= enquiryEscape($row["firstname"] . " " . $row["lastname"]) ?></strong><br>
                                        <?= enquiryEscape($row["email"]) ?><br>
                                        <?= enquiryEscape($row["phone"]) ?>
                                    </td>
                                    <td>
                                        <?= enquiryEscape($row["family"] ?? "") ?>
                                        <?= enquiryEscape($row["genus"] ?? "") ?>
                                        <?= enquiryEscape($row["species"] ?? "") ?><br>
                                        <?= nl2br(enquiryEscape($row["comment"] ?? "")) ?>
                                    </td>
                                    <td><?= enquiryEscape($row["created_at"] ?? "") ?></td>
                                    <td>
                                        <?= !empty($row["is_read"]) ? "Read" : "Unread" ?>
                                        <?php if (!empty($row["admin_reply"])): ?>
                                            <hr>
                                            <strong>Reply:</strong><br>
                                            <?= nl2br(enquiryEscape($row["admin_reply"])) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="admin-row-actions">
                                        <a href="view_enquiry.php?edit=<?= (int)$row["id"] ?>">Edit / reply</a>

                                        <form method="post">
                                            <input type="hidden" name="csrf_token" value="<?= enquiryEscape($csrf) ?>">
                                            <input type="hidden" name="id" value="<?= (int)$row["id"] ?>">
                                            <input type="hidden" name="action" value="read">
                                            <button type="submit">Mark read</button>
                                        </form>

                                        <form method="post">
                                            <input type="hidden" name="csrf_token" value="<?= enquiryEscape($csrf) ?>">
                                            <input type="hidden" name="id" value="<?= (int)$row["id"] ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="admin-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No enquiries have been submitted yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>

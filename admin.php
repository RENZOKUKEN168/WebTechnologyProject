<?php
include "session.inc";
include "createdatabase_table.php";
include "connection.php";
mysqli_report(MYSQLI_REPORT_OFF);

if (($_SESSION["role"] ?? "") !== "admin" || empty($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
if (!isset($_SESSION["auth_source"])) {
    $sourceCheck = mysqli_prepare($conn, "SELECT username FROM admin WHERE username = ? LIMIT 1");
    if ($sourceCheck) {
        $sessionUsername = (string)($_SESSION["username"] ?? "");
        mysqli_stmt_bind_param($sourceCheck, "s", $sessionUsername);
        mysqli_stmt_execute($sourceCheck);
        $_SESSION["auth_source"] = mysqli_fetch_assoc(mysqli_stmt_get_result($sourceCheck)) ? "admin_table" : "register";
    }
}
$isFullAdmin = ($_SESSION["auth_source"] ?? "") === "admin_table";

function adminEscape($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}
function adminRedirect(string $tab, string $message): void
{
    header("Location: admin.php?tab=" . urlencode($tab) . "&message=" . urlencode($message));
    exit;
}
function adminCsrfToken(): string
{
    if (empty($_SESSION["admin_csrf"])) {
        $_SESSION["admin_csrf"] = bin2hex(random_bytes(32));
    }
    return $_SESSION["admin_csrf"];
}
function adminCheckCsrf(): void
{
    if (!isset($_POST["csrf_token"], $_SESSION["admin_csrf"]) ||
        !hash_equals($_SESSION["admin_csrf"], $_POST["csrf_token"])) {
        http_response_code(400);
        exit("Invalid form token. Return to the <a href='admin.php'>admin panel</a> and try again.");
    }
}
function adminText(string $key, int $max, bool $required = true): string
{
    $value = trim((string)($_POST[$key] ?? ""));
    if (($required && $value === "") || strlen($value) > $max) {
        throw new RuntimeException("Please check the required fields and their maximum lengths.");
    }
    return $value;
}
function adminValidateUser(bool $creating): array
{
    $name = adminText("name", 51);
    $contact = adminText("contact_number", 10);
    $address = adminText("address", 100);
    $username = adminText("username", 50);
    $password = (string)($_POST["password"] ?? "");
    if (!preg_match("/^[A-Za-z ]+$/", $name) || !preg_match("/^[0-9]{1,10}$/", $contact) ||
        strtolower($username) === "admin") {
        throw new RuntimeException("Check the name, contact number, and reserved username.");
    }
    if (($creating && strlen($password) < 8) || ($password !== "" && (strlen($password) < 8 || strlen($password) > 255))) {
        throw new RuntimeException("A user password must contain at least 8 characters.");
    }
    return [$name, $contact, $address, $username, $password];
}
function adminPhotosFromRow(array $row): array
{
    $photos = json_decode((string)($row["photos"] ?? ""), true);
    return is_array($photos) ? array_values(array_filter($photos, "is_string")) : [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    adminCheckCsrf();
    $tab = ($_POST["tab"] ?? "submissions") === "users" ? "users" : "submissions";
    try {
        $action = $_POST["action"] ?? "";
        if (in_array($action, ["save_user", "delete_user"], true) && !$isFullAdmin) {
            throw new RuntimeException("You do not have permission to manage member accounts.");
        }
        if (in_array($action, ["save_submission", "set_status", "delete_submission"], true)) {
            throw new RuntimeException("Use the Plant submissions page to manage submissions.");
        } elseif ($action === "save_user") {
            $id = (int)($_POST["id"] ?? 0);
            [$name, $contact, $address, $username, $password] = adminValidateUser($id === 0);
            if ($id > 0) {
                if ($password !== "") {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = mysqli_prepare($conn, "UPDATE `user` SET name=?, contact_number=?, address=?, username=?, password=? WHERE id=?");
                    mysqli_stmt_bind_param($stmt, "sssssi", $name, $contact, $address, $username, $hash, $id);
                } else {
                    $stmt = mysqli_prepare($conn, "UPDATE `user` SET name=?, contact_number=?, address=?, username=? WHERE id=?");
                    mysqli_stmt_bind_param($stmt, "ssssi", $name, $contact, $address, $username, $id);
                }
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($conn, "INSERT INTO `user` (name, contact_number, address, username, password) VALUES (?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sssss", $name, $contact, $address, $username, $hash);
            }
            if (!mysqli_stmt_execute($stmt)) {
                if (mysqli_errno($conn) === 1062) throw new RuntimeException("That username is already in use.");
                throw new RuntimeException("The account could not be saved.");
            }
            adminRedirect("users", "Account saved.");
        } elseif ($action === "delete_user") {
            $id = (int)($_POST["id"] ?? 0);
            $stmt = mysqli_prepare($conn, "DELETE FROM `user` WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            if (!mysqli_stmt_execute($stmt) || mysqli_stmt_affected_rows($stmt) !== 1) throw new RuntimeException("That user account could not be deleted.");
            adminRedirect("users", "Account deleted.");
        } else {
            throw new RuntimeException("Choose a valid admin action.");
        }
    } catch (Throwable $exception) {
        adminRedirect($tab, $exception->getMessage());
    }
}

$tab = (($_GET["tab"] ?? "submissions") === "users") ? "users" : "submissions";
$message = (string)($_GET["message"] ?? "");
$csrf = adminCsrfToken();
$userEdit = null;
if (isset($_GET["edit_user"])) {
    $id = (int)$_GET["edit_user"];
    $stmt = mysqli_prepare($conn, "SELECT id, name, contact_number, address, username FROM `user` WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $userEdit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt)) ?: null;
}
$submissionCount = (int)(mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM contribute"))["total"] ?? 0);
$pendingCount = (int)(mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM contribute WHERE status='pending'"))["total"] ?? 0);
$userCount = (int)(mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM `user`"))["total"] ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plantify Admin Panel</title>
    <link rel="stylesheet" href="styles/style.css?v=admin-quick-view-1">
</head>
<body class="admin-page">
    <?php include "admin_header.php"; ?>
    <main class="admin-shell">
        <h1>Admin panel</h1>
        <p>Review plant contributions and manage registered accounts.</p>
        <?php if ($message !== ""): ?><p class="admin-message" role="status"><?= adminEscape($message) ?></p><?php endif; ?>
        <section class="admin-summary" aria-label="Plantify totals">
            <p><strong><?= $submissionCount ?></strong><span>Submissions</span></p>
            <p><strong><?= $pendingCount ?></strong><span>Waiting for review</span></p>
            <p><strong><?= $userCount ?></strong><span>Registered accounts</span></p>
        </section>
        <nav class="admin-tabs" aria-label="Admin sections">
            <a class="<?= $tab === "submissions" ? "is-active" : "" ?>" href="admin.php?tab=submissions">Plant submissions</a>
            <a class="<?= $tab === "users" ? "is-active" : "" ?>" href="admin.php?tab=users">User accounts</a>
        </nav>

        <?php if ($tab === "submissions"): ?>
            <section class="admin-card">
                <div class="admin-section-heading">
                    <h2>Recent plant submissions</h2>
                    <a class="admin-button" href="view_contribution_form.php">Open review page</a>
                </div>
                <?php
                $rows = mysqli_query($conn, "SELECT id, contributor, plantname, photos, comments, status, created_at FROM contribute ORDER BY created_at DESC, id DESC LIMIT 5");
                ?>
                <?php if ($rows && mysqli_num_rows($rows) > 0): ?>
                    <div class="admin-table-wrap"><table class="admin-table">
                        <thead><tr><th>Plant and contributor</th><th>Photos / notes</th><th>Date</th><th>Status</th></tr></thead>
                        <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rows)): ?>
                            <tr>
                                <td><strong><?= adminEscape($row["plantname"]) ?></strong><br><?= adminEscape($row["contributor"]) ?></td>
                                <td><?php foreach (adminPhotosFromRow($row) as $photo): ?><a href="<?= adminEscape($photo) ?>" target="_blank" rel="noopener">Photo</a> <?php endforeach; ?><?php if (!empty($row["comments"])): ?><br><?= nl2br(adminEscape($row["comments"])) ?><?php endif; ?><?php if (empty($row["photos"]) && empty($row["comments"])): ?>No photos or notes<?php endif; ?></td>
                                <td><?= adminEscape($row["created_at"]) ?></td>
                                <td><?= adminEscape(ucfirst($row["status"])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table></div>
                    <?php if ($submissionCount > 5): ?><p class="admin-quick-view-note">Showing the 5 latest submissions. Open the review page to see all submissions.</p><?php endif; ?>
                <?php else: ?><p>No plant submissions yet. New form submissions will appear here.</p><?php endif; ?>
            </section>
        <?php else: ?>
            <section class="admin-card">
                <div class="admin-section-heading"><h2>User accounts</h2><?php if ($isFullAdmin): ?><a class="admin-button" href="admin.php?tab=users&new_user=1">Add user</a><?php endif; ?></div>
                <?php if ($isFullAdmin && (isset($_GET["new_user"]) || $userEdit)): ?>
                    <?php $editingUser = (bool)$userEdit; ?>
                    <form class="admin-form" method="post" action="admin.php">
                        <input type="hidden" name="csrf_token" value="<?= adminEscape($csrf) ?>"><input type="hidden" name="tab" value="users"><input type="hidden" name="action" value="save_user"><input type="hidden" name="id" value="<?= (int)($userEdit["id"] ?? 0) ?>">
                        <label>Name<input name="name" maxlength="51" pattern="[A-Za-z ]+" required value="<?= adminEscape($userEdit["name"] ?? "") ?>"></label>
                        <label>Contact number<input name="contact_number" maxlength="10" pattern="[0-9]{1,10}" required value="<?= adminEscape($userEdit["contact_number"] ?? "") ?>"></label>
                        <label>Address<input name="address" maxlength="100" required value="<?= adminEscape($userEdit["address"] ?? "") ?>"></label>
                        <label>Username<input name="username" maxlength="50" required value="<?= adminEscape($userEdit["username"] ?? "") ?>"></label>
                        <label><?= $editingUser ? "New password (leave blank to keep it)" : "Password" ?><input type="password" name="password" maxlength="255" <?= $editingUser ? "" : "required" ?>></label>
                        <div class="admin-actions"><button type="submit"><?= $editingUser ? "Save account" : "Add account" ?></button><a href="admin.php?tab=users">Cancel</a></div>
                    </form>
                <?php endif; ?>
                <?php
                $users = mysqli_query($conn, "SELECT id, name, contact_number, address, username FROM `user` ORDER BY id DESC");
                ?>
                <?php if ($users && mysqli_num_rows($users) > 0): ?>
                    <div class="admin-table-wrap"><table class="admin-table">
                        <thead><tr><th>Name</th><th>Username</th><th>Contact</th><th>Address</th><th>Actions</th></tr></thead>
                        <tbody><?php while ($user = mysqli_fetch_assoc($users)): ?>
                            <tr><td><?= adminEscape($user["name"]) ?></td><td><?= adminEscape($user["username"]) ?></td><td><?= adminEscape($user["contact_number"]) ?></td><td><?= adminEscape($user["address"]) ?></td>
                                <td class="admin-row-actions"><?php if (!$isFullAdmin): ?><small>You do not have permission to manage member accounts.</small><?php else: ?><a href="admin.php?tab=users&edit_user=<?= (int)$user["id"] ?>">Edit</a> <a href="admin.php?tab=users&confirm_delete_user=<?= (int)$user["id"] ?>">Delete</a><?php endif; ?></td></tr>
                        <?php endwhile; ?></tbody>
                    </table></div>
                <?php else: ?><p>No registered user accounts yet.</p><?php endif; ?>
                <?php if (isset($_GET["confirm_delete_user"])): $deleteId = (int)$_GET["confirm_delete_user"]; ?>
                    <div class="admin-confirm"><p>Delete user account #<?= $deleteId ?>?</p>
                        <form method="post" action="admin.php"><input type="hidden" name="csrf_token" value="<?= adminEscape($csrf) ?>"><input type="hidden" name="tab" value="users"><input type="hidden" name="action" value="delete_user"><input type="hidden" name="id" value="<?= $deleteId ?>"><button class="admin-danger" type="submit">Confirm delete</button> <a href="admin.php?tab=users">Cancel</a></form>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>

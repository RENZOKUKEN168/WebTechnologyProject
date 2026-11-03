<?php
session_start();
function plantifySetupNotice(string $detail): never
{
    http_response_code(503);
    $message = htmlspecialchars($detail, ENT_QUOTES, "UTF-8");
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Plantify database required</title><link rel="stylesheet" href="styles/style.css?v=admin-style-2"></head><body class="admin-page"><main class="admin-shell"><h1>Plantify database setup required</h1><p class="admin-error">' . $message . '</p><ol><li>Start Apache and MySQL from XAMPP.</li><li>Open phpMyAdmin and create the Plantify database tables and admin account there.</li></ol><p>Then return to <a href="login.php">login</a>.</p></main></body></html>';
    exit;
}try {
    require "connection.php";
} catch (mysqli_sql_exception $exception) {
    $detail = (int)$exception->getCode() === 1049
        ? "The Plantify database has not been initialized yet."
        : "Plantify could not connect to MySQL. Check the XAMPP service.";
    plantifySetupNotice($detail);
}
mysqli_report(MYSQLI_REPORT_OFF);

if (($_SESSION["role"] ?? "") !== "admin" || empty($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

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
function adminImageUploads(): array
{
    if (!isset($_FILES["photos"]) || !is_array($_FILES["photos"]["name"])) {
        return [];
    }
    $allowed = ["image/jpeg" => "jpg", "image/png" => "png", "image/gif" => "gif", "image/webp" => "webp"];
    $destination = __DIR__ . "/uploads/contributions";
    if (!is_dir($destination) && !mkdir($destination, 0755, true)) {
        throw new RuntimeException("The photo upload folder could not be created.");
    }
    $saved = [];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    foreach ($_FILES["photos"]["name"] as $index => $name) {
        $error = $_FILES["photos"]["error"][$index] ?? UPLOAD_ERR_NO_FILE;
        if ($error === UPLOAD_ERR_NO_FILE) continue;
        if ($error !== UPLOAD_ERR_OK) throw new RuntimeException("A photo upload failed.");
        $tmp = $_FILES["photos"]["tmp_name"][$index] ?? "";
        $mime = $tmp !== "" ? $finfo->file($tmp) : false;
        if ((int)($_FILES["photos"]["size"][$index] ?? 0) > 5 * 1024 * 1024 || !isset($allowed[$mime])) {
            throw new RuntimeException("Use JPG, PNG, GIF, or WebP images up to 5 MB each.");
        }
        $filename = bin2hex(random_bytes(12)) . "." . $allowed[$mime];
        if (!move_uploaded_file($tmp, $destination . "/" . $filename)) throw new RuntimeException("A photo could not be saved.");
        $saved[] = "uploads/contributions/" . $filename;
    }
    return $saved;
}
function adminValidateUser(bool $creating): array
{
    $firstname = adminText("firstname", 25);
    $lastname = adminText("lastname", 25);
    $phone = adminText("phone", 10);
    $username = adminText("username", 50);
    $street = adminText("street_address", 40);
    $city = adminText("city", 20);
    $state = adminText("state", 30);
    $postcode = adminText("postcode", 5);
    $password = (string)($_POST["password"] ?? "");
    $states = ["Johor","Kedah","Kelantan","Melaka","Negeri Sembilan","Pahang","Penang","Perak","Perlis","Sabah","Sarawak","Selangor","Terengganu","Kuala Lumpur","Labuan","Putrajaya"];
    if (!preg_match("/^[A-Za-z ]+$/", $firstname) || !preg_match("/^[A-Za-z ]+$/", $lastname) ||
        !preg_match("/^[0-9]{1,10}$/", $phone) || !preg_match("/^[0-9]{5}$/", $postcode) ||
        !in_array($state, $states, true) || strtolower($username) === "admin") {
        throw new RuntimeException("Check the name, phone, postcode, state, and reserved username.");
    }
    if (($creating && strlen($password) < 8) || ($password !== "" && (strlen($password) < 8 || strlen($password) > 255))) {
        throw new RuntimeException("A user password must contain at least 8 characters.");
    }
    return [$firstname, $lastname, $phone, $username, $street, $city, $state, $postcode, $password];
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
        if ($action === "save_submission") {
            $id = (int)($_POST["id"] ?? 0);
            $contributor = adminText("contributor", 25);
            $plantname = adminText("plantname", 25);
            $comments = adminText("comments", 5000, false);
            $status = (string)($_POST["status"] ?? "pending");
            if (!preg_match("/^[A-Za-z ]+$/", $contributor) || !preg_match("/^[A-Za-z ]+$/", $plantname) ||
                !in_array($status, ["pending", "approved", "rejected"], true)) {
                throw new RuntimeException("Check the contributor, plant name, and review status.");
            }
            $uploaded = adminImageUploads();
            if ($id > 0) {
                $find = mysqli_prepare($conn, "SELECT photos FROM contributions WHERE id = ?");
                mysqli_stmt_bind_param($find, "i", $id);
                mysqli_stmt_execute($find);
                $existingRow = mysqli_fetch_assoc(mysqli_stmt_get_result($find));
                if (!$existingRow) throw new RuntimeException("That submission no longer exists.");
                $photos = array_merge(adminPhotosFromRow($existingRow), $uploaded);
                $photosJson = json_encode($photos, JSON_UNESCAPED_SLASHES);
                $stmt = mysqli_prepare($conn, "UPDATE contributions SET contributor = ?, plantname = ?, photos = ?, comments = ?, status = ? WHERE id = ?");
                mysqli_stmt_bind_param($stmt, "sssssi", $contributor, $plantname, $photosJson, $comments, $status, $id);
            } else {
                $photosJson = json_encode($uploaded, JSON_UNESCAPED_SLASHES);
                $stmt = mysqli_prepare($conn, "INSERT INTO contributions (contributor, plantname, photos, comments, status) VALUES (?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sssss", $contributor, $plantname, $photosJson, $comments, $status);
            }
            if (!mysqli_stmt_execute($stmt)) throw new RuntimeException("The submission could not be saved.");
            adminRedirect("submissions", "Submission saved.");
        } elseif ($action === "set_status") {
            $id = (int)($_POST["id"] ?? 0);
            $status = (string)($_POST["status"] ?? "");
            if (!in_array($status, ["pending", "approved", "rejected"], true)) throw new RuntimeException("Choose a valid review status.");
            $stmt = mysqli_prepare($conn, "UPDATE contributions SET status = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "si", $status, $id);
            if (!mysqli_stmt_execute($stmt)) throw new RuntimeException("The review status could not be changed.");
            adminRedirect("submissions", "Review status updated.");
        } elseif ($action === "delete_submission") {
            $id = (int)($_POST["id"] ?? 0);
            $find = mysqli_prepare($conn, "SELECT photos FROM contributions WHERE id = ?");
            mysqli_stmt_bind_param($find, "i", $id);
            mysqli_stmt_execute($find);
            $row = mysqli_fetch_assoc(mysqli_stmt_get_result($find));
            $delete = mysqli_prepare($conn, "DELETE FROM contributions WHERE id = ?");
            mysqli_stmt_bind_param($delete, "i", $id);
            if (!mysqli_stmt_execute($delete)) throw new RuntimeException("The submission could not be deleted.");
            if ($row) foreach (adminPhotosFromRow($row) as $photo) {
                $path = __DIR__ . "/" . ltrim($photo, "/");
                if (strpos(realpath(dirname($path)) ?: "", realpath(__DIR__ . "/uploads/contributions") ?: "missing") === 0 && is_file($path)) @unlink($path);
            }
            adminRedirect("submissions", "Submission deleted.");
        } elseif ($action === "save_user") {
            $id = (int)($_POST["id"] ?? 0);
            [$firstname, $lastname, $phone, $username, $street, $city, $state, $postcode, $password] = adminValidateUser($id === 0);
            if ($id > 0) {
                $find = mysqli_prepare($conn, "SELECT role FROM register WHERE id = ?");
                mysqli_stmt_bind_param($find, "i", $id);
                mysqli_stmt_execute($find);
                $target = mysqli_fetch_assoc(mysqli_stmt_get_result($find));
                if (!$target || $target["role"] !== "user") throw new RuntimeException("Only regular accounts can be changed here.");
                if ($password !== "") {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = mysqli_prepare($conn, "UPDATE register SET firstname=?, lastname=?, phone=?, username=?, street_address=?, city=?, state=?, postcode=?, password=? WHERE id=? AND role='user'");
                    mysqli_stmt_bind_param($stmt, "sssssssssi", $firstname, $lastname, $phone, $username, $street, $city, $state, $postcode, $hash, $id);
                } else {
                    $stmt = mysqli_prepare($conn, "UPDATE register SET firstname=?, lastname=?, phone=?, username=?, street_address=?, city=?, state=?, postcode=? WHERE id=? AND role='user'");
                    mysqli_stmt_bind_param($stmt, "ssssssssi", $firstname, $lastname, $phone, $username, $street, $city, $state, $postcode, $id);
                }
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($conn, "INSERT INTO register (firstname, lastname, phone, username, password, street_address, city, state, postcode, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'user')");
                mysqli_stmt_bind_param($stmt, "sssssssss", $firstname, $lastname, $phone, $username, $hash, $street, $city, $state, $postcode);
            }
            if (!mysqli_stmt_execute($stmt)) {
                if (mysqli_errno($conn) === 1062) throw new RuntimeException("That username is already in use.");
                throw new RuntimeException("The account could not be saved.");
            }
            adminRedirect("users", "Account saved.");
        } elseif ($action === "delete_user") {
            $id = (int)($_POST["id"] ?? 0);
            $stmt = mysqli_prepare($conn, "DELETE FROM register WHERE id = ? AND role = 'user'");
            mysqli_stmt_bind_param($stmt, "i", $id);
            if (!mysqli_stmt_execute($stmt) || mysqli_stmt_affected_rows($stmt) !== 1) throw new RuntimeException("That regular account could not be deleted.");
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
$submissionEdit = null;
$userEdit = null;
if (isset($_GET["edit_submission"])) {
    $id = (int)$_GET["edit_submission"];
    $stmt = mysqli_prepare($conn, "SELECT * FROM contributions WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $submissionEdit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt)) ?: null;
}
if (isset($_GET["edit_user"])) {
    $id = (int)$_GET["edit_user"];
    $stmt = mysqli_prepare($conn, "SELECT id, firstname, lastname, phone, username, street_address, city, state, postcode FROM register WHERE id = ? AND role = 'user'");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $userEdit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt)) ?: null;
}
$states = ["Johor","Kedah","Kelantan","Melaka","Negeri Sembilan","Pahang","Penang","Perak","Perlis","Sabah","Sarawak","Selangor","Terengganu","Kuala Lumpur","Labuan","Putrajaya"];
$submissionCount = (int)(mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM contributions"))["total"] ?? 0);
$pendingCount = (int)(mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM contributions WHERE status='pending'"))["total"] ?? 0);
$userCount = (int)(mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM register WHERE role='user'"))["total"] ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plantify Admin Panel</title>
    <link rel="stylesheet" href="styles/style.css?v=admin-style-2">
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
            <p><strong><?= $userCount ?></strong><span>Regular accounts</span></p>
        </section>
        <nav class="admin-tabs" aria-label="Admin sections">
            <a class="<?= $tab === "submissions" ? "is-active" : "" ?>" href="admin.php?tab=submissions">Plant submissions</a>
            <a class="<?= $tab === "users" ? "is-active" : "" ?>" href="admin.php?tab=users">User accounts</a>
        </nav>

        <?php if ($tab === "submissions"): ?>
            <section class="admin-card">
                <div class="admin-section-heading"><h2>Plant submissions</h2><a class="admin-button" href="admin.php?tab=submissions&new_submission=1">Add submission</a></div>
                <?php if (isset($_GET["new_submission"]) || $submissionEdit): ?>
                    <?php $editing = (bool)$submissionEdit; $currentPhotos = $submissionEdit ? adminPhotosFromRow($submissionEdit) : []; ?>
                    <form class="admin-form" method="post" enctype="multipart/form-data" action="admin.php">
                        <input type="hidden" name="csrf_token" value="<?= adminEscape($csrf) ?>">
                        <input type="hidden" name="tab" value="submissions">
                        <input type="hidden" name="action" value="save_submission">
                        <input type="hidden" name="id" value="<?= (int)($submissionEdit["id"] ?? 0) ?>">
                        <label>Contributor name<input name="contributor" maxlength="25" pattern="[A-Za-z ]+" required value="<?= adminEscape($submissionEdit["contributor"] ?? "") ?>"></label>
                        <label>Plant name<input name="plantname" maxlength="25" pattern="[A-Za-z ]+" required value="<?= adminEscape($submissionEdit["plantname"] ?? "") ?>"></label>
                        <label>Comments<textarea name="comments" rows="4" maxlength="5000"><?= adminEscape($submissionEdit["comments"] ?? "") ?></textarea></label>
                        <label>Photos<input type="file" name="photos[]" accept="image/jpeg,image/png,image/gif,image/webp" multiple><small>New photos are added to any existing photos, up to 5 MB each.</small></label>
                        <?php if ($currentPhotos): ?><p>Current photos: <?php foreach ($currentPhotos as $photo): ?><a href="<?= adminEscape($photo) ?>"><?= adminEscape(basename($photo)) ?></a> <?php endforeach; ?></p><?php endif; ?>
                        <label>Review status<select name="status"><?php foreach (["pending","approved","rejected"] as $status): ?><option value="<?= $status ?>" <?= (($submissionEdit["status"] ?? "pending") === $status) ? "selected" : "" ?>><?= ucfirst($status) ?></option><?php endforeach; ?></select></label>
                        <div class="admin-actions"><button type="submit"><?= $editing ? "Save changes" : "Add submission" ?></button><a href="admin.php?tab=submissions">Cancel</a></div>
                    </form>
                <?php endif; ?>
                <?php
                $rows = mysqli_query($conn, "SELECT id, contributor, plantname, photos, comments, status, created_at FROM contributions ORDER BY created_at DESC, id DESC");
                ?>
                <?php if ($rows && mysqli_num_rows($rows) > 0): ?>
                    <div class="admin-table-wrap"><table class="admin-table">
                        <thead><tr><th>Plant and contributor</th><th>Photos / notes</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
                        <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rows)): ?>
                            <tr>
                                <td><strong><?= adminEscape($row["plantname"]) ?></strong><br><?= adminEscape($row["contributor"]) ?></td>
                                <td><?php foreach (adminPhotosFromRow($row) as $photo): ?><a href="<?= adminEscape($photo) ?>">Photo</a> <?php endforeach; ?><br><?= nl2br(adminEscape($row["comments"])) ?></td>
                                <td><?= adminEscape($row["created_at"]) ?></td>
                                <td><?= adminEscape(ucfirst($row["status"])) ?></td>
                                <td class="admin-row-actions">
                                    <a href="admin.php?tab=submissions&edit_submission=<?= (int)$row["id"] ?>">Edit</a>
                                    <form method="post" action="admin.php">
                                        <input type="hidden" name="csrf_token" value="<?= adminEscape($csrf) ?>"><input type="hidden" name="tab" value="submissions"><input type="hidden" name="action" value="set_status"><input type="hidden" name="id" value="<?= (int)$row["id"] ?>">
                                        <select name="status" aria-label="Set review status for <?= adminEscape($row["plantname"]) ?>"><?php foreach (["pending" => "Pending", "approved" => "Approve", "rejected" => "Reject"] as $statusValue => $statusLabel): ?><option value="<?= $statusValue ?>" <?= $row["status"] === $statusValue ? "selected" : "" ?>><?= $statusLabel ?></option><?php endforeach; ?></select><button type="submit">Update</button>
                                    </form>
                                    <a href="admin.php?tab=submissions&confirm_delete_submission=<?= (int)$row["id"] ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table></div>
                <?php else: ?><p>No plant submissions yet. New form submissions will appear here.</p><?php endif; ?>
                <?php if (isset($_GET["confirm_delete_submission"])): $deleteId = (int)$_GET["confirm_delete_submission"]; ?>
                    <div class="admin-confirm"><p>Delete submission #<?= $deleteId ?>? This also removes its uploaded photos.</p>
                        <form method="post" action="admin.php"><input type="hidden" name="csrf_token" value="<?= adminEscape($csrf) ?>"><input type="hidden" name="tab" value="submissions"><input type="hidden" name="action" value="delete_submission"><input type="hidden" name="id" value="<?= $deleteId ?>"><button class="admin-danger" type="submit">Confirm delete</button> <a href="admin.php?tab=submissions">Cancel</a></form>
                    </div>
                <?php endif; ?>
            </section>
        <?php else: ?>
            <section class="admin-card">
                <div class="admin-section-heading"><h2>User accounts</h2><a class="admin-button" href="admin.php?tab=users&new_user=1">Add user</a></div>
                <?php if (isset($_GET["new_user"]) || $userEdit): ?>
                    <?php $editingUser = (bool)$userEdit; ?>
                    <form class="admin-form" method="post" action="admin.php">
                        <input type="hidden" name="csrf_token" value="<?= adminEscape($csrf) ?>"><input type="hidden" name="tab" value="users"><input type="hidden" name="action" value="save_user"><input type="hidden" name="id" value="<?= (int)($userEdit["id"] ?? 0) ?>">
                        <label>First name<input name="firstname" maxlength="25" pattern="[A-Za-z ]+" required value="<?= adminEscape($userEdit["firstname"] ?? "") ?>"></label>
                        <label>Last name<input name="lastname" maxlength="25" pattern="[A-Za-z ]+" required value="<?= adminEscape($userEdit["lastname"] ?? "") ?>"></label>
                        <label>Phone<input name="phone" maxlength="10" pattern="[0-9]{1,10}" required value="<?= adminEscape($userEdit["phone"] ?? "") ?>"></label>
                        <label>Username<input name="username" maxlength="50" required value="<?= adminEscape($userEdit["username"] ?? "") ?>"></label>
                        <label><?= $editingUser ? "New password (leave blank to keep it)" : "Password" ?><input type="password" name="password" maxlength="255" <?= $editingUser ? "" : "required" ?>></label>
                        <label>Street address<input name="street_address" maxlength="40" required value="<?= adminEscape($userEdit["street_address"] ?? "") ?>"></label>
                        <label>City<input name="city" maxlength="20" required value="<?= adminEscape($userEdit["city"] ?? "") ?>"></label>
                        <label>State<select name="state" required><option value="">Select state</option><?php foreach ($states as $state): ?><option value="<?= adminEscape($state) ?>" <?= (($userEdit["state"] ?? "") === $state) ? "selected" : "" ?>><?= adminEscape($state) ?></option><?php endforeach; ?></select></label>
                        <label>Postcode<input name="postcode" maxlength="5" pattern="[0-9]{5}" required value="<?= adminEscape($userEdit["postcode"] ?? "") ?>"></label>
                        <div class="admin-actions"><button type="submit"><?= $editingUser ? "Save account" : "Add account" ?></button><a href="admin.php?tab=users">Cancel</a></div>
                    </form>
                <?php endif; ?>
                <?php
                $users = mysqli_query($conn, "SELECT id, firstname, lastname, phone, username, city, state, created_at FROM register WHERE role = 'user' ORDER BY created_at DESC, id DESC");
                ?>
                <?php if ($users && mysqli_num_rows($users) > 0): ?>
                    <div class="admin-table-wrap"><table class="admin-table">
                        <thead><tr><th>Name</th><th>Username</th><th>Phone</th><th>Location</th><th>Joined</th><th>Actions</th></tr></thead>
                        <tbody><?php while ($user = mysqli_fetch_assoc($users)): ?>
                            <tr><td><?= adminEscape($user["firstname"] . " " . $user["lastname"]) ?></td><td><?= adminEscape($user["username"]) ?></td><td><?= adminEscape($user["phone"]) ?></td><td><?= adminEscape($user["city"] . ", " . $user["state"]) ?></td><td><?= adminEscape($user["created_at"]) ?></td>
                                <td class="admin-row-actions"><a href="admin.php?tab=users&edit_user=<?= (int)$user["id"] ?>">Edit</a> <a href="admin.php?tab=users&confirm_delete_user=<?= (int)$user["id"] ?>">Delete</a></td></tr>
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

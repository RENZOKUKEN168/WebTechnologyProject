<?php
session_start();
if (($_SESSION["role"] ?? "") !== "admin" || empty($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require "connection.php";
mysqli_report(MYSQLI_REPORT_OFF);
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

function memberEscape($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

if (empty($_SESSION["admin_csrf"])) {
    $_SESSION["admin_csrf"] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION["admin_csrf"];
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["csrf_token"]) || !hash_equals($csrf, (string)$_POST["csrf_token"])) {
        http_response_code(400);
        exit("Invalid form token.");
    }

    $action = (string)($_POST["action"] ?? "");
    if (in_array($action, ["bulk_role", "delete"], true) && !$isFullAdmin) {
        $message = "You do not have permission to change member roles or remove members.";
    } elseif ($action === "bulk_role") {
        $role = (string)($_POST["role"] ?? "");
        $selectedIds = $_POST["member_ids"] ?? [];
        $selectedIds = is_array($selectedIds)
            ? array_values(array_unique(array_filter(array_map("intval", $selectedIds), fn($id) => $id > 0)))
            : [];

        if (!$selectedIds || !in_array($role, ["user", "admin"], true)) {
            $message = "Select at least one member and a permission.";
        } else {
            mysqli_begin_transaction($conn);
            $changed = 0;
            $failed = false;
            $lookup = mysqli_prepare($conn, "SELECT username, role FROM register WHERE id = ? LIMIT 1");
            $update = mysqli_prepare($conn, "UPDATE register SET role = ? WHERE id = ? AND username <> 'admin'");

            if (!$lookup || !$update) {
                $failed = true;
            } else {
                foreach ($selectedIds as $memberId) {
                    mysqli_stmt_bind_param($lookup, "i", $memberId);
                    if (!mysqli_stmt_execute($lookup)) {
                        $failed = true;
                        break;
                    }
                    $member = mysqli_fetch_assoc(mysqli_stmt_get_result($lookup));
                    if (!$member || $member["username"] === "admin") {
                        continue;
                    }

                    mysqli_stmt_bind_param($update, "si", $role, $memberId);
                    if (!mysqli_stmt_execute($update)) {
                        $failed = true;
                        break;
                    }
                    $changed += mysqli_stmt_affected_rows($update) > 0 ? 1 : 0;
                }
            }

            if ($failed) {
                mysqli_rollback($conn);
                $message = "Could not save the role changes. Please try again.";
            } else {
                mysqli_commit($conn);
                $message = $changed === 1 ? "Member permission updated." : $changed . " member permissions updated.";
            }
        }
    } elseif ($action === "delete") {
        $id = (int)($_POST["id"] ?? 0);
        $check = mysqli_prepare($conn, "SELECT username, role FROM register WHERE id = ? LIMIT 1");
        if ($check) {
            mysqli_stmt_bind_param($check, "i", $id);
            mysqli_stmt_execute($check);
            $target = mysqli_fetch_assoc(mysqli_stmt_get_result($check));
            if (!$target || $target["username"] === "admin" || $id === (int)$_SESSION["user_id"]) {
                $message = "This account cannot be removed.";
            } else {
                $delete = mysqli_prepare($conn, "DELETE FROM register WHERE id = ?");
                mysqli_stmt_bind_param($delete, "i", $id);
                $message = mysqli_stmt_execute($delete) ? "Member removed." : "Could not remove member.";
            }
        } else {
            $message = "Could not remove member.";
        }
    }
}

$members = mysqli_query($conn, "SELECT id, firstname, lastname, phone, username, city, state, role, created_at FROM register ORDER BY role DESC, created_at DESC, id DESC");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Members | Plantify Admin</title>
    <link rel="stylesheet" href="styles/style.css?v=admin-members-bulk-1">
</head>
<body class="admin-page">
<?php include "admin_header.php"; ?>
<main class="admin-shell">
    <h1>Members</h1>
    <p>Select one or more members, choose a permission, then save once to apply it to everyone selected.</p>
    <?php if ($message !== ""): ?><p class="admin-message" role="status"><?= memberEscape($message) ?></p><?php endif; ?>

    <section class="admin-card member-management">
        <?php if ($isFullAdmin): ?>
        <form id="bulk-role-form" class="member-bulk-controls" method="post">
            <input type="hidden" name="csrf_token" value="<?= memberEscape($csrf) ?>">
            <input type="hidden" name="action" value="bulk_role">
            <label for="bulk-role">Permission for selected members</label>
            <select id="bulk-role" class="bulk-role-select" name="role" required>
                <option value="" selected disabled>Choose a permission</option>
                <option value="user">Member</option>
                <option value="admin">Admin</option>
            </select>
            <button class="bulk-role-submit" type="submit">Save role</button>
            <span class="bulk-role-help">Choose members below. The save button appears after you select members and a permission.</span>
        </form>
        <?php else: ?>
            <p class="admin-error">You do not have permission to change member roles or remove members.</p>
        <?php endif; ?>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>Select</th><th>Member</th><th>Contact</th><th>Location</th><th>Permission</th><th>Joined</th><th>Actions</th></tr></thead>
                <tbody>
                <?php if ($members && mysqli_num_rows($members)): ?>
                    <?php while ($member = mysqli_fetch_assoc($members)): ?>
                        <tr>
                            <td>
                                <?php if ($isFullAdmin && $member["username"] !== "admin"): ?>
                                    <input class="member-select" form="bulk-role-form" type="checkbox" name="member_ids[]" value="<?= (int)$member["id"] ?>" aria-label="Select <?= memberEscape($member["username"]) ?>">
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td><?= memberEscape($member["firstname"] . " " . $member["lastname"]) ?><br><strong><?= memberEscape($member["username"]) ?></strong></td>
                            <td><?= memberEscape($member["phone"]) ?></td>
                            <td><?= memberEscape($member["city"] . ", " . $member["state"]) ?></td>
                            <td><?= memberEscape($member["username"] === "admin" ? "Admin" : ucfirst($member["role"] ?? "user")) ?></td>
                            <td><?= memberEscape($member["created_at"] ?? "") ?></td>
                            <td class="admin-row-actions">
                                <?php if ($isFullAdmin && $member["username"] !== "admin" && (int)$member["id"] !== (int)$_SESSION["user_id"]): ?>
                                    <form method="post">
                                        <input type="hidden" name="csrf_token" value="<?= memberEscape($csrf) ?>">
                                        <input type="hidden" name="id" value="<?= (int)$member["id"] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button class="admin-danger" type="submit">Remove member</button>
                                    </form>
                                <?php else: ?>
                                    <small>You do not have permission to change or remove this account.</small>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7">No members found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
</body>
</html>

<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (($_SESSION["role"] ?? "") !== "admin" || empty($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
$currentAdminPage = basename($_SERVER["PHP_SELF"] ?? "admin.php");
?>
<header class="admin-header admin-site-header">
    <a class="admin-brand" href="admin.php" aria-label="Plantify admin home"><img src="images/plantify_logo.png" alt="Plantify"></a>
    <nav class="admin-nav" aria-label="Admin navigation">
        <a href="admin.php" <?= $currentAdminPage === "admin.php" ? 'aria-current="page"' : "" ?>>Dashboard</a>
        <a href="view_enquiry.php" <?= $currentAdminPage === "view_enquiry.php" ? 'aria-current="page"' : "" ?>>Enquiries</a>
        <a href="view_contribution_form.php" <?= $currentAdminPage === "view_contribution_form.php" ? 'aria-current="page"' : "" ?>>Plant submissions</a>
        <a href="view_member.php" <?= $currentAdminPage === "view_member.php" ? 'aria-current="page"' : "" ?>>Members</a>
    </nav>
    <div class="admin-account"><span>Signed in as <?= htmlspecialchars((string)($_SESSION["username"] ?? "admin"), ENT_QUOTES, "UTF-8") ?></span><a href="logout.php">Log out</a></div>
</header>

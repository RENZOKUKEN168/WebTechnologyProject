<?php
// Starts the session and logs the user out after 30 minutes without opening a page.
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (!empty($_SESSION["user_id"])) {
    if (isset($_SESSION["last_activity"]) && time() - $_SESSION["last_activity"] > 1800) {
        $_SESSION = ["timed_out" => true];
        session_regenerate_id(true);
    } else {
        $_SESSION["last_activity"] = time();
    }
}
?>

<?php
    // The account button depends on who is logged in.
    $accountHref = "login.php";
    $accountLabel = "Login";
    $accountImage = "images/user/unknown.png";
    $logoutLink = "";
    if (($_SESSION["role"] ?? "") === "admin") {
        $accountHref = "admin.php";
        $accountLabel = "Back to admin panel";
    } elseif (!empty($_SESSION["user_id"])) {
        $accountHref = "index.php";
        $accountLabel = "Signed in as " . htmlspecialchars((string)($_SESSION["username"] ?? ""), ENT_QUOTES, "UTF-8");
        $accountImage = htmlspecialchars((string)($_SESSION["profile_picture"] ?? $accountImage), ENT_QUOTES, "UTF-8");
    }
    if (!empty($_SESSION["user_id"])) {
        $logoutLink = "<a class='header-logout' href='logout.php'>Log out</a>";
    }

    echo "
    
    <header id=header>
        <div class='brand'>
            <a href='index.php'>
                <img src='images/plantify_logo.png' alt='Plantify'>
            </a>
        </div>

        <nav aria-label='Main navigation'>
            <div class='nav-explore'>
                <a href='explore1.php'>Explore</a>
                <ul class='explore-dropdown' aria-label='Explore categories'>
                    <li><a href='families.php#families-list'>Families</a></li>
                    <li><a href='genera.php#genera-list'>Genera</a></li>
                    <li><a href='species.php#species-list'>Species</a></li>
                </ul>
            </div>
            <a href='identify.php'>Identifier</a>
            <div class='nav-explore'>
                <a href='contribute.php'>Contribution</a>
                <ul class='explore-dropdown' aria-label='Explore categories'>
                    <li><a href='contribute_form.php#contribute-form'>Contribute Form</a></li>
                </ul>
            </div>
            <a href='Aboutus.php'>About Us</a>
            <a href='enquiry.php'>Enquiry</a>

        </nav>

        <div class='header-right'>
            <input type='search' aria-label='Search Plantify' placeholder='Search'>
            <a class='header-account' href='$accountHref' aria-label='$accountLabel' title='$accountLabel'>
                <img src='$accountImage' alt='' width='44' height='44'>
            </a>
            $logoutLink
        </div>
    </header>";
?>




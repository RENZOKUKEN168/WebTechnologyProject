<?php
    session_start();
    ?>
<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="enhancement">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Enhancements used">
    <meta name="author" content="Tiaw Le-San, Chin Jii Ann">
<title>Enhancement</title>

<link rel="stylesheet" href="styles/style.css">
</head>
<body class="enhancement-page">
    <?php
        include("header.php");
        ?>

    <section class="enhancement-format" id="#">
        <h1>Enhancements</h1>
        <p>Below are the enhancements applied.</p>
    </section>

    <section class="enhancement-format">
        <h2>Dropdown bar</h2>
        <ul>
            <li>Users hover over the designated words using their mouse to "Dropdown" the list of text, which will bring the user to the other pages once clicked because it is linked to other php pages. </li>
            <li>Applied to:
                <div class="ack-button">
                    <a href="index.php#header">Index header</a>
                    <a href="explore1.php#header">Explore header</a>
                    <a href="families.php#header">Families header</a>
                    <a href="genera.php#header">Genera header</a>
                    <a href="species.php#header">Species header</a>
                    <a href="contribute.php#header">Contribute header</a>
                    <a href="contribute_form.php#header">Contribute form header</a>
                    <a href="Aboutus.php#header">About Us header</a>
                    <a href="enquiry.php#header">Enquiry header</a>
                    <a href="login.php#header">Login header</a>
                    <a href="identify.php#header">Identify header</a>
                    <a href="register.php#header">Register header</a>
                    <a href="acknowledge.php#header">Acknowledgement header</a>
                    <a href="enhancement.php#header">Enhancement header</a>
                    <a href="user1.php#header">User 1 header</a>
                    <a href="user2.php#header">User 2 header</a>
                    <a href="user3.php#header">User 3 header</a>
                    <a href="user4.php#header">User 4 header</a>
                </div>
            </li>
            <li>Reference(s): <a href="https://www.w3schools.com/css/css_dropdowns.asp">CSS Dropdowns</a></li>
        </ul>
    </section>    
    
    <section class="enhancement-format">
        <h2>Text/Image/Table/Button Hover Effect</h2>
        <ul>
            <li>Users can see interactive hover effects on text links and buttons. These effects provide visual feedback, such as changing colours, showing an underline, highlighting the background, or lifting the element slightly when users hover over them with their mouse or navigate to them with the keyboard.</li>
            <li>Applied to:
                <h3>Main navigation links (animated underline, colour fade)</h3>
                <div class="enh-button">
                    <a href="index.php#header">Index</a>
                    <a href="explore1.php#header">Explore</a>
                    <a href="families.php#header">Families</a>
                    <a href="genera.php#header">Genera</a>
                    <a href="species.php#header">Species</a>
                    <a href="contribute.php#header">Contribute</a>
                    <a href="contribute_form.php#header">Contribute form</a>
                    <a href="Aboutus.php#header">About Us</a>
                    <a href="enquiry.php#header">Enquiry</a>
                    <a href="login.php#header">Login</a>
                    <a href="identify.php#header">Identify</a>
                    <a href="register.php#header">Register</a>
                    <a href="acknowledge.php#header">Acknowledgement</a>
                    <a href="enhancement.php#header">Enhancement</a>
                    <a href="user1.php#header">User 1</a>
                    <a href="user2.php#header">User 2</a>
                    <a href="user3.php#header">User 3</a>
                    <a href="user4.php#header">User 4</a>
                </div>

                <h3>Footer links (underline)</h3>
                <div class="enh-button">
                    <a href="index.php#footer">Index</a>
                    <a href="explore1.php#footer">Explore</a>
                    <a href="families.php#footer">Families</a>
                    <a href="genera.php#footer">Genera</a>
                    <a href="species.php#footer">Species</a>
                    <a href="contribute.php#footer">Contribute</a>
                    <a href="contribute_form.php#footer">Contribute form</a>
                    <a href="Aboutus.php#footer">About Us</a>
                    <a href="enquiry.php#footer">Enquiry</a>
                    <a href="login.php#footer">Login</a>
                    <a href="identify.php#footer">Identify</a>
                    <a href="register.php#footer">Register</a>
                    <a href="acknowledge.php#footer">Acknowledgement</a>
                    <a href="enhancement.php#footer">Enhancement</a>
                    <a href="user1.php#footer">User 1</a>
                    <a href="user2.php#footer">User 2</a>
                    <a href="user3.php#footer">User 3</a>
                    <a href="user4.php#footer">User 4</a>
                </div>

                <h3>Side rail links (text turns green)</h3>
                <div class="enh-button">
                    <a href="families.php#rail">Explore</a>
                    <a href="families.php#rail">Families</a>
                    <a href="genera.php#rail">Genera</a>
                    <a href="species.php#rail">Species</a>
                    <a href="user1.php#rail">User 1</a>
                    <a href="user2.php#rail">User 2</a>
                    <a href="user3.php#rail">User 3</a>
                    <a href="user4.php#rail">User 4</a>
                </div>

                <h3>Jump links (green background, white text, lifts up)</h3>
                <div class="enh-button">
                    <a href="families.php#jump-links">Families</a>
                    <a href="genera.php#jump-links">Genera</a>
                    <a href="species.php#jump-links">Species</a>
                </div>

                <h3>"Explore on iNaturalist" links (underline)</h3>
                <div class="enh-button">
                    <a href="families.php#dipterocarpaceae-family">Families</a>
                    <a href="genera.php#dipterocarpaceae-genera">Genera</a>
                    <a href="species.php#vatica-species">Species</a>
                    <a href="explore1.php#taxonomy-map">Explore</a>
                </div>

                <h3>Explore page links and buttons</h3>
                <div class="enh-button">
                    <a href="explore1.php#categories">Category cards</a>
                    <a href="explore1.php#tools">Tool links</a>
                    <a href="explore1.php#taxonomy-map">Genus and species links</a>
                    <a href="explore1.php#back-to-overview">Back to overview</a>
                </div>

                <h3>Buttons</h3>
                <div class="enh-button">
                    <a href="index.php#home-explore">Index Explore button</a>
                    <a href="index.php#register">Join the Community</a>
                    <a href="contribute.php#contribute-btn">Contribute a Plant</a>
                    <a href="identify.php">Get Started button</a>
                    <a href="user1.php#email-button">Email Me (User 1)</a>
                    <a href="user2.php#email-button">Email Me (User 2)</a>
                    <a href="user3.php#email-button">Email Me (User 3)</a>
                    <a href="user4.php#email-button">Email Me (User 4)</a>
                </div>

                <h3>Profile table rows (highlight, text shifts right)</h3>
                <div class="enh-button">
                    <a href="user1.php#profile-table">User 1</a>
                    <a href="user2.php#profile-table">User 2</a>
                    <a href="user3.php#profile-table">User 3</a>
                    <a href="user4.php#profile-table">User 4</a>
                </div>

                <h3>Link chips (darker background)</h3>
                <div class="enh-button">
                    <a href="acknowledge.php#ack-links">Acknowledgement</a>
                    <a href="enhancement.php#header">Enhancement</a>
                </div>

                <h3>Form buttons (colour change, glow)</h3>
                <div class="enh-button">
                    <a href="login.php#form">Login</a>
                    <a href="contribute_form.php#form">Contribute form</a>
                    <a href="enquiry.php#form">Enquiry</a>
                    <a href="register.php#form">Register</a>
                </div>
            </li>
            <li>Reference(s):
                <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/:hover">MDN Web Docs &ndash; &colon;hover&comma;</a>
                <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/transition">MDN Web Docs &ndash; CSS Transitions</a>
            </li>
        </ul>
    </section>

    <section class="enhancement-format">
        <h2>Google Map</h2>
        <ul>
            <li>Users can see a Google Map at the footer, where the Plantify home base is located.</li>
            <li>Applied to: 
                <div class="ack-button">
                <a href="index.php#footer">Index footer</a>
                <a href="Aboutus.php#footer">About Us footer</a>
                <a href="acknowledge.php#footer">Acknowledgement footer</a>
                <a href="contribute_form.php#footer">Contribute form footer</a>
                <a href="contribute.php#footer">Contribute footer</a>
                <a href="enhancement.php#footer">Enhancement footer</a>
                <a href="enquiry.php#footer">Enquiry footer</a>
                <a href="explore1.php#footer">Explore footer</a>
                <a href="families.php#footer">Families footer</a>
                <a href="genera.php#footer">Genera footer</a>
                <a href="login.php#footer">Login footer</a>
                <a href="identify.php#footer">Identify footer</a>
                <a href="register.php#footer">Register footer</a>
                <a href="species.php#footer">Species footer</a>
                <a href="user1.php#footer">User 1 footer</a>
                <a href="user2.php#footer">User 2 footer</a>
                <a href="user3.php#footer">User 3 footer</a>
                <a href="user4.php#footer">User 4 footer</a>
                </div>            
            </li>
            <li>Reference(s): 
                <a href="https://www.educative.io/answers/how-to-embed-a-google-map-into-php">Embed a Google Map into php</a>
            </li>
        </ul>
    </section>

    <section class="enhancement-format">
        <h2>Background Video</h2>
        <ul>
            <li>Users can see a video playing in the background without having to click any button to play or pause the video.</li>
            <li>Applied to:
                <div class="ack-button">
                    <a href="index.php#bg-video">Index home video</a>
                </div>
            </li>
            <li>Reference(s): <a href="https://developer.mozilla.org/en-US/docs/Web/php/Reference/Elements/video">php Video Embed Element</a> </li>
        </ul>
    </section>

    <section class="enhancement-format">
        <h2>Back to top button</h2>
        <ul>
            <li>Users can click a button to bring them back to the top of the page.</li>
            <li>Applied to:
                <div class="ack-button">
                    <a href="explore1.php#back-to-overview">Explore &ndash; Back to Overview</a>
                </div>
            </li>
            <li>Reference(s): <a href="https://moderncss.dev/pure-css-smooth-scroll-back-to-top/">Create a Scroll Back to Top Button</a></li>
        </ul>
    </section>

    <section class="enhancement-format">
        <h2>Reveal on hover header</h2>
        <ul>
            <li>Users can hover over the top part of the screen, whereby the header will appear when doing so.</li>
            <li>Applied to:
                <div class="ack-button">
                    <a href="index.php#header">Index</a>
                    <a href="explore1.php#header">Explore</a>
                    <a href="families.php#header">Families</a>
                    <a href="genera.php#header">Genera</a>
                    <a href="species.php#header">Species</a>
                    <a href="contribute.php#header">Contribute</a>
                    <a href="contribute_form.php#header">Contribute form</a>
                    <a href="Aboutus.php#header">About Us</a>
                    <a href="enquiry.php#header">Enquiry</a>
                    <a href="login.php#header">Login</a>
                    <a href="register.php#header">Register</a>
                    <a href="acknowledge.php#header">Acknowledgement</a>
                    <a href="enhancement.php#header">Enhancement</a>
                    <a href="user1.php#header">User 1</a>
                    <a href="user2.php#header">User 2</a>
                    <a href="user3.php#header">User 3</a>
                    <a href="user4.php#header">User 4</a>
                </div>
            </li>
            <li>Reference(s): <a href="https://www.w3schools.com/howto/howto_css_display_element_hover.asp">Display an Element on Hover</a></li>
        </ul>
    </section>

<?php
    include("footer.php");
    ?>

</body>
</html>
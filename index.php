<?php 
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en" class="home-document">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plantify home page.">
    <title>Index Page - Plantify</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class='home-page'>
<?php
    include ("header.php");
    ?>

    <section class="explore-cover" aria-labelledby="index-heading">
        <video class="cover-background" autoplay muted loop playsinline id="bg-video">
            <source src="images/index-bg.mp4" type="video/mp4">
                Your browser does not support the video tag.
        </video>
        <div class="cover-shade" aria-hidden="true"></div>

        <div class="cover-content">
            <h1 id="index-heading">Uncover Rare Flora</h1>
            <p class="hero-content">
                Welcome to Plantify, your sanctuary for discovering all striking, mysterious and fascinating plants from around the globe. With our platform, you can explore, learn and contribute meaningful infographics in the botany world. We also provide a plant-identifying service, which gives instant plant identification via photographs, yielding plant care instructions and best natural environments. Investigate the captivating realm of plants organized by family, genus, and species. Last but not least, connect with fellow plant lovers and share your enthusiasm.
            </p>

            <a class="home-explore-button" href="explore1.php" id="home-explore">Explore</a>
        </div>
    </section>

    <section class="ifeature-section">
    <h2>With the help of Plantify, you are able to: </h2>
    <div class="feature-divider">
        <span class="feature-line"></span>
        <span class="feature-leaf">&#x1F33F;</span>
        <span class="feature-line"></span>
    </div>

    <div class="ifeature-layout">

        <div class="ifeature-column ifeature-left">
        <div class="ifeature-item">
            <div class="ifeature-icon">
            <img src="images/features/binoculars.png" alt="Discover icon">
            </div>
            <div class="ifeature-text">
            <h3>Discover</h3>
            <p>the wonders of nature</p>
            </div>
        </div>

        <div class="ifeature-item">
            <div class="ifeature-icon">
            <img src="images/features/sprout.png" alt="Identify icon">
            </div>
            <div class="ifeature-text">
            <h3>Identify</h3>
            <p>unique plants</p>
            </div>
        </div>
        </div>

        <div class="ifeature-center-image">
        <img src="images/index-centre.png" alt="Image of a plant">
        </div>

        <div class="ifeature-column ifeature-right">
        <div class="ifeature-item">
            <div class="ifeature-icon">
            <img src="images/features/book.png" alt="Learn icon">
            </div>
            <div class="ifeature-text">
            <h3>Learn</h3>
            <p>from the community</p>
            </div>
        </div>

        <div class="ifeature-item">
            <div class="ifeature-icon">
            <img src="images/features/write.png" alt="write icon">
            </div>
            <div class="ifeature-text">
            <h3>Contribute</h3>
            <p>to Plantify's encyclopedia</p>
            </div>
        </div>
        </div>

    </div>
    </section>

    <section class="care-banner">
    <div class="banner-overlay"></div>

    <div class="banner-content">
    <div class="banner-text">
        <h2>Plant Care Made Simple</h2>
        <p>Struggling to keep your plants alive? Discover the simple care habits and watch your greenery flourish.</p>
        <a class="home-explore-button" href="identify.php">Identify your plants</a>
    </div>

    <div class="banner-cards">
        <div class="care-card">
        <div class="care-icon">
          <img src="images/features/droplet.png" alt="droplet">
        </div>
        <h3>Watering Guide</h3>
        <p>Learn the right way to water your plants.</p>
      </div>

      <div class="care-card">
        <div class="care-icon">
          <img src="images/features/care-tips.png" alt="healing plant">
        </div>
        <h3>Care Tips</h3>
        <p>Expert tips for thriving plants.</p>
      </div>
    </div>
  </div>
</section>
    
<section id="video-wrapper" class="video-section">
  <h2>See Plantify in Action</h2>
  <p>Watch how easy it is to identify and care for your plants.</p>

  <div>
    <iframe 
        src="https://www.youtube.com/embed/xHol7u90Bew" 
        title="YouTube video player" frameborder="0" allow="accelerometer; 
        autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; 
        web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
    </iframe>
  </div>
</section>

<section class="register-section" id="register">
    <div class="register-overlay"></div>

    <div class="register-content">
        <div class="register-logo-white">
            <img src="images/plantify_logo.png" alt="Plantify" class="register-logo">
        </div>
        <h2>Stay Updated! Join us in our adventure</h2>
        <p>Get the latest plant tips, care guides, and exclusive updates in your inbox!</p>
        <a href="register.php" class="register-btn">Join the Community</a>
    </div>
</section>    


<?php
    include ("footer.php");
    ?>

</body>


</html>

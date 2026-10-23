
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn how to identify Malaysian plants using photographs and their visible characteristics with Plantify.">
    <meta name="keywords" content="Plantify, plant identifier, biodiversity, Malaysia">
    <meta name="author" content="Plantify Team">
    <title>Identify Plants - Plantify</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="contribute-page identify-page">

    <?php include ("header.php"); ?>

    <main id="main-content" class="identifier-main">

        <section class="identifier-hero" aria-labelledby="identifier-heading">
            <img class="identifier-hero-background" src="images/explore-background1.png" alt="Lush green tropical plant leaves">
            <div class="identifier-hero-shade" aria-hidden="true"></div>

            <div class="identifier-hero-content">
                <p class="identifier-eyebrow">DISCOVER THE WORLD AROUND YOU</p>
                <h1 id="identifier-heading">Identify<br>a plant<span class="identifier-dot">.</span></h1>
                <p class="identifier-hero-description">Not sure which plant you have discovered? Start with a clear photograph, observe its unique features, and explore the plant families, genera and species documented by Plantify.</p>
                <p class="identifier-hero-detail">Once identified, a plant's name, care instructions, preferred environment and geographical location can be displayed.</p>
                <a class="identifier-hero-link" href="#identify-form">Start identifying <span aria-hidden="true">↓</span></a>
            </div>

            <div class="identifier-hero-index" aria-hidden="true">01 / DISCOVER</div>
        </section>

        <div class="identifier-workspace" id="identify-form">
            <div class="identifier-section-heading">
                <p class="identifier-eyebrow">01 / YOUR DISCOVERY</p>
                <h2>Every plant has a story.</h2>
                <p>Record the details you can see. This form demonstrates the identification interface; automatic recognition is planned for a later stage.</p>
            </div>

            <div class="identifier-layout">
                <section class="identifier-form-section" aria-labelledby="identify-form-heading">

                    <div class="identifier-form-title">
                        <span class="identifier-step">01</span>
                        <div>
                            <h3 id="identify-form-heading">Describe your plant</h3>
                            <p>Start with a photograph and a few simple observations.</p>
                        </div>
                    </div>

                    <form action="#identify-form" method="get" class="identifier-form">
                        <fieldset>
                            <legend>Plant observations</legend>

                            <div class="identifier-field identifier-field-wide">
                                <label for="identifier-photo">Choose a plant photograph <span class="identifier-required">*</span></label>
                                <input type="file" id="identifier-photo" name="plant_photo" accept="image/*" required>
                                <small>A close, well-lit photograph of the leaves or flowers works best.</small>
                            </div>

                            <div class="identifier-field">
                                <label for="identifier-location">Where was it found? <span class="identifier-required">*</span></label>
                                <input type="text" id="identifier-location" name="location" maxlength="80" placeholder="e.g. Kuching, Sarawak" required>
                            </div>

                            <div class="identifier-field">
                                <label for="identifier-feature">Main visible feature <span class="identifier-required">*</span></label>
                                <select id="identifier-feature" name="feature" required>
                                    <option value="">Select a feature</option>
                                    <option value="leaves">Leaves or leaf pattern</option>
                                    <option value="flowers">Flowers</option>
                                    <option value="fruit">Fruit or seeds</option>
                                    <option value="bark">Bark or trunk</option>
                                </select>
                            </div>

                            <div class="identifier-field identifier-field-wide">
                                <label for="identifier-notes">Other observations <span class="identifier-required">*</span></label>
                                <textarea id="identifier-notes" name="notes" rows="4" cols="45" maxlength="500" placeholder="Describe its colour, size, growing environment or other features." required></textarea>
                            </div>
                        </fieldset>

                        <div class="identifier-actions">
                            <button type="submit" class="identifier-submit">Search plant <span aria-hidden="true">↗</span></button>
                            <button type="reset" class="identifier-reset">Clear form</button>
                        </div>
                    </form>

                    <p class="identifier-form-note"><strong>Prototype only:</strong> The Search button demonstrates native form validation. Photos are not analysed or uploaded, and no identification results are generated yet.</p>
                </section>

                <aside class="identifier-tips" aria-labelledby="identifier-tips-heading">
                    <p class="identifier-eyebrow">FIELD GUIDE</p>
                    <h3 id="identifier-tips-heading">A better photo.<br>A better start.</h3>

                    <figure class="identifier-tips-photo">
                        <img src="images/explore-families.jpg" alt="Green tropical leaves showing distinct shapes and texture">
                        <figcaption>Observe leaf shapes, patterns and surroundings.</figcaption>
                    </figure>

                    <ol>
                        <li><strong>Find good light.</strong> Keep the plant clearly in focus.</li>
                        <li><strong>Check its features.</strong> Photograph leaves, flowers or fruit.</li>
                        <li><strong>Note the habitat.</strong> Record where it is growing.</li>
                        <li><strong>Leave it growing.</strong> Avoid removing protected plants.</li>
                    </ol>

                    <p class="identifier-tip-footnote">Similar-looking plants may need expert verification before their identity is confirmed.</p>
                </aside>
            </div>
        </div>

        <section class="identifier-explore" aria-labelledby="identifier-explore-heading">
            <div class="identifier-section-heading">
                <p class="identifier-eyebrow">02 / KEEP EXPLORING</p>
                <h2 id="identifier-explore-heading">From family to species.</h2>
                <p>Follow the branches of plant classification and compare photographs with the Plantify collection.</p>
            </div>

            <div class="identifier-cards">
                <a class="identifier-card" href="families.php#families-list">
                    <article>
                        <img src="images/explore-families.jpg" alt="Lush green tropical leaves">
                        <div class="identifier-card-content">
                            <p class="identifier-card-number">01 / BROAD CLASSIFICATION</p>
                            <h3>Families</h3>
                            <p>Discover characteristics shared across larger groups of related plants.</p>
                            <span class="identifier-card-action">Explore families <b aria-hidden="true">↗</b></span>
                        </div>
                    </article>
                </a>

                <a class="identifier-card" href="genera.php#genera-list">
                    <article>
                        <img src="images/explore-genera.jpg" alt="Green leaves and flowers">
                        <div class="identifier-card-content">
                            <p class="identifier-card-number">02 / CLOSER RELATIVES</p>
                            <h3>Genera</h3>
                            <p>Narrow down the possibilities by studying plants with closer similarities.</p>
                            <span class="identifier-card-action">Explore genera <b aria-hidden="true">↗</b></span>
                        </div>
                    </article>
                </a>

                <a class="identifier-card" href="species.php#species-list">
                    <article>
                        <img src="images/explore-species.jpg" alt="Bright flowers and green foliage">
                        <div class="identifier-card-content">
                            <p class="identifier-card-number">03 / PLANT IDENTITY</p>
                            <h3>Species</h3>
                            <p>Explore individual plant types through images and botanical descriptions.</p>
                            <span class="identifier-card-action">Explore species <b aria-hidden="true">↗</b></span>
                        </div>
                    </article>
                </a>
            </div>
        </section>

        <section class="identifier-glossary" aria-labelledby="identifier-glossary-heading">
            <div class="identifier-glossary-heading">
                <p class="identifier-eyebrow">THE BASICS</p>
                <h2 id="identifier-glossary-heading">A quick identification glossary</h2>
            </div>

            <dl>
                <div><dt>Family</dt><dd>A broad group of related plant genera.</dd></div>
                <div><dt>Genus</dt><dd>A group of closely related species.</dd></div>
                <div><dt>Species</dt><dd>A particular kind of plant within a genus.</dd></div>
            </dl>
        </section>

    </main>

    <?php include ("footer.php"); ?>

</body>
</html>

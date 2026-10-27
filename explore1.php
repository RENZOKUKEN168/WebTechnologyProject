<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore plant families, genera and species with Plantify.">
    <title>Explore Plants - Plantify</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="explore-page explore-landing-page">
    <?php
        include("header.php");
        ?>

    <section class="explore-cover" aria-labelledby="explore-heading">
        <img class="cover-background" src="images/explore-background1.png" alt="Fresh green plant leaves">
        <div class="cover-shade" aria-hidden="true"></div>

        <div class="cover-content">
            <p>The living world, explained</p>
            <h1 id="explore-heading">Explore Plants</h1>
            <a class="scroll-link" href="#categories">Scroll to explore <span aria-hidden="true">↓</span></a>
        </div>
    </section>

    <main class="explore-main">
        <section class="category-section" id="categories" aria-labelledby="category-heading">
            <div class="category-intro">
                <p>Discover the plant kingdom</p>
                <h2 id="category-heading">Explore by classification</h2>
                <p class="category-intro-copy">Follow each branch from a broad plant family to its two selected genera, then discover two individual species within every genus.</p>
            </div>

            <p class="classification-summary"><strong>Quick summary</strong><span>Choose a level to open its full page.</span></p>

            <div class="explore-cards" aria-label="Plant classification levels">
                <a class="card-link" href="families.html#families-list">
                    <article class="explore-card">
                        <img src="images/explore-families.jpg" alt="A variety of lush tropical leaves">
                        <div class="card-body">
                            <p class="card-number">01 · Broad plant group</p>
                            <h3>Families</h3>
                            <p class="card-description">Plants connected by major structural and evolutionary traits.</p>
                            <div class="card-meta"><span>4 families</span><span class="card-action">View page <b aria-hidden="true">→</b></span></div>
                        </div>
                    </article>
                </a>

                <a class="card-link" href="genera.html#genera-list">
                    <article class="explore-card">
                        <img src="images/explore-genera.jpg" alt="Small white flowers growing on a leafy shrub">
                        <div class="card-body">
                            <p class="card-number">02 · Two branches per family</p>
                            <h3>Genera</h3>
                            <p class="card-description">Closely related plants grouped within the same family.</p>
                            <div class="card-meta"><span>8 genera</span><span class="card-action">View page <b aria-hidden="true">→</b></span></div>
                        </div>
                    </article>
                </a>

                <a class="card-link" href="species.html#species-list">
                    <article class="explore-card">
                        <img src="images/explore-species.jpg" alt="A vivid red hibiscus flower among green leaves">
                        <div class="card-body">
                            <p class="card-number">03 · Two plants per genus</p>
                            <h3>Species</h3>
                            <p class="card-description">Individual plant types with their own distinct identity.</p>
                            <div class="card-meta"><span>16 species</span><span class="card-action">View page <b aria-hidden="true">→</b></span></div>
                        </div>
                    </article>
                </a>
            </div>

            <div class="explore-tool-links" id="tools" aria-label="More ways to explore plants">
                <a href="identify.html" class="explore-tool-link">
                    <span class="explore-tool-number">01 / Identify</span>
                    <strong>Found a plant you don't know?</strong>
                    <span>See how photo identification will help you discover its name.</span>
                    <b aria-hidden="true">↗</b>
                </a>
                <a href="contribute.html" class="explore-tool-link">
                    <span class="explore-tool-number">02 / Contribute</span>
                    <strong>Know a plant worth sharing?</strong>
                    <span>Add a known plant to the Plantify collection.</span>
                    <b aria-hidden="true">↗</b>
                </a>
            </div>

            <p class="classification-summary classification-summary-details"><strong>Family map</strong><span>Read left to right: family → genus → species. Select any name for details.</span></p>

            <div class="taxonomy-map" id="taxonomy-map">
                <article class="taxonomy-family">
                    <div class="taxonomy-family-card">
                        <img src="images/families/dipterocarpaceae.jpg" alt="Flowers and leaves from the Dipterocarpaceae family">
                        <div class="taxonomy-family-copy">
                            <p>Family 01 · Dipterocarp family</p>
                            <h3>Dipterocarpaceae</h3>
                            <span>Rainforest trees recognised for resinous wood and winged fruits.</span>
                            <a href="families.html#dipterocarpaceae-family">View family details <b aria-hidden="true">↗</b></a>
                        </div>
                    </div>
                    <div class="taxonomy-genera">
                        <section class="taxonomy-genus">
                            <div class="taxonomy-genus-heading"><span>Genus 01</span><h4><a href="genera.html#vatica-genus">Vatica</a></h4><p>Resinous Asian trees with wing-like fruit sepals.</p></div>
                            <div class="taxonomy-species">
                                <a href="species.html#vatica-borneensis-species"><span>Species 01</span><i>Vatica borneensis</i><small>Borneo · Near Threatened</small></a>
                                <a href="species.html#vatica-flavida-species"><span>Species 02</span><i>Vatica flavida</i><small>Malaysia · Critically Endangered</small></a>
                            </div>
                        </section>
                        <section class="taxonomy-genus">
                            <div class="taxonomy-genus-heading"><span>Genus 02</span><h4><a href="genera.html#dipterocarpus-genus">Dipterocarpus</a></h4><p>Tall Asian canopy trees with distinctive two-winged fruits.</p></div>
                            <div class="taxonomy-species">
                                <a href="species.html#dipterocarpus-alatus-species"><span>Species 01</span><i>Dipterocarpus alatus</i><small>Southeast Asian river forests</small></a>
                                <a href="species.html#dipterocarpus-grandiflorus-species"><span>Species 02</span><i>Dipterocarpus grandiflorus</i><small>Common name · Alakal</small></a>
                            </div>
                        </section>
                    </div>
                </article>

                <article class="taxonomy-family">
                    <div class="taxonomy-family-card">
                        <img src="images/families/lauraceae.jpg" alt="Leaves and flowers from the Lauraceae family" loading="lazy">
                        <div class="taxonomy-family-copy">
                            <p>Family 02 · Laurel family</p>
                            <h3>Lauraceae</h3>
                            <span>Aromatic evergreen trees and shrubs rich in fragrant oils.</span>
                            <a href="families.html#lauraceae-family">View family details <b aria-hidden="true">↗</b></a>
                        </div>
                    </div>
                    <div class="taxonomy-genera">
                        <section class="taxonomy-genus">
                            <div class="taxonomy-genus-heading"><span>Genus 01</span><h4><a href="genera.html#actinodaphne-genus">Actinodaphne</a></h4><p>Aromatic laurels with clustered leaves and small drupes.</p></div>
                            <div class="taxonomy-species">
                                <a href="species.html#actinodaphne-mushaensis-species"><span>Species 01</span><i>Actinodaphne mushaensis</i><small>Range · Taiwan</small></a>
                                <a href="species.html#actinodaphne-wightiana-species"><span>Species 02</span><i>Actinodaphne wightiana</i><small>Range · Southern India</small></a>
                            </div>
                        </section>
                        <section class="taxonomy-genus">
                            <div class="taxonomy-genus-heading"><span>Genus 02</span><h4><a href="genera.html#endiandra-genus">Endiandra</a></h4><p>Rainforest trees bearing fleshy, single-seeded fruits.</p></div>
                            <div class="taxonomy-species">
                                <a href="species.html#endiandra-sieberi-species"><span>Species 01</span><i>Endiandra sieberi</i><small>Common name · Hard corkwood</small></a>
                                <a href="species.html#endiandra-discolor-species"><span>Species 02</span><i>Endiandra discolor</i><small>Common name · Domatia tree</small></a>
                            </div>
                        </section>
                    </div>
                </article>

                <article class="taxonomy-family">
                    <div class="taxonomy-family-card">
                        <img src="images/families/burseraceae.jpg" alt="Leaves and fruit from the Burseraceae family" loading="lazy">
                        <div class="taxonomy-family-copy">
                            <p>Family 03 · Torchwood family</p>
                            <h3>Burseraceae</h3>
                            <span>Tropical woody plants known for aromatic bark and resins.</span>
                            <a href="families.html#burseraceae-family">View family details <b aria-hidden="true">↗</b></a>
                        </div>
                    </div>
                    <div class="taxonomy-genera">
                        <section class="taxonomy-genus">
                            <div class="taxonomy-genus-heading"><span>Genus 01</span><h4><a href="genera.html#canarium-genus">Canarium</a></h4><p>Resinous tropical trees valued for fruit, oils and timber.</p></div>
                            <div class="taxonomy-species">
                                <a href="species.html#canarium-album-species"><span>Species 01</span><i>Canarium album</i><small>Common name · Chinese olive</small></a>
                                <a href="species.html#canarium-australasicum-species"><span>Species 02</span><i>Canarium australasicum</i><small>Common name · Brown cudgerie</small></a>
                            </div>
                        </section>
                        <section class="taxonomy-genus">
                            <div class="taxonomy-genus-heading"><span>Genus 02</span><h4><a href="genera.html#dacryodes-genus">Dacryodes</a></h4><p>Evergreen trees with aromatic resin and fleshy drupes.</p></div>
                            <div class="taxonomy-species">
                                <a href="species.html#dacryodes-excelsa-species"><span>Species 01</span><i>Dacryodes excelsa</i><small>Common name · Gommier</small></a>
                                <a href="species.html#dacryodes-rostrata-species"><span>Species 02</span><i>Dacryodes rostrata</i><small>Region · Southeast Asia</small></a>
                            </div>
                        </section>
                    </div>
                </article>

                <article class="taxonomy-family">
                    <div class="taxonomy-family-card">
                        <img src="images/families/myristicaceae.jpg" alt="Fruit and leaves from the Myristicaceae family" loading="lazy">
                        <div class="taxonomy-family-copy">
                            <p>Family 04 · Nutmeg family</p>
                            <h3>Myristicaceae</h3>
                            <span>Tropical evergreen trees with aromatic sap and fleshy fruits.</span>
                            <a href="families.html#myristicaceae-family">View family details <b aria-hidden="true">↗</b></a>
                        </div>
                    </div>
                    <div class="taxonomy-genera">
                        <section class="taxonomy-genus">
                            <div class="taxonomy-genus-heading"><span>Genus 01</span><h4><a href="genera.html#horsfieldia-genus">Horsfieldia</a></h4><p>Nutmeg relatives whose fruits reveal brightly coloured arils.</p></div>
                            <div class="taxonomy-species">
                                <a href="species.html#horsfieldia-irya-species"><span>Species 01</span><i>Horsfieldia irya</i><small>Region · Tropical Asia</small></a>
                                <a href="species.html#horsfieldia-superba-species"><span>Species 02</span><i>Horsfieldia superba</i><small>Region · Southeast Asia</small></a>
                            </div>
                        </section>
                        <section class="taxonomy-genus">
                            <div class="taxonomy-genus-heading"><span>Genus 02</span><h4><a href="genera.html#knema-genus">Knema</a></h4><p>Asian evergreens with reddish sap and arillate seeds.</p></div>
                            <div class="taxonomy-species">
                                <a href="species.html#knema-attenuata-species"><span>Species 01</span><i>Knema attenuata</i><small>Common name · Wild nutmeg</small></a>
                                <a href="species.html#knema-conferta-species"><span>Species 02</span><i>Knema conferta</i><small>Region · Tropical Asia</small></a>
                            </div>
                        </section>
                    </div>
                </article>
            </div>

             <a class="back-to-overview" id="back-to-overview" href="#categories"><span aria-hidden="true">↑</span> Back to overview</a>
        </section>
    </main>

    <?php
        include("footer.php");
        ?>

</body>
</html>

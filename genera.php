<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Discover eight tropical plant genera with Plantify.">
    <title>Plant Genera - Plantify</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="explore-page genera-page">
    <?php
        include("header.php");
        ?>

    <section class="explore-cover families-cover" aria-labelledby="genera-heading">
        <img class="cover-background" src="images/explore-genera.jpg" alt="Small flowers and green leaves representing plant genera">
        <div class="cover-shade" aria-hidden="true"></div>
        <div class="cover-content">
            <p>Plant classification · Level 02</p>
            <h1 id="genera-heading">Plant<br>Genera</h1>
            <p class="cover-summary">Meet two genera from each selected family and discover the characteristics shared by their species.</p>
            <a class="scroll-link" href="#genera-list">Meet the genera <span aria-hidden="true">↓</span></a>
        </div>
    </section>

    <main class="explore-main classification-main">
        <aside class="classification-rail" id="rail">
            <p class="classification-rail-title">Plant<br>Levels</p>
            <nav aria-label="Plant classification pages">
                <a href="families.html#families-list">Families</a>
                <a href="genera.html#genera-list" aria-current="page">Genera</a>
                <a href="species.html#species-list">Species</a>
            </nav>
        </aside>
        <section class="families-section" id="genera-list" aria-labelledby="genera-list-heading">
            <div class="families-intro">
                <p>Two genera from each selected family</p>
                <h2 id="genera-list-heading">Eight groups within four families</h2>
            </div>
            <div class="classification-index" id="jump-links" role="navigation" aria-label="Jump to genera by family">
                <a href="#dipterocarpaceae-genera">Dipterocarpaceae</a>
                <a href="#lauraceae-genera">Lauraceae</a>
                <a href="#burseraceae-genera">Burseraceae</a>
                <a href="#myristicaceae-genera">Myristicaceae</a>
            </div>
            <div class="family-list">
                <div class="classification-divider" id="dipterocarpaceae-genera">
                    <p>Family 01</p><h3>Dipterocarpaceae</h3><span>2 selected genera</span>
                </div>
                <article class="family-row" id="vatica-genus">
                    <div class="family-image"><img src="images/genera/vatica.jpg" alt="Leaves and fruit of a Vatica tree"><span>01</span></div>
                    <div class="family-copy">
                        <p class="family-label"><a href="families.html#dipterocarpaceae-family">Dipterocarpaceae</a> · Genus 01</p><h3>Vatica</h3>
                        <p class="family-description">Vatica is a genus of tropical Asian rainforest trees. Its members commonly produce resinous timber and fruits with enlarged, wing-like sepals.</p>
                        <p class="family-genera"><strong>Selected species:</strong> <a href="species.html#vatica-borneensis-species">Vatica borneensis</a> · <a href="species.html#vatica-flavida-species">Vatica flavida</a></p>
                        <a href="https://www.inaturalist.org/taxa/182264-Vatica" target="_blank" rel="noopener">Explore on iNaturalist ↗</a>
                        <small>Photo: Min Sheng Khoo / iNaturalist · CC BY-NC-SA</small>
                    </div>
                </article>
                <article class="family-row" id="dipterocarpus-genus">
                    <div class="family-image"><img src="images/genera/dipterocarpus.jpg" alt="Leaves of a Dipterocarpus tree" loading="lazy"><span>02</span></div>
                    <div class="family-copy">
                        <p class="family-label"><a href="families.html#dipterocarpaceae-family">Dipterocarpaceae</a> · Genus 02</p><h3>Dipterocarpus</h3>
                        <p class="family-description">Dipterocarpus contains many tall canopy and emergent trees of Asian rainforests. The name refers to their distinctive two-winged fruits.</p>
                        <p class="family-genera"><strong>Selected species:</strong> <a href="species.html#dipterocarpus-alatus-species">Dipterocarpus alatus</a> · <a href="species.html#dipterocarpus-grandiflorus-species">Dipterocarpus grandiflorus</a></p>
                        <a href="https://www.inaturalist.org/taxa/157730-Dipterocarpus" target="_blank" rel="noopener">Explore on iNaturalist ↗</a>
                        <small>Photo: Maryse / iNaturalist · CC BY-NC</small>
                    </div>
                </article>
                <div class="classification-divider" id="lauraceae-genera">
                    <p>Family 02</p><h3>Lauraceae</h3><span>2 selected genera</span>
                </div>
                <article class="family-row" id="actinodaphne-genus">
                    <div class="family-image"><img src="images/genera/actinodaphne.jpeg" alt="Leaves of an Actinodaphne plant" loading="lazy"><span>03</span></div>
                    <div class="family-copy">
                        <p class="family-label"><a href="families.html#lauraceae-family">Lauraceae</a> · Genus 01</p><h3>Actinodaphne</h3>
                        <p class="family-description">Actinodaphne is a genus of evergreen trees and shrubs in the laurel family. Its aromatic leaves are often clustered near twig tips, and its small flowers develop into berry-like drupes.</p>
                        <p class="family-genera"><strong>Selected species:</strong> <a href="species.html#actinodaphne-mushaensis-species">Actinodaphne mushaensis</a> · <a href="species.html#actinodaphne-wightiana-species">Actinodaphne wightiana</a></p>
                        <a href="https://www.inaturalist.org/taxa/120374-Actinodaphne" target="_blank" rel="noopener">Explore on iNaturalist ↗</a>
                        <small>Photo: Cheng-Te Hsu / iNaturalist · CC BY</small>
                    </div>
                </article>
                <article class="family-row" id="endiandra-genus">
                    <div class="family-image"><img src="images/genera/endiandra.jpeg" alt="Leaves and fruit of an Endiandra tree" loading="lazy"><span>04</span></div>
                    <div class="family-copy">
                        <p class="family-label"><a href="families.html#lauraceae-family">Lauraceae</a> · Genus 02</p><h3>Endiandra</h3>
                        <p class="family-description">Endiandra consists mainly of evergreen rainforest trees found from Southeast Asia to Australia and the Pacific. Many species have simple leaves and fleshy, single-seeded fruits.</p>
                        <p class="family-genera"><strong>Selected species:</strong> <a href="species.html#endiandra-sieberi-species">Endiandra sieberi</a> · <a href="species.html#endiandra-discolor-species">Endiandra discolor</a></p>
                        <a href="https://www.inaturalist.org/taxa/129512-Endiandra" target="_blank" rel="noopener">Explore on iNaturalist ↗</a>
                        <small>Photo: Casey / iNaturalist · CC BY-NC</small>
                    </div>
                </article>
                <div class="classification-divider" id="burseraceae-genera">
                    <p>Family 03</p><h3>Burseraceae</h3><span>2 selected genera</span>
                </div>
                <article class="family-row" id="canarium-genus">
                    <div class="family-image"><img src="images/genera/canarium.jpeg" alt="Fruit and foliage of a Canarium tree" loading="lazy"><span>05</span></div>
                    <div class="family-copy">
                        <p class="family-label"><a href="families.html#burseraceae-family">Burseraceae</a> · Genus 01</p><h3>Canarium</h3>
                        <p class="family-description">Canarium includes resinous tropical trees with compound leaves and fleshy stone fruits. Several species are valued for edible fruits, fragrant resins, timber or useful oils.</p>
                        <p class="family-genera"><strong>Selected species:</strong> <a href="species.html#canarium-album-species">Canarium album</a> · <a href="species.html#canarium-australasicum-species">Canarium australasicum</a></p>
                        <a href="https://www.inaturalist.org/taxa/83453-Canarium" target="_blank" rel="noopener">Explore on iNaturalist ↗</a>
                        <small>Photo: Graham Bell / iNaturalist · CC BY-NC</small>
                    </div>
                </article>
                <article class="family-row" id="dacryodes-genus">
                    <div class="family-image"><img src="images/genera/dacryodes.jpg" alt="Foliage and fruit of a Dacryodes tree" loading="lazy"><span>06</span></div>
                    <div class="family-copy">
                        <p class="family-label"><a href="families.html#burseraceae-family">Burseraceae</a> · Genus 02</p><h3>Dacryodes</h3>
                        <p class="family-description">Dacryodes is a pantropical genus of evergreen trees. These plants are recognised for aromatic resin, compound foliage and fleshy fruits eaten by wildlife and people.</p>
                        <p class="family-genera"><strong>Selected species:</strong> <a href="species.html#dacryodes-excelsa-species">Dacryodes excelsa</a> · <a href="species.html#dacryodes-rostrata-species">Dacryodes rostrata</a></p>
                        <a href="https://www.inaturalist.org/taxa/183866-Dacryodes" target="_blank" rel="noopener">Explore on iNaturalist ↗</a>
                        <small>Photo: Armando Feliciano / iNaturalist · CC BY-NC</small>
                    </div>
                </article>
                <div class="classification-divider" id="myristicaceae-genera">
                    <p>Family 04</p><h3>Myristicaceae</h3><span>2 selected genera</span>
                </div>
                <article class="family-row" id="horsfieldia-genus">
                    <div class="family-image"><img src="images/genera/horsfieldia.jpg" alt="Fruit of a Horsfieldia tree" loading="lazy"><span>07</span></div>
                    <div class="family-copy">
                        <p class="family-label"><a href="families.html#myristicaceae-family">Myristicaceae</a> · Genus 01</p><h3>Horsfieldia</h3>
                        <p class="family-description">Horsfieldia contains tropical Asian evergreen trees related to nutmeg. Their fleshy fruits split open at maturity and expose a seed that is often partly surrounded by a vivid aril.</p>
                        <p class="family-genera"><strong>Selected species:</strong> <a href="species.html#horsfieldia-irya-species">Horsfieldia irya</a> · <a href="species.html#horsfieldia-superba-species">Horsfieldia superba</a></p>
                        <a href="https://www.inaturalist.org/taxa/186487-Horsfieldia" target="_blank" rel="noopener">Explore on iNaturalist ↗</a>
                        <small>Photo: Ian Lockwood / iNaturalist · CC BY-NC</small>
                    </div>
                </article>
                <article class="family-row" id="knema-genus">
                    <div class="family-image"><img src="images/genera/knema.jpg" alt="Fruit and leaves of a Knema tree" loading="lazy"><span>08</span></div>
                    <div class="family-copy">
                        <p class="family-label"><a href="families.html#myristicaceae-family">Myristicaceae</a> · Genus 02</p><h3>Knema</h3>
                        <p class="family-description">Knema is a genus of evergreen trees distributed across tropical Asia. Many species have reddish sap and fruits that open to reveal a dark seed wrapped in a brightly coloured aril.</p>
                        <p class="family-genera"><strong>Selected species:</strong> <a href="species.html#knema-attenuata-species">Knema attenuata</a> · <a href="species.html#knema-conferta-species">Knema conferta</a></p>
                        <a href="https://www.inaturalist.org/taxa/186259-Knema" target="_blank" rel="noopener">Explore on iNaturalist ↗</a>
                        <small>Photo: S.MORE / iNaturalist · CC0</small>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <?php
        include("footer.php");
        ?>

</body>
</html>

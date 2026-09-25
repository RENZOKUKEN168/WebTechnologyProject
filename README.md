# Biodiversity Monitoring & Plant Data Collection Website

A static web application developed as a prototype redesign to assist scientists in tracking, managing, and conserving Malaysia's rich yet threatened plant biodiversity. Built entirely using validated **HTML5** and **CSS3**, focusing on clean structural semantics and responsive visual layouts without JavaScript.

This project was developed for the unit **COS10026 Web Technology Project (Assignment 1)** at **Swinburne University of Technology Sarawak**.

## 📌 Project Overview
Malaysia stands as a key global biodiversity hotspot facing increasing pressure from population growth and agricultural expansion. This portal leverages a citizen science framework, allowing users and researchers to contribute observations, register profiles, and navigate detailed taxonomical hierarchies of plant families, genera, and species.

## 📂 Repository Structure
The project adheres strictly to the required assignment deployment architecture:

```text
yourname_assign1/
├── index.html           # Website homepage & introductory portal
├── explore.html         # Main Taxonomy dashboard
├── explore1.html        # Plant Families directory
├── explore2.html        # Plant Genera directory
├── explore3.html        # Plant Species directory
├── identify.html        # Plant identification reference guide
├── contributor.html     # Active community contributor spotlights
├── contribute.html      # Form to submit new plant observations
├── register.html        # Citizen scientist registration form
├── enquiry.html         # Standard products/services inquiry form
├── login.html           # User authentication form
├── enhancement1.html    # Detailed documentation of HTML5/CSS3 enhancements
├── [member_profile].html# Individual student profile page(s)
├── images/              # Semantic content images (with alt text)
└── styles/
    └── style.css        # Core global CSS stylesheet (valid CSS2.1/CSS3)
```

## 🛠️ Tech Stack & Key Requirements
* **HTML5:** Semantic architecture utilizing structure elements (`<header>`, `<nav>`, `<article>`, `<section>`, `<aside>`, `<footer >`). Fully validated against the W3C markup validator.
* **CSS3:** Written purely via a unified external stylesheet (`style.css`) managing visual layout, fluid resizing, responsive columns, elements isolation, custom forms, and typography styles.
* **No JavaScript:** Form completeness, pattern boundaries, and layout restrictions are managed strictly through standard HTML5 attributes and native browser engines.

## 📄 Pages Implemented

### Core Navigation
1. **Homepage (`index.html`)**: Introduces the project context, links the project demonstration video, and establishes the global navigation header.
2. **Taxonomy Tree (`explore.html` subpages)**: At least 4 distinct interconnected pages mapping out 4 Families, 8 Genera, and 16 Species with rich images, descriptions, semantic description lists, and structural asides.
3. **Data Forms (`contribute`, `register`, `enquiry`, `login`)**: Native form portals managing text criteria limits, postcodes, dynamic selectors, and clean fieldset groups.
4. **Enhancements Dashboard (`enhancement1.html`)**: Hyperlinks directly to specific features running complex layouts or media tools that push beyond basic course frameworks.

## 🚀 Deployment Instructions
To run this application locally:

1. Clone this repository into your machine's standard document root:
   ```bash
   git clone https://github.com
   ```
2. If deploying onto a local test server, move the root folder into your local installation directory (e.g., `XAMPP/htdocs/` or your Unix Apache directory space).
3. Launch your local server panel and boot up **Apache**.
4. Access the webpage via your browser:
   ```text
   http://localhost/yourname_assign1/index.html
   ```

*Note: All asset pathways are structured relatively to ensure zero broken links when migrating hosting servers.*

## 👥 Group Details & Contributions
* **Unit:** COS10026 Web Technology Project
* **Semester:** Semester 2, 2026
* **Institution:** Swinburne University of Technology Sarawak

| Student Name | Student ID | Core Responsibilities |
| :--- | :--- | :--- |
| **Member 1** | ID_HERE | Core Structure, Taxonomy Module, Forms |
| **Member 2** | ID_HERE | Universal Global CSS, Fluid Page Layout |
| **Member 3** | ID_HERE | Technical Report, Forms Engineering |
| **Member 4** | ID_HERE | Enhancement Integration, Quality Audits |

# Biodiversity Monitoring & Plant Data Collection Website

A static web application developed as a prototype redesign to assist scientists in tracking, managing, and conserving Malaysia's rich yet threatened plant biodiversity. Built entirely using validated **HTML5** and **CSS3**, focusing on clean structural semantics and responsive visual layouts without JavaScript.

This project was developed for the unit **COS10026 Web Technology Project (Assignment 1)** at **Swinburne University of Technology Sarawak**.

## 📌 Project Overview
Malaysia stands as a key global biodiversity hotspot facing increasing pressure from population growth and agricultural expansion. This portal leverages a citizen science framework, allowing users and researchers to contribute observations, register profiles, and navigate detailed taxonomical hierarchies of plant families, genera, and species.

## 📂 Repository Structure
The project architecture maps out the current source file development space:

```text
WebTechnologyProject/
├── contribute.html      # Form to submit new plant observations
├── explore1.html        # Plant Categories landing page
├── families.html        # Plant Families directory
├── genera.html          # Plant Genera directory
├── species.html         # Plant Species directory
├── .gitignore           # Git ignore rules configuration file
├── style.css            # Core global CSS stylesheet
└── Photos/              # Directory containing project image assets
    ├── families/        # Nested photo sets for plant family examples
    ├── genera/          # Nested photo sets for plant genus examples
    ├── species/         # Nested photo sets for plant species examples
    ├── explore-background1.png
    ├── explore-families.jpg
    ├── explore-genera.jpg
    ├── explore-species.jpg
    ├── index-page-concept.png
    ├── plantify_logo.png
    └── profile-photo.jpg
```

*Note: Before final server deployment, these files must be reorganized into standard root `assign1/`, `images/`, and `styles/` subdirectories to prevent assignment compliance deductions.*

## 🛠️ Tech Stack & Key Requirements
* **HTML5:** Semantic architecture utilizing structure elements (`<header>`, `<nav>`, `<article>`, `<section>`, `<aside>`, `<footer >`). Fully validated against the W3C markup validator.
* **CSS3:** Written via an external stylesheet managing visual layout, fluid resizing, responsive columns, and typography styles.
* **No JavaScript:** Form completeness, pattern boundaries, and layout restrictions are managed strictly through standard HTML5 attributes and native browser engines.

## 📄 Core Interface Modules

### 🌿 Taxonomy Tree (`explore1.html`, `families.html`, etc.)
* **Families**: Categorizes 4 specific plant groups.
* **Genera**: Houses 2 distinct plant genera under each family branch.
* **Species**: Tracks 2 unique plant species under each genus node.
* Contains structural asides, definition lists, ordered lists, and figures with captions.

### 📝 Citizen Portals (`contribute.html`)
* Natively managed form submission platform mapping name data, file types, and text area summaries.
* Utilizes explicit validation boundary controls strictly using native browser engines.

## 🚀 Execution Instructions
To run this application workspace locally:

1. Clone this repository into your machine's environment:
   ```bash
   git clone https://github.com
   ```
2. Open the directory workspace in your preferred source editor (e.g., **VS Code**).
3. Open any active HTML file (such as `explore1.html`) using a live server execution plugin or drag the file into your local web browser.

## 👥 Project Details
* **Unit:** COS10026 Web Technology Project
* **Semester:** Semester 2, 2026
* **Institution:** Swinburne University of Technology Sarawak

# Biodiversity Monitoring & Plant Data Collection Website

A static web application developed as a prototype redesign to assist scientists in tracking, managing, and conserving Malaysia's rich yet threatened plant biodiversity. Built entirely using validated **HTML5** and **CSS3**, focusing on clean structural semantics and responsive visual layouts without JavaScript.(For now)

This project was developed for the unit **COS10026 Web Technology Project (Assignment 1)** at **Swinburne University of Technology Sarawak**.

## 📌 Project Overview
Malaysia stands as a key global biodiversity hotspot facing increasing pressure from population growth and agricultural expansion. This portal leverages a citizen science framework, allowing users and researchers to contribute observations, register profiles, and navigate detailed taxonomical hierarchies of plant families, genera, and species.

## 📂 Repository Structure
The project architecture maps out the current source file development space:

```text
WebTechnologyProject/
├── .vscode/                 # Editor configuration settings
├── images/                  # Directory containing project image assets
├── styles/                  # Directory containing CSS stylesheets
├── .gitignore               # Git ignore rules configuration file
├── Aboutus.php              # About the project and development team page
├── acknowledge.php          # Submission acknowledgement page
├── connection.php           # Database connection configuration
├── contribute_form.php      # Form component for plant observation submissions
├── contribute.php           # Observation contribution portal landing page
├── enhancement.php          # Documentation of applied web enhancements
├── enquiry.php              # User enquiry and contact form
├── explore1.php             # Plant Categories exploration landing page
├── families.php             # Plant Families directory
├── footer.php               # Shared footer template component
├── genera.php               # Plant Genera directory
├── header.php               # Shared navigation and header template component
├── identify.php             # Plant identification assistance portal
├── index.php                # Homepage and main portal landing page
├── login.php                # User authentication interface
├── README.md                # Project documentation file
├── register_process.php     # Registration form processing script
├── register.php             # User registration form
├── species.php              # Plant Species directory
├── user-aside.php           # Shared user dashboard sidebar component
├── user1.php                # User Profile page 1
├── user2.php                # User Profile page 2
├── user3.php                # User Profile page 3
└── user4.php                # User Profile page 4

```

*Note: Before final server deployment, these files must be reorganized into standard root `assign1/`, `images/`, and `styles/` subdirectories to prevent assignment compliance deductions.*

## 🛠️ Tech Stack & Key Requirements
* **HTML5:** Semantic architecture utilizing structure elements (`<header>`, `<nav>`, `<article>`, `<section>`, `<aside>`, `<footer >`). Fully validated against the W3C markup validator.
* **CSS3:** Written via an external stylesheet managing visual layout, fluid resizing, responsive columns, and typography styles.
* **No JavaScript:** Form completeness, pattern boundaries, and layout restrictions are managed strictly through standard HTML5 attributes and native browser engines.

## 📄 Core Interface Modules

### 🌿 Taxonomy Tree (`explore1.php`, `families.php`, etc.)
* **Families**: Categorizes 4 specific plant groups.
* **Genera**: Houses 2 distinct plant genera under each family branch.
* **Species**: Tracks 2 unique plant species under each genus node.
* Contains structural asides, definition lists, ordered lists, and figures with captions.

### 📝 Citizen Portals (`contribute.php`)
* Natively managed form submission platform mapping name data, file types, and text area summaries.
* Utilizes explicit validation boundary controls strictly using native browser engines.

## 🚀 Execution Instructions
To run this application workspace locally:

1. Clone this repository into your machine's environment:
   ```bash
   git clone https://github.com/RENZOKUKEN168/WebTechnologyProject
   ```
2. Start your local Apache and MySQL database server services.
3. Import the required database structure using the configuration details specified in connection.php.
4. Open the directory workspace in your preferred source editor (e.g., VS Code).
5. Navigate to http://localhost/WebTechnologyProject/index.php in your web browser.

## 👥 Project Details
* **Unit:** COS10026 Web Technology Project
* **Semester:** Semester 1, 2026
* **Institution:** Swinburne University of Technology Sarawak

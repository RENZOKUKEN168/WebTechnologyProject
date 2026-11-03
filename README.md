# Plantify – Plant Biodiversity Website
## Assignment 2: PHP/MySQL

Plantify is a responsive website prototype for exploring Malaysian plant families, genera and species, sharing plant observations, and sending enquiries. Assignment 2 adds a PHP and MySQLi for reviewing submissions, managing enquiries and members, and publishing approved plant contributions.

## Project Contributors

| Name | Student ID |
| --- | --- |
| Suvasis Giri | 106759735 |
| Darren Chong Khai Chen | 104406534 |
| Chin Jii Ann | 106764962 |
| Tiaw Le-San | 106766492 |

## Implemented Features

| Area | Pages | Current functionality |
| --- | --- | --- |
| Plant discovery | `index.php`, `explore1.php`, `families.php`, `genera.php`, `species.php` | Browse the plant classification pages and explore the family-to-genus-to-species relationships. |
| Plant identification | `identify.php` | Shows an observation form and guidance. Automatic photo recognition and identification results are not connected yet. |
| Community contribution | `contribute.php`, `contribute_form.php` | Visitors can submit a plant name, contributor name, comments and optional photos. Submissions are stored for admin review. |
| Enquiry | `enquiry.php` | Saves enquiry details to MySQL for the admin to review. |
| Login and accounts | `register.php`, `register_process.php`, `login.php`, `logout.php` | Supports member registration, shared login, role-based admin routing, and a logout success page with an OK link or a five-second return to login. |
| Admin dashboard | `admin.php`, `admin_header.php` | Provides shared admin navigation and a dashboard for submissions and regular accounts. |
| Enquiry management | `view_enquiry.php` | Admins can edit or delete enquiries, mark them as read, and save a reply with the enquiry. Replies are stored in the panel and are not emailed automatically. |
| Contribution review | `view_contribution_form.php` | Admins can inspect photos and submission details, edit, approve or reject, delete, and use **Commit** to publish a plant on `contribute.php`. |
| Member management | `view_member.php` | Admins can change member roles or remove members. The main account `admin` always has the Admin role and cannot be edited or removed. |
| Shared layout and profiles | `header.php`, `footer.php`, `user1.php`–`user4.php` | Reuses site navigation/footer and includes member profile page examples. |

## Requirements

- PHP with MySQLi and the PHP Fileinfo extension for validating uploaded images
- MySQL or MariaDB
- XAMPP (Apache and MySQL services)
- A modern web browser
- No JavaScript is used for the admin interactions; forms use PHP, HTML and CSS.

## How to Run

1. Place the project folder in XAMPP's `htdocs` directory. The expected local path is:

   ```text
   /Applications/XAMPP/xamppfiles/htdocs/Plantify
   ```

2. Start **Apache** and **MySQL** in XAMPP.
3. Open phpMyAdmin and create a database named `plantify_db`.
4. Check `connection.php`. Its current local settings are host `localhost`, user `root`, an empty password, and database `plantify_db`. Update these values if your XAMPP configuration differs.
5. Create the `register` account table by opening `http://localhost/Plantify/register_createtable.php` once.
6. The login system requires a `role` column. If the column is not already present, run this once in phpMyAdmin's SQL tab:
7. Login by admin: 
   Username : admin
   Password : admin

   ```sql
   ALTER TABLE register
   ADD COLUMN role ENUM('user', 'admin') NOT NULL DEFAULT 'user';
   ```

   Skip this step if `register` already has a `role` column.
7. In phpMyAdmin, create the main admin account with username `admin`, password `admin`, and role `admin`. The account table also requires the profile fields defined in `register_createtable.php`.
8. Open the website at:

   ```text
   http://localhost/Plantify/index.php
   ```

   Use `http://localhost/Plantify/login.php` to sign in. The contribution and enquiry tables are created by their respective form pages when first opened. Admin links are available after signing in with an account whose role is `admin`.

## Database Tables

| Table | Purpose |
| --- | --- |
| `register` | Member details, login credentials and `user`/`admin` role. |
| `contributions` | Plant submissions, optional photo paths, comments, review status, submission date and publication date. |
| `enquiry` | Enquiry contact details, message, read status, saved admin reply and dates. |

## Main Project Files

| File or folder | Purpose |
| --- | --- |
| `index.php` | Website homepage. |
| `explore1.php` | Plant exploration landing page and family map. |
| `families.php`, `genera.php`, `species.php` | Plant classification pages. |
| `identify.php` | Plant observation and identification prototype. |
| `contribute.php`, `contribute_form.php` | Public contribution page and submission form. |
| `enquiry.php` | Public enquiry form. |
| `login.php`, `register.php`, `register_process.php`, `logout.php` | Account registration and authentication pages. |
| `admin.php`, `admin_header.php` | Admin dashboard and navigation. |
| `view_enquiry.php` | Enquiry review and replies. |
| `view_contribution_form.php` | Plant submission moderation and publishing. |
| `view_member.php` | Member role and account management. |
| `connection.php` | MySQL connection settings. |
| `header.php`, `footer.php` | Shared public site header and footer. |
| `styles/style.css` | Shared page, responsive and admin styles. |
| `images/`, `Photos/`, `uploads/` | Site images, profile photos and uploaded plant photos. |

## Current Progress

The Assignment 2 admin pages and form-to-database connections are in place. The main admin account is protected from role changes and removal. Plant submissions can be reviewed before publication, and committed submissions appear on the public Contribution page. The plant identifier remains a visual prototype and does not currently analyze uploaded photos.

There is no automated test suite in the project. Run Apache and MySQL in XAMPP and check the required pages through the browser when validating a local setup.

## Notes

- The public plant classification pages contain the current project content; they are not a complete botanical database.
- The demonstration admin credentials are `admin` / `admin`, as configured locally in phpMyAdmin.
- Admin replies are saved for viewing in the admin panel; no email delivery is configured.

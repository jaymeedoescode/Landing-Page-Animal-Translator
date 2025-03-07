# Landing-Page-Animal-Translator
Animal translator software landing page for software dev assignment. Jaime and I made a project selling a machine that helps talk to animals. We split it down the middle so he got the index file and I got the about file, we split the small requirements and did styling for our own pages. We then collaborated at the end for testing, code review, and submitting. I, Abdu, had troubles with keeping accurate records of the commits and which branch I'm committing from which is definitely a lesson to be learned. I tried to leave small notes to try and make it less confusing. Overall, Jaime did a great job divying up the workload and  split it 50/50 so the work load was split even and we both got to work on the various parts so we'd have a better idea.

Work flow split:

Jaime’s Responsibilities:
Create the GitHub repo & add the instructor/TAs.
Build index.html (main landing page).
Implement ID-based CSS styles & Flexbox.
Test for mobile responsiveness.
Review & approve Partner B’s pull request.

Abdu’s B Responsibilities:
Define project details in the README file.
Build about.html (or second page).
Implement Class-based CSS styles & navigation styling.
Run Google Lighthouse tests & optimize scores.
Review & approve Partner A’s pull request.

Both:
Plan the project together.
Set up GitHub issues & feature branches.
Validate HTML/CSS & visually inspect site.
Ensure GitHub Pages deployment is working.
Confirm the 50/50 split in the README before submission.


# CRUD-webapp
Assignment 2 for software dev - Jaime & Abdu - A web application for user authentication and CRUD functionality using PHP and MySQL


**Assignment 2 for Software Dev**
- **Partners:** Jaime & Abdu
- **Project:** A web application for user authentication and CRUD functionality using PHP and MySQL
 
# Project Structure
- **css/** - CSS stylesheets
- **js/** - JavaScript files
- **php/** - PHP backend scripts (login, registration, CRUD)
- **sql/** - SQL scripts for database creation
- **images/** - Images and screenshots
- **README.md** - Project documentation and setup instructions

## Upcoming Tasks
- Set up user authentication (registration, login, logout)
- Implement CRUD functionality for data management
- Configure and deploy the project
- Write comprehensive documentation with screenshots and setup instructions


![phpMyAdmin Screenshot](./pictures/screenshot.png)
![Database Structure](./pictures/imgtable.png)




## Database Queries

### SQL Query to Create the Database:
```sql
CREATE DATABASE `app-db`;

CREATE TABLE `users` (
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`username`)
);




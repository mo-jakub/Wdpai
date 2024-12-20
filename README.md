# Power of Knowledge

## Overview
The "Power of Knowledge" project is a simple web application.
It features a clean, responsive design, with functionality to highlight books and provide navigation through genres.

## Features
- **Responsive Navigation:** Links to Home, Genre, and Tags sections.
- **Search Bar:** Allows users to search for books by title or author.
- **Book Grid:** Displays books with images, darkening on hover.
- **Footer:** Links to About Us, Contact, and social media.

## Project Structure
### HTML
- **Dashboard:** Main page for displaying genres and books. **(Uses PHP)**
- **Login Page:** Form to log into an account.
- **Register Page:** Form to create an account.

### CSS
- **Style:** CSS styling for the HTML pages to keep the design consistent and straightforward.

### PHP
- **AppControllers:** PHP controllers to help in rendering the pages.
- **DatabaseConnector:** PHP connector to access the database.
- **Routing and index:** They choose appropriate controller to render specific pages.

## Folder Structure
project/
├── docker/
│   ├── db/
│   │   ├── Dockerfile
│   │   └── init.sql
│   ├── nginx/
│   │   ├── Dockerfile
│   │   └── nginx.conf
│   └── php/
│       └── Dockerfile
├── public/
│   ├── images/
│   ├── partials/
│   │   ├── footer.php
│   │   └── header.php
│   ├── styles/
│   │   └── style.css
│   └── views/
│       ├── dashboard.php
│       ├── login.php
│       └── register.php
├── src/
│   └── controllers/
│       ├── AppController.php
│       ├── DefaultController.php
│       └── SecurityController.php
├── config.php
├── DatabaseConnector.php
├── docker-compose.yml
├── index.php
├── README.md
└── Routing.php
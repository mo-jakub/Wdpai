# Power of Knowledge

## Overview
The "Power of Knowledge" project is a simple web application.
It features a clean, responsive design, with functionality to highlight books and provide navigation.

## Features
- **Responsive Navigation:** Links to Home, Genre, and Tags sections.
- **Search Bar:** Allows users to search for books by title or author.
- **Book Grid:** Displays books sorted by genre.
- **Footer:** Links to About Us, Contact, and social media.

## How to use it
1. Clone or otherwise download the files.
2. Use `docker compose up --build` in the project folder.
3. When the project is running you can:
   1. connect to pgadmin (a way to access the database) by url: http://localhost:5050
      1. the necessary data to login is found in .env file
      2. if you're creating a site based on this project, you should consider changing the information there
   2. connect to the site itself by url: http://localhost:8080
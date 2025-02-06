# Power of Knowledge
## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Setup Instructions](#setup-instructions)
- [Database](#database)
   - [Structure](#structure)
   - [ERD Diagram](#erd-diagram)
- [User Management](#user-management)
- [Security](#security)
- [Screenshots of the Application](#screenshots-of-the-application)

## Overview
**Power of Knowledge** is a web-based application designed to display, organize, and manage books. It provides a user-friendly, responsive interface where users can browse books, search by titles/authors, and filter by genres and tags.
The project leverages modern web development practices, including object-oriented programming on the backend, responsive design principles, and a robust database system.
## Features
- **Responsive Design:** Highly accessible and mobile-friendly layout.
- **Navigation Menu:** Includes links to Home, Genre, and Tags sections, making it easy to browse.
- **Search Functionality:** A search bar to quickly locate books by title or author.
- **User Management:**
   - Secure login system with sessions.
   - Users can log out easily with features to prevent unauthorized access.
   - Role-based access control with: users, moderators and admins.

- **Footer Section:** Features links to "About Us" and "Contact" plus social media icons.

## Technologies Used
- **Frontend:**
   - HTML5, CSS3, JavaScript (with Fetch API/AJAX for dynamic interactions)
   - Responsive and clean UI/UX design

- **Backend:**
   - PHP
   - PostgreSQL for database design and management

- **Additional Tools:**
   - Docker for containerization and easy environment setup
   - Git for version control

## Setup Instructions
### Prerequisites
- [Docker](https://www.docker.com/) installed on your system
- A working internet connection to access Docker images and dependencies

### Steps to Run
1. Clone the repository or download the project files:
``` bash
   git clone <this_repository_s_URL>
```
1. Navigate to the project folder and run:
``` bash
   docker compose up --build
```
1. Access the application:
   - **Website:** Open [http://localhost:8080](http://localhost:8080) in your browser.
   - **Database Admin Panel:** Open [http://localhost:5050](http://localhost:5050).
     - You can also access the database using other programs such as Navicat.
2. Log in to the database admin panel using credentials found in the `.env` file (ensure you secure this file if deploying publicly).
3. Customize `.env` variables for production-grade deployment.

## Database
The application uses a PostgreSQL database for managing book and user data.
### Structure
- **Entities:** Books, Authors, Genres, Tags, Users, Admins
- **Features:**
   - Admin roles
   - Relational integrity via foreign keys and references

### ERD Diagram
![ERD Diagram](/public/images/readme/ERDDiagram.svg)
## User Management
- **Login/Session Management:**
   - Users can securely log in.
   - Authorized sessions are created with proper cookie handling.

- **Roles:**
   - **Admin:** Can manage books, genres, tags, and authors.
   - **Moderator:** Can remove other users' comments.
   - **User:** Can browse and search for books.

## Security
- Sensitive credentials and configurations are stored in a `.env` file.
- User passwords are hashed and stored securely.
- Unused or replicated code is minimized to ensure a clean codebase.

## Screenshots of the Application
### Dashboard
#### On Desktop
![dashboard](/public/images/readme/dashboard.png)
#### On Mobile
![dashboard](/public/images/readme/dashboard-mobile.png)
##### 2nd Screenshot
![dashboard](/public/images/readme/dashboard-mobile-2.png)
### Book Example Page
#### On Desktop
![book](/public/images/readme/book.png)
#### On Mobile
![book](/public/images/readme/book-mobile.png)
##### 2nd Screenshot
![book](/public/images/readme/book-mobile-2.png)
### Register Page
#### On Desktop
![register](/public/images/readme/register.png)
#### On Mobile
![register](/public/images/readme/register-mobile.png)
### Login Page
#### On Desktop
![login](/public/images/readme/login.png)
#### On Mobile
![login](/public/images/readme/login-mobile.png)
### Searching by Genre
- Tags and Authors pages look similarly
#### On Desktop
![genres](/public/images/readme/genres.png)
![genre](/public/images/readme/genre.png)
#### On Mobile
![genres](/public/images/readme/genres-mobile.png)
![genre](/public/images/readme/genre-mobile.png)
### User Page
#### On Desktop
![user](/public/images/readme/user.png)
#### On Mobile
![user](/public/images/readme/user-mobile.png)
![user](/public/images/readme/user-mobile-2.png)
### Administration
![admin](/public/images/readme/admin.png)
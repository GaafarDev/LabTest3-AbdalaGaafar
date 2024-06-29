# CRUD Application with Slim Framework and Vue.js

This project is a lab test submission for the course Web Technology. It implements a simple CRUD application with a backend using Slim Framework and a frontend using Vue.js. Below are the details and instructions for the project.

## Table of Contents
1. [Project Requirements](#project-requirements)
2. [Bonus Features](#bonus-features)
3. [Installation](#installation)
   - [Backend Installation and Setup](#backend-installation-and-setup)
   - [Frontend Installation and Setup](#frontend-installation-and-setup)
4. [Project Structure](#project-structure)
5. [Components and Routing](#components-and-routing)

## Project Requirements:
- Backend app with Slim Framework. (5% marks)
- Backend app that serves 5 basic API endpoints: view all users, view a user, save a user, update a user, and delete a user. (25% marks)
- Frontend app with Vue JS. (5% marks)
- Frontend app that provides UIs similar to those shown in the videocast. (20% marks)
- Frontend app that integrates with the backend to fetch and manipulate users' data in the database. (10% marks)
- Apply Vuex state management in the Vue app to store users' data. (10% marks)
- Implement Vuex actions for all CRUD operations on users' data. (10% marks)
- Apply validation in the backend for empty and invalid inputs. (5% marks)
- Apply validation in the frontend for empty and invalid inputs. (5% marks)
- Share the SQL file in the submission folder as well. (5% marks)

## Bonus Features:
- Apply Bootstrap version 5 in the Frontend Vue app. (+10% marks)
- Share source codes of the frontend and backend via GitHub/GitLab. (+10% marks)
- Create a README file to understand how to install and execute frontend and backend codebase. (+15% marks)

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/GaafarDev/LabTest3-AbdalaGaafar.git
    ```

2. Navigate into the project directory:
    ```bash
    cd LabTest3-AbdalaGaafar
    ```

### Backend Installation and Setup

1. Navigate to the backend folder:
    ```bash
    cd backend
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Set up your database configuration in `backend/src/settings.php`.

4. Import the SQL file `database.sql` into your MySQL database.

5. Start the backend server:
    ```bash
    php -S localhost:8080 -t public
    ```

### Frontend Installation and Setup

1. Navigate to the frontend folder:
    ```bash
    cd frontend
    ```

2. Install dependencies:
    ```bash
    npm install
    ```

3. Start the frontend development server:
    ```bash
    npm run serve
    ```

4. Open your browser and go to `http://localhost:8081`.

## Project Structure

- `backend/`: Backend folder.
  - `public/`: Publicly accessible files.
  - `src/`: Backend source files including Slim routes and controllers.
  - `database.sql`: SQL file for database setup.

- `frontend/`: Frontend folder.
  - `src/`: Vue.js source files.
    - `components/`: Vue components.
    - `store.js`: Vuex store configuration.
    - `router.js`: Vue Router configuration.
    - `views/`: Vue components for different views.
  - `public/`: Public assets.
  - `README.md`: Instructions and details about the frontend setup.

## Components and Routing

- Frontend components and routing configured as per lab test requirements.

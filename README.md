# Time Tracker - Sprint 1: Initial Setup & Authentication

## Overview

Sprint 1 focuses on laying the foundational elements of the **Time Tracker** application. The primary objectives were to set up the initial Laravel project, implement user authentication, and establish role-based access control (RBAC). This sprint ensures that the application has a solid base for further feature development in subsequent sprints.

## Objectives

- **Initial Project Setup**: Create a new Laravel project using Laravel 10.
- **Version Control Integration**: Push the basic project structure to GitHub for version tracking and collaboration.
- **Authentication Implementation**: Utilize Laravel Breeze to set up authentication components.
- **Database Configuration**: Integrate SQLite as the database and perform initial migrations.
- **Role-Based Access Control (RBAC)**: Establish roles for Administrators, Managers, and Team Members.
- **User Management**: Create CRUD functionalities for managing user accounts.
- **Styling and Layout**: Implement basic styling using Tailwind CSS to ensure a clean and office-friendly interface.

## Accomplishments

### 1. Initial Project Setup

- **Laravel Installation**:
    ```bash
    composer create-project laravel/laravel staff-tracker "10.*"
    ```

- **Version Control**: Pushed the raw project structure to GitHub to maintain a clean starting point.

### 2. Authentication with Laravel Breeze

- **Installation of Laravel Breeze**:
    ```bash
    composer require laravel/breeze --dev
    php artisan breeze:install
    npm install 
    ```

- **Authentication Features**: Enabled immediate access to login and registration components provided by Breeze.

### 3. Database Integration

- **SQLite Configuration**:
    - Modified the `.env` file to use SQLite:
        ```bash
        DB_CONNECTION=sqlite
        DB_DATABASE=database.sqlite
        ```

- **Database Migration**:
    ```bash
    php artisan migrate
    ```

    *Note*: Encountered an issue where the `database.sqlite` file needed to be moved to the `./database` directory for user registration to function correctly. This is documented for future reference.

### 4. Role-Based Access Control (RBAC)

- **Migration for User Roles**:
    ```bash
    php artisan make:migration add_role_to_users_table --table=users
    ```

- **Middleware Creation**:
    ```bash
    php artisan make:middleware CheckRole
    ```

    - **CheckRole Middleware**: Handles role verification to restrict access based on user roles.

- **Password Change Mechanism**:
    - **Migration**:
        ```bash
        php artisan make:migration add_password_changed_at_to_users_table --table=users
        ```
    - **Middleware**:
        ```bash
        php artisan make:middleware CheckPasswordChanged
        ```

### 5. Controllers and Routes

- **Controller Generation**:
    ```bash
    php artisan make:controller PasswordChangeController
    php artisan make:controller AdminController
    php artisan make:controller ManagerController
    php artisan make:controller TimesheetController
    php artisan make:controller Admin/UserController --resource
    ```

- **Routes Configuration**: Organized routes with appropriate middleware and grouping for public, authentication, and protected routes.

### 6. User Management

- **AdminUserSeeder**:
    ```bash
    php artisan make:seeder AdminUserSeeder
    php artisan db:seed --class=AdminUserSeeder
    ```

    - Created an initial admin user to manage the application.

### 7. Styling and Layout

- **Tailwind CSS Integration**: Configured Tailwind for styling and extended it with custom elements like cards and buttons.

    ```css
    module.exports = {
        darkMode: 'class', // Enable dark mode
        content: [
          './resources/**/*.blade.php',
          './resources/**/*.js',
          './resources/**/*.vue',
        ],
        theme: {
          extend: {
            fontFamily: {
              sans: ['Inter', 'sans-serif'],
            },
            colors: {
              primary: {
                light: '#3b82f6', // Blue-500
                DEFAULT: '#1d4ed8', // Blue-700
                dark: '#1e40af', // Blue-800
              },
              secondary: {
                light: '#6b7280', // Gray-500
                DEFAULT: '#4b5563', // Gray-600
                dark: '#374151', // Gray-700
              },
            },
            spacing: {
              '128': '32rem',
              '144': '36rem',
            },
          },
        },
        plugins: [],
      }
    ```

- **Custom Components**: Created reusable Blade components for buttons and links to maintain consistency across the application.

### 8. Removing Self-Registration

- **Disabling Registration Routes**: Commented out registration routes in `./routes/auth.php` to prevent users from signing up independently, ensuring only administrators can create user accounts.

    ```php
    // use App\Http\Controllers\Auth\RegisteredUserController; // Commented out

    // Comment out the registration routes
    // Route::get('/register', [RegisteredUserController::class, 'create'])
    //             ->middleware('guest')
    //             ->name('register');

    // Route::post('/register', [RegisteredUserController::class, 'store'])
    //             ->middleware('guest');
    ```

## Next Steps

With Sprint 1 completed, the project is now equipped with essential authentication and user management features. Moving forward, the next sprint will focus on:

- **Timesheet Functionality**: Implementing CRUD operations for timesheets.
- **Approval Workflows**: Enabling managers to approve or reject submitted timesheets.
- **Enhanced RBAC**: Refining roles and permissions for more granular control.
- **User Interface Improvements**: Enhancing the UI for better user experience.

## Further Information

For a detailed walkthrough of Sprint 1, please refer to my [blog post](https://onemoredavid.com/blog/2024-12-07-time-tracker-initial-setup).

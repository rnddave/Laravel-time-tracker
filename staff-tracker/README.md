# Time Tracker

## Overview

**Time Tracker** is a comprehensive timesheet system built with Laravel, designed to streamline time tracking, enhance productivity, and facilitate efficient project management within organisations. This application allows users to create, submit, and manage timesheets, while providing administrators and managers with robust tools for oversight and approval processes.

## Features

- **User Authentication & Authorisation**: Secure login and registration system with role-based access control (RBAC).
- **Timesheet Management**: Create, read, update, and delete (CRUD) timesheets with ease.
- **Role-Based Access Control**: Different permissions for Administrators, Managers, and Team Members.
- **Responsive Design**: Clean and office-friendly interface built with Tailwind CSS.
- **Database Integration**: Utilises SQLite for lightweight and efficient data management.
- **Version Control**: Initial project structure and ongoing development managed via GitHub.

## Technologies Used

- **Laravel 10**: PHP framework for building robust web applications.
- **PHP**: Server-side scripting language.
- **Blade**: Laravel's templating engine for creating dynamic views.
- **SQLite**: Lightweight, file-based database system.
- **Tailwind CSS**: Utility-first CSS framework for rapid UI development.
- **Laravel Breeze**: Minimal and simple authentication scaffolding for Laravel.
- **Composer**: Dependency management tool for PHP.
- **Artisan**: Laravel’s command-line interface for managing the application.
- **GitHub**: Platform for version control and collaboration.

## Installation

1. **Clone the Repository**
    ```bash
    git clone https://github.com/rnddave/Laravel-time-tracker.git
    cd staff-tracker
    ```

2. **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3. **Set Up Environment Variables**
    - Duplicate the `.env.example` file and rename it to `.env`.
    - Configure your database settings in the `.env` file.

4. **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5. **Run Migrations and Seeders**
    ```bash
    php artisan migrate --seed
    ```

6. **Start the Development Server**
    ```bash
    php artisan serve
    ```

7. **Access the Application**
    - Open your browser and navigate to `http://localhost:8000`.

## Usage

- **Administrators** can manage user accounts, assign roles, and oversee timesheet approvals.
- **Managers** can approve or reject timesheets submitted by team members.
- **Team Members** can create and submit their own timesheets for approval.

## Contributing

Contributions are welcome! Please follow these steps:

1. **Fork the Repository**
2. **Create a Feature Branch**
    ```bash
    git checkout -b feature/YourFeatureName
    ```
3. **Commit Your Changes**
    ```bash
    git commit -m "Add some feature"
    ```
4. **Push to the Branch**
    ```bash
    git push origin feature/YourFeatureName
    ```
5. **Open a Pull Request**

## License

This project is licensed under the [GPLv3 License](LICENSE).

## Further Information

For a detailed walkthrough of the initial setup and authentication process, please refer to my [blog post](https://onemoredavid.com/blog/2024-12-07-time-tracker-initial-setup).


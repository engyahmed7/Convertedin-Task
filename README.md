# Laravel Task Management Application

## Overview

This is a Laravel-based task management application that allows admins to create tasks, assign them to users, and view task statistics. It includes functionality for task creation, task listing, and viewing statistics. Additionally, the application features automated testing and background job processing with built-in authentication and authorization.

## Features

- **Task Creation**: Admins can create tasks and assign them to users.
- **Task Listing**: Users and admins can view a list of tasks. Admins see all tasks, while users see only their assigned tasks.
- **Task Statistics**: Admins can view various statistics related to tasks.
- **Authentication & Authorization**: 
  - Admins and users have separate authentication guards.
  - Admins can access task management routes, while users can only access their tasks and profile.

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- MySQL
- Composer

### Installation

1. **Clone the Repository**

    ```bash
    git clone https://github.com/engyahmed7/Convertedin-Task.git
    cd Convertedin-Task
    ```

2. **Install Composer Dependencies**

    ```bash
    composer install
    ```

### Running the Application

To start the application, use the following command:

```bash
php artisan serve
```

### Database Migration

Run the migrations to create the database tables:

```bash
php artisan migrate
```

### Database Seeding

Seed the database with initial data:

```bash
php artisan db:seed --class=UsersTableSeeder
php artisan db:seed --class=AdminsTableSeeder
```

### Authentication Setup

The application uses Laravel Breeze for authentication. To set it up, follow these steps:

1. **Install Laravel Breeze**

    ```bash
    composer require laravel/breeze --dev
    php artisan breeze:install
    npm install && npm run dev
    ```

2. **Run Migrations**

    ```bash
    php artisan migrate
    ```

3. **Set Up Authentication**

    - Admin and user guards are set up in `config/auth.php`.
    - Admin routes use the `auth:admin` middleware.
    - User routes use the `auth:web` middleware.

### Testing

Run the tests to ensure everything is working correctly:

```bash
php artisan test
```

### GitHub Actions

The application uses GitHub Actions to confirm that tests run successfully after each commit. The configuration file for GitHub Actions is located in `.github/workflows/laravel.yml`.

### Bonus Features

1. **One Running Command**: To start the application, use `php artisan app:start`.

2. **GitHub Actions Integration**: The GitHub Actions workflow is configured to run tests automatically after each commit. This helps ensure that your application remains functional and that any issues are caught early.

3. **Update Statistics Table Using Background Job**:
    - A background job is set up to update the statistics table. 
    - To configure the background job, make sure you have a queue driver configured in your `.env` file and that your queue worker is running. For example, you can run the following command to start the queue worker:

      ```bash
      php artisan queue:work
      ```

4. **Authorization**:
    - Admins can access all task management routes.
    - Users can only access their assigned tasks and their profile.


## Video Demo

Explore a comprehensive demonstration of the Scentence E-Commerce in action via the following video:

[![Task Management Application Demo]](https://www.youtube.com/watch?v=KMaNQDfokpg)


## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes.

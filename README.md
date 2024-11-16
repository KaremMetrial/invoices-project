# Invoices Project

This repository contains the solution for an invoice management system built using Laravel. The project includes features for creating, updating, deleting, and managing invoices, as well as exporting data, sending emails, handling attachments, and managing permissions.

## Requirements

Before you start, ensure you have the following installed on your machine:

- PHP (>= 7.4)
- Composer
- Laravel (latest version)
- MySQL (or other database)

## Installation

Follow the steps below to set up and run the project locally:

1. Clone the repository:

    ```bash
    git clone https://github.com/KaremMetrial/invoices-project
    ```

2. Navigate into the project directory:

    ```bash
    cd invoices-project
    ```

3. Install the dependencies:

    ```bash
    composer install
    ```

4. Create a `.env` file from the `.env.example`:

    ```bash
    cp .env.example .env
    ```

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Set up your database configuration in the `.env` file:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

7. Run the database migrations and seeders:

    ```bash
    php artisan db:seed --class=PermissionTableSeeder
    php artisan db:seed --class=CreateAdminUserSeeder
    ```

8. Serve the application:

    ```bash
    php artisan serve
    ```

Your application should now be accessible at `http://localhost:8000`.

## Features Implemented

### Section 1: Invoice Management
- **Create, Edit, Delete Invoices**: Full CRUD functionality for invoices.
- **Export to Excel**: Export invoices to an Excel file.
- **Send Invoice Mail**: Automatically send invoice emails to customers.
- **Print Invoices**: Print invoices directly from the system.
- **Restore Archive**: Restore archived invoices when necessary.
- **Archive Invoices**: Ability to archive invoices.

### Section 2: Database Management
- **Invoices Table**: Includes details about invoices such as invoice number, amount, and due date.
- **Attachments**: Manage invoice attachments with functionality for adding and deleting.
- **Payment Status**: Update the payment status of invoices.

### Section 3: Relationships & Permissions
- **Invoice Details & Attachments**: Manage and display invoice details and attachments.
- **Invoice Relations**: Established relationships between invoices and related entities.
- **Spatie Permission**: Integrated the Spatie Permission package for managing user roles and permissions.

### Section 4: Authentication & Authorization
- **User Authentication**: Secure login and user registration functionality.
- **Role-Based Access Control**: Implemented role-based access to control user permissions (e.g., for creating or deleting invoices).


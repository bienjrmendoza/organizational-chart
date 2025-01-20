# Setting Up and Running the Organizational Chart API

---

## Prerequisites

Ensure to have the following installed:

1. **PHP** (version 8.1 or later)
2. **Composer** (PHP package manager)
3. **MySQL** or any other database of your choice
4. A code editor (e.g., VS Code, PHPStorm)

---

## Installation Steps

### 1. Clone the Repository

Clone the project repository from version control:

```bash
git clone https://github.com/bienjrmendoza/organizational-chart.git
```

Navigate into the project directory:

```bash
cd api-project
```

### 2. Install Dependencies

Install PHP dependencies using Composer:

```bash
composer install
```

### 3. Configure the Environment

Create a table in your mysql.

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Update the `.env` file with your environment-specific settings, such as database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Generate the application key:

```bash
php artisan key:generate
```

Run migrations:

```bash
php artisan migrate
```

### 4. Start the Server

To run the development server:

```bash
php artisan serve
```

The application will be available at:

```plaintext
http://localhost:8000 or http://127.0.0.1:8000/
```

---

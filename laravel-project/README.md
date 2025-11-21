# Event & Organization Registration App

A web-based application built with Laravel that provides a complete system for managing event registrations, organization registrations, user profiles, and role-based dashboards. This project was developed as part of a university assignment (UTS), demonstrating backend development skills using Laravel, MVC architecture, and database-driven workflows.

---

## 🚀 Features

### 🔐 Authentication
- Login with email & password  
- Google OAuth Login  
- Multi-role system (Mahasiswa, Admin, Superadmin)

### 🧑‍🎓 Mahasiswa (Student)
- Edit user profile  
- Multi-step **organization registration**
  - Step 1: Personal data  
  - Step 2: Choose organization  
  - Step 3: Motivation  
  - Step 4: Confirmation  
- Multi-step **volunteer registration**
  - Step 1: Personal data  
  - Step 2: Select event  
  - Step 3: Motivation  
  - Step 4: Confirmation  

### 🧑‍🏫 Admin
- Manage events  
- View volunteer or organization registrations  
- Access admin dashboard interface  

### 🛠️ Superadmin
- Manage admin accounts  
- Manage organizations  
- View system-wide dashboard  
- Administrative CRUD controls

---

## 🗄️ Database Structure

The system uses Laravel migrations to manage the database.  
Main tables include:

- `users`  
- `user_profiles`  
- `events`  
- `organizations`  
- `volunteer_registrations`  
- `organization_registrations`

---

## 🧰 Tech Stack

- **Laravel**  
- **PHP 8+**  
- **MySQL**  
- **Blade Template Engine**  
- **Composer**  
- **MVC Architecture**

---

## 📦 Installation Guide

1. Clone this repository:
   ```bash
   git clone https://github.com/ErickDervianto/my-Project
   ```

2. Navigate to the project folder:
   ```bash
    cd my-Project/laravel-project
   ```

3. install dependencies:
   ```bash
   composer install
   ```

4. create a .env file:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Set up your database in .env:
   ```bash
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

7. Run Migration:
   ```bash
   php artisan migrate
   ```

8. Start development server:
   ```bash
   php artisan serve
   ```

### 📘 Purpose of the Project

This application was developed as part of a university mid-semester assignment (UTS) to practice backend development using Laravel.
It focuses on:
- user authentication
- multi-step form handling
- database migrations
- controller–view architecture
- role-based access logic


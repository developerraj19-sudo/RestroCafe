# RestroCafe — Complete Running Guide

Welcome to the RestroCafe project! This document outlines the step-by-step instructions to set up, configure, and run the complete Restaurant Management System.

## 🛠️ System Requirements

- **Operating System:** Windows (Using XAMPP)
- **Web Server:** Apache
- **Database:** MySQL
- **PHP Version:** PHP 7.4 or PHP 8.x
- **Third-Party Libraries:** [FPDF](http://www.fpdf.org/) (for generating receipt PDFs)

---

## 🚀 Step 1: Environment Setup

1. **Install XAMPP:**
   Make sure XAMPP is installed on your Windows machine, typically in `D:\XAMPP\` or `C:\xampp\`.
2. **Project Location:**
   Ensure this entire `RestroCafe` folder is placed in your XAMPP web root directory:
   `D:\XAMPP\htdocs\RestroCafe\`
3. **Start Servers:**
   Open the XAMPP Control Panel and start both **Apache** and **MySQL**.

---

## 📄 Step 2: FPDF Dependency Installation

The application requires the FPDF library to generate bill receipts in the Admin Panel. 

1. Download the latest version of FPDF from [fpdf.org](http://www.fpdf.org/).
2. Extract the downloaded folder.
3. Place the extracted folder into the `htdocs` directory alongside the RestroCafe project, making sure the main file is located at exactly:
   `D:\XAMPP\htdocs\FPDF\fpdf.php`

*(If your XAMPP is installed on the `C:` drive or FPDF is placed elsewhere, you'll need to update the require path in `src/Controllers/AdminController.php` under the `bill()` method).*

---

## 🗄️ Step 3: Database Setup

1. Open your web browser and go to PHPMyAdmin: `http://localhost/phpmyadmin/`
2. Create a new database named `restrocafe`.
3. Import the database schema:
   - Click on the newly created `restrocafe` database.
   - Go to the **Import** tab.
   - Choose the SQL file (if you have an exported `restrocafe.sql` dump) and click **Go**.
   - *(Note: Ensure tables like `tbl_emp`, `tbl_items`, `tbl_orders`, and `tbl_user` are successfully created).*

---

## ⚙️ Step 4: Configuration

The database connection details are managed centrally.

1. Open `config/config.php` in a text editor.
2. Verify the database credentials match your XAMPP MySQL setup (default XAMPP setup usually has user `root` with no password):
   ```php
   define('DB_SERVER', "localhost"); 
   define('DB_USER', "root"); 
   define('DB_DATABASE', 'restrocafe'); 
   define('DB_PASSWORD', ""); // Leave empty if no password is set
   ```

---

## 🌐 Step 5: Running the Application

Once setup is complete, you can access the two main interfaces of the application via your web browser:

### 1. Customer Interface (Digital Menu & Ordering)
- **URL:** `http://localhost/RestroCafe/`
- **Features:** Customers can enter their name and table number to view the digital menu, add items to their cart, and place orders directly to the kitchen.

### 2. Admin Panel (Dashboard & Management)
- **URL:** `http://localhost/RestroCafe/admin/login`
- **Default Login Credentials:**
  - **Username:** `admin`
  - **Password:** `admin123` *(Check the `tbl_emp` table for the correct hashed password if you have reset it).*
- **Features:** The admin can view live pending orders, mark orders as finished, generate printable PDF bills, and archive closed tables to clear the dashboard.

---

## 💡 Troubleshooting & Notes

- **"Table not clearing from Dashboard":** If you click "Clear" and get sent to the login page, your Admin session has expired. Simply log back in and try again.
- **Browser Caching:** The Admin dashboard pages are designed to prevent browser caching so data stays live. If you see outdated data, do a hard refresh (`Ctrl + F5`).
- **404 Errors on URLs:** The project uses a Front Controller routing pattern via `.htaccess`. Ensure that the Apache `mod_rewrite` module is enabled in your `httpd.conf` if you experience routing issues.

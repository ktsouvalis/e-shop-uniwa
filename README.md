# E-Shop Project

## 📖 Overview
This project is an e-shop designed as part of my MSc coursework. The application provides essential e-commerce features like adding items to a cart, updating cart contents, expiring cart items, updating stock, submitting orders. It serves as a foundational platform for understanding web development and e-commerce principles.

---

## 🛠️ Features
- **Product Listing**: Display available products with details.
- **Add to Cart**: Users can add products to their cart with a simple and intuitive interface.
- **Submit Orders**: Secure and efficient order processing workflow.
- **Responsive Design**: Optimized for both desktop and mobile users.
- **Mock Data**: Includes sample product images and data for demonstration.

---

## 🚀 Technologies Used
- **Backend**: [Laravel 11](https://laravel.com/) (PHP framework)
- **Frontend**: Bootstrap CSS, Laravel Blade
- **Database**: SQLite for data persistence

---

## 🖥️ Setup and Installation
### Prerequisites
- PHP >= 8.2
- Composer
(Ensure to enable curl, fileinfo, gd, imap, mbstring, exif, pdo_sqlite, sqlite3, zip extensions in your php.ini file)

### Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/ktsouvalis/e-shop-uniwa.git
   cd e-shop-uniwa
   ```
2. Install Dependencies:
   ```bash
   composer install
   ```
3. Setup Environment Variables
   ```bash
   cp .env.example .env
   cp /database/e_shop_uniwa.sqlite.example e_shop_uniwa.sqlite
   ```
   Inside your .env file set:
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=YOUR_FULL_PATH_TO_DATABASE_FILE # e.g. C:\users\user\Desktop\e-shop-uniwa\database\e_shop_uniwa.sqlite
   ```
4. Generate app key
   ```bash
   php artisan key:generate
   ```
5. Run migrations and seeders
   ```bash
   php artisan migrate --seed
   ```
6. Start application server
   ```bash
   php artisan serve
   ```

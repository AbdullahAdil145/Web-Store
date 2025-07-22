
# 🛒 Online Computer Store

A web-based platform to browse, search, and purchase computer products. Built using PHP, MySQL, HTML, CSS (Bootstrap), and JavaScript.

---

## 📋 Project Description

This is a full-stack web application that allows:
- Users to browse products, search/filter by category, view product details, add to cart, place orders, and view their order history.
- Admins to manage products, view all orders placed, and view all registered users.

---

## 🚀 Features

### User Functions
- User registration and login/logout.
- Browse products by category and search by name.
- View product details directly on the product page.
- Add/remove products from cart.
- Checkout and place orders.
- View personal order history.

### Admin Functions
- Admin login with session-based access.
- Add/edit/delete products.
- View all user orders.
- View all registered users.
- Manage stock automatically after orders.

---

## 🎨 Non-Functional Features
- Responsive design using Bootstrap.
- Server-side validation using PHP.
- Passwords securely hashed using password_hash().
- SQL Injection protection using prepared statements.
- Clean, user-friendly admin and customer interface.

---

## 💡 Optional Features Included
- Product search and filter by category.
- Inventory auto-update after orders.
- Session-based login and cart state.
- Admin view of all orders site-wide.
- Admin view of all registered users.

---

## 🛠 Technologies Used

| Technology      | Purpose                         |
|-----------------|---------------------------------|
| HTML5           | Page structure                  |
| CSS / Bootstrap | Styling and layout              |
| PHP             | Server-side backend             |
| MySQL           | Database backend                |
| phpMyAdmin      | Database management             |
| XAMPP / LAMP    | Local server environment        |
| JavaScript      | Basic form validation           |

---

## 🗄️ Database Structure

### Tables:
- **users** (`id`, `name`, `email`, `password`, `is_admin`)
- **products** (`id`, `name`, `description`, `price`, `image_url`, `category`, `stock`)
- **orders** (`id`, `user_id`, `total_price`, `order_date`)
- **order_items** (`id`, `order_id`, `product_id`, `quantity`, `price`)

---

## 📂 Project Structure

```
/images/                        # Product images
/online_computer_store/admin/   # Admin-only pages
    dashboard.php
    admin_users.php
/config.php                     # Database connection
/index.php                      # Main homepage
/products.php                   # Product browsing
/cart.php                       # Shopping cart
/checkout.php                   # Checkout page
/order_history.php              # User orders
/order_details.php              # Order item details
/login.php                      # User login
/register.php                   # User registration
/style.css                      # Custom styles
```

---

## 📦 Setup Instructions

1. Install XAMPP or LAMP.
2. Place the project folder inside:
   ```
   C:\xampp\htdocs\Online-Computer-Store
   ```
3. Start Apache and MySQL via XAMPP Control Panel.
4. Access phpMyAdmin and import the provided SQL file:
   ```
   database.sql
   ```
   (Ensure database charset is set to `utf8mb4_general_ci`.)

5. Place your product images inside the `/images/` folder. Ensure image URLs in the database reference:
   ```
   images/product1.jpg
   ```

6. Update `/config.php` with your database credentials if needed.

7. Access the site:
   ```
   http://localhost/Online-Computer-Store/index.php
   ```

---

## 🔑 Default Admin Access

- **Email:** (Use any admin email in your database with `is_admin` = 1)
- **Password:** Set when inserting user manually via SQL or registration.

Example SQL to create an admin:
```
INSERT INTO users (name, email, password, is_admin)
VALUES ('Admin User', 'admin@example.com', '<hashed_password>', 1);
```

Use hash.php to generate the hashed password.

- **Admin Email:** admin@example.com
- **Admin Password:** admin123


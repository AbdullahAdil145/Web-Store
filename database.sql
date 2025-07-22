
-- Database: online_computer_store

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    category VARCHAR(255) DEFAULT 'Accessories',
    stock INT NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Optional Sample Admin User (password must be replaced with actual hash)
INSERT INTO users (name, email, password, is_admin)
VALUES ('Admin User', 'admin@example.com', '$2y$10$EXAMPLEHASHEDPASSWORDSTRING', 1);

-- Sample Products (21 items)
INSERT INTO products (name, description, price, image_url, category, stock) VALUES
('Gaming Mouse', 'High precision gaming mouse', 25.99, 'images/product1.jpg', 'Accessories', 50),
('Mechanical Keyboard', 'RGB backlit mechanical keyboard', 59.99, 'images/product2.jpg', 'Accessories', 40),
('27 Inch Monitor', 'Full HD 27 inch monitor', 199.99, 'images/product3.jpg', 'Monitors', 25),
('Laptop Stand', 'Ergonomic aluminum laptop stand', 34.99, 'images/product4.jpg', 'Accessories', 60),
('External Hard Drive 1TB', 'Portable 1TB external drive', 79.99, 'images/product5.jpg', 'Storage', 35),
('USB-C Hub', '5-in-1 USB-C hub', 22.99, 'images/product6.jpg', 'Accessories', 70),
('Wireless Keyboard', 'Slim wireless keyboard', 29.99, 'images/product7.jpg', 'Accessories', 45),
('Wireless Mouse', 'Ergonomic wireless mouse', 18.99, 'images/product8.jpg', 'Accessories', 50),
('Gaming Headset', 'Surround sound gaming headset', 49.99, 'images/product9.jpg', 'Accessories', 30),
('Laptop Bag', 'Waterproof laptop bag', 39.99, 'images/product10.jpg', 'Accessories', 55),
('SSD 512GB', '512GB solid state drive', 69.99, 'images/product11.jpg', 'Storage', 40),
('WiFi Router', 'Dual-band WiFi router', 59.99, 'images/product12.jpg', 'Networking', 20),
('Graphics Card GTX 1660', 'Mid-range graphics card', 249.99, 'images/product13.jpg', 'Accessories', 15),
('Intel i5 Processor', '10th Gen Intel i5 CPU', 199.99, 'images/product14.jpg', 'Accessories', 20),
('16GB RAM Kit', '16GB DDR4 RAM kit', 89.99, 'images/product15.jpg', 'Accessories', 35),
('Computer Desk', 'Spacious computer desk', 149.99, 'images/product16.jpg', 'Accessories', 10),
('Gaming Chair', 'Comfortable gaming chair', 179.99, 'images/product17.jpg', 'Accessories', 10),
('PC Case', 'Tempered glass mid-tower case', 89.99, 'images/product18.jpg', 'Accessories', 15),
('Power Supply 650W', '650W certified power supply', 69.99, 'images/product19.jpg', 'Accessories', 25),
('Webcam', 'HD 1080p webcam', 49.99, 'images/product20.jpg', 'Accessories', 30),
('Microphone', 'USB condenser microphone', 59.99, 'images/product21.jpg', 'Accessories', 30);

-- MySQL schema for DavesList
-- Run this in phpMyAdmin or MySQL

CREATE DATABASE IF NOT EXISTS daveslist CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE daveslist;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(100) NOT NULL,
    uEmail VARCHAR(255) NOT NULL UNIQUE,
    uPassword VARCHAR(255) NOT NULL,
    uRole ENUM('admin', 'seller', 'buyer') NOT NULL DEFAULT 'buyer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS addbooks (
    book_Id INT AUTO_INCREMENT PRIMARY KEY,
    bookName VARCHAR(255) NOT NULL,
    bookPrice DECIMAL(10,2) NOT NULL,
    bookImage VARCHAR(255) DEFAULT NULL,
    Category VARCHAR(100) NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_addbooks_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_addbooks_user (user_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    seller_id INT NOT NULL,
    book_id INT NOT NULL,
    book_name VARCHAR(255) NOT NULL,
    book_price DECIMAL(10,2) NOT NULL,
    qty INT NOT NULL DEFAULT 1,
    total DECIMAL(10,2) NOT NULL,
    image_path VARCHAR(255) DEFAULT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Pending',
    payment_id VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_buyer FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_orders_seller FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_orders_book FOREIGN KEY (book_id) REFERENCES addbooks(book_Id) ON DELETE CASCADE,
    INDEX idx_orders_buyer (buyer_id),
    INDEX idx_orders_seller (seller_id),
    INDEX idx_orders_status (status)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS flagged_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_Id INT NOT NULL,
    user_id INT NOT NULL,
    bookName VARCHAR(255) NOT NULL,
    bookImage VARCHAR(255) NOT NULL,
    flagged_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_flag (book_Id, user_id),
    CONSTRAINT fk_flagged_book FOREIGN KEY (book_Id) REFERENCES addbooks(book_Id) ON DELETE CASCADE,
    CONSTRAINT fk_flagged_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

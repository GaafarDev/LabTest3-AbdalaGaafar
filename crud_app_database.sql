-- Create database
CREATE DATABASE IF NOT EXISTS crud_app;

-- Use the created database
USE crud_app;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert initial data
INSERT INTO users (name, email, phone) VALUES
('Gaafar', 'Gaafar@example.com', '1234567890'),
('Abdalla', 'Abdalla@example.com', '0987654321'),
('Ahmed', 'Ahmed@example.com', '1122334455');

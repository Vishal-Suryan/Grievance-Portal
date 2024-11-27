# Grievance-Portal
A Grievance Portal designed to streamline the process of submitting and managing user grievances. This web-based application allows users to register, log in, and submit their grievances, while also enabling administrators to track and manage complaints efficiently.

Features
User Registration and Login: Secure user authentication.
Post Grievances: Users can submit grievances with details like subject and description.
View User Grievances: Display grievances submitted by the logged-in user.
All Grievances: A list of grievances from all users, including status tracking (e.g., Pending, Resolved)
Responsive Design: Clean and modern UI for desktops and mobile devices.
Technologies Used
Frontend: HTML, CSS, and Bootstrap for styling.
Backend: PHP for server-side logic.
Database: MySQL for storing user data and grievances.
This project demonstrates a practical implementation of CRUD operations and user session management, making it ideal for learning and expanding.


# Grievance Portal Database Design

Below is the MySQL script used to create the database schema for the Grievance Portal.

```sql
-- Create the database
CREATE DATABASE IF NOT EXISTS grievance_portal;
USE grievance_portal;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the grievances table
CREATE TABLE IF NOT EXISTS grievances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending', -- Status field to track grievance status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert sample users
INSERT INTO users (name, email, password) VALUES 
('John Doe', 'john@example.com', 'hashed_password_1'),
('Jane Smith', 'jane@example.com', 'hashed_password_2');

-- Insert sample grievances
INSERT INTO grievances (user_id, subject, description, status) VALUES
(1, 'Road Repair Needed', 'There is a large pothole in front of my house.', 'Pending'),
(2, 'Power Outage', 'Power has been out in my area for 24 hours.', 'Resolved');





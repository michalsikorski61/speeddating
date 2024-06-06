CREATE DATABASE speeddating;

USE speeddating;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(15),
    event_id INT
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    city VARCHAR(255)
);

CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user1_id INT,
    user2_id INT
);

ALTER TABLE users ADD COLUMN password VARCHAR(255);

CREATE TABLE choices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    choice_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (choice_id) REFERENCES users(id)
);

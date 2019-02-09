CREATE DATABASE IF NOT EXISTS yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR
);

CREATE TABLE lot (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR,
  category_id INT,
  author_id INT,
  description CHAR,
  image TEXT,
  start_cost INT NOT NULL,
  final_date TIMESTAMP,
  bet_step INT,
  winner_id INT
);

CREATE TABLE bet (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bet_date TIMESTAMP,
  amount_to_buy INT,
  user_id INT,
  lot_id INT
);

CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  registrated_date DATE,
  email CHAR NOT NULL UNIQUE,
  name CHAR NOT NULL UNIQUE,
  password CHAR NOT NULL UNIQUE,
  avatar TEXT,
  contact TEXT,
  lot_id INT,
  bet_id INT
);

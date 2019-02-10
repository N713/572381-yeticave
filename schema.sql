CREATE DATABASE IF NOT EXISTS yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128) NOT NULL
);

CREATE TABLE lot (
  id INT AUTO_INCREMENT PRIMARY KEY,
  time_of_create TIMESTAMP NOT NULL,
  name VARCHAR(128) NOT NULL,
  category_id INT NOT NULL,
  author_id INT NOT NULL,
  description TEXT(256) NOT NULL,
  image VARCHAR(128) NOT NULL,
  start_cost INT NOT NULL,
  final_date TIMESTAMP NOT NULL,
  bet_step INT NOT NULL,
  winner_id INT
);

CREATE INDEX lot_category_id ON lot(category_id);

CREATE TABLE bet (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bet_date TIMESTAMP NOT NULL,
  amount_to_buy INT NOT NULL,
  user_id INT NOT NULL,
  lot_id INT NOT NULL
);

CREATE INDEX bet_lot_id ON bet(lot_id);
CREATE INDEX bet_date_create ON bet(bet_date);

CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  registrated_date DATETIME NOT NULL,
  email VARCHAR(128) NOT NULL UNIQUE,
  name VARCHAR(128) NOT NULL UNIQUE,
  password VARCHAR(128) NOT NULL UNIQUE,
  avatar VARCHAR(128),
  contact TEXT NOT NULL
);

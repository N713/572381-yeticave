/*Добавляю категории*/
INSERT INTO category (name) VALUES ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');

/*Добавляю пользователей*/
INSERT INTO user (registrated_date, email, name, password, avatar, contact)
VALUES ('2019.02.10', 'volodyanumbaone@mail.ru', 'Владимир Диков', 'sexybeast4ever', 'https://imgur.com/gallery/PE3jkKt', '88611617141');
INSERT INTO user (registrated_date, email, name, password, avatar, contact)
VALUES ('2019.02.11', 'clairedelune@gmail.com', 'Сергей Сарко', 'mo2to5k01', 'https://cs4.pikabu.ru/images/big_size_comm/2015-04_3/14290467406259.jpg', '8812203020');

/*Добавляю объявления*/
INSERT INTO lot (time_of_create, name, category_id, author_id, description, image, start_cost, final_date, bet_step)
VALUES ('2019.02.01T10:17:43', '2014 Rossignol District Snowboard', '1', '1', 'Доска', 'img/lot-1.jpg', '10999', '2019.03.13T00:00:01', '1');
INSERT INTO lot (time_of_create, name, category_id, author_id, description, image, start_cost, final_date, bet_step)
VALUES ('2019.02.02T13:22:54', 'DC Ply Mens 2016/2017 Snowboard', '1', '2', 'Сноуборд', 'img/lot-2.jpg', '159999', '2019.03.13T00:00:01', '1');
INSERT INTO lot (time_of_create, name, category_id, author_id, description, image, start_cost, final_date, bet_step)
VALUES ('2019.02.03T11:03:55', 'Крепления Union Contact Pro 2015 года размер L/XL', '2', '3', 'Крепления', 'img/lot-3.jpg', '8000', '2019.03.13T00:00:01', '1');
INSERT INTO lot (time_of_create, name, category_id, author_id, description, image, start_cost, final_date, bet_step)
VALUES ('2019.02.04T10:07:13', 'Ботинки для сноуборда DC Mutiny Charocal', '3', '4', 'Ботинки', 'img/lot-4.jpg', '10999', '2019.03.13T00:00:01', '1');
INSERT INTO lot (time_of_create, name, category_id, author_id, description, image, start_cost, final_date, bet_step)
VALUES ('2019.02.05T17:30:31', 'Куртка для сноуборда DC Mutiny Charocal', '4', '5', 'Куртец', 'img/lot-5.jpg', '7500', '2019.03.13T00:00:01', '1');
INSERT INTO lot (time_of_create, name, category_id, author_id, description, image, start_cost, final_date, bet_step)
VALUES ('2019.02.06T19:47:59', 'Маска Oakley Canopy', '5', '6', 'Маска', 'img/lot-6.jpg', '5400', '2019.03.13T00:00:01', '1');

/*Добавляю ставки*/
INSERT INTO bet (bet_date, amount_to_buy, user_id, lot_id)
VALUES ('2019.01.03', '11000', '1', '3');
INSERT INTO bet (bet_date, amount_to_buy, user_id, lot_id)
VALUES ('2019.02.03', '15000', '2', '4');

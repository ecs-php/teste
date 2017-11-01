DROP TABLE IF EXISTS user;
CREATE TABLE user (id INTEGER PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), username VARCHAR(100), password VARCHAR(255), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP , updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);
INSERT INTO user (name, username, password) VALUES ('User', 'user', '16MPw8fXNKuLw');
DROP TABLE IF EXISTS penguin;
CREATE TABLE penguin (id INTEGER PRIMARY KEY AUTO_INCREMENT, name VARCHAR (255) NOT NULL, age INT, species VARCHAR(150), gender CHAR(1), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP , updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP );
INSERT INTO penguin (name, age, species, gender) VALUES ('Penguin 1', 25, 'yellow-eyed penguin', 'F');
INSERT INTO penguin (name, age, species, gender) VALUES ('Penguin 2', 27, 'king penguin', 'M');
INSERT INTO penguin (name, age, species, gender) VALUES ('Penguin 3', 15, 'emperor penguin', 'F');

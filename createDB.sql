drop database if exists demothuctap;
create database demothuctap;
use demothuctap;

CREATE TABLE demothuctap.users (
	user_id int NOT NULL AUTO_INCREMENT,
	name varchar(255) NOT NULL,
    gender enum('male','female') DEFAULT NULL,
	email varchar(50) NOT NULL UNIQUE,
	password varchar(50) NOT NULL,
	reset_token varchar(50) DEFAULT NULL,
	PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO users (name, email, password) 
VALUES 
	('admin', 'admin@gmail.com', '123456');
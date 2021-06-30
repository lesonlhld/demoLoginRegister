drop database if exists demoLoginRegister;
create database demoLoginRegister;
use demoLoginRegister;

CREATE TABLE demoLoginRegister.users (
	user_id int NOT NULL AUTO_INCREMENT,
	name varchar(255) NOT NULL,
    gender enum('male','female') DEFAULT NULL,
	email varchar(50) DEFAULT NULL UNIQUE,
	username varchar(50) NOT NULL,
	password varchar(50) NOT NULL,
	PRIMARY KEY (user_id),
	UNIQUE INDEX UQ_username (username ASC) VISIBLE /* ASC xếp tăng dần, UNIQUE username là giá trị duy nhât không trùng lặp */
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO users (name, username, password) 
VALUES 
	('admin', 'admin', '123456');
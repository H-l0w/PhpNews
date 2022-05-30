DROP DATABASE IF EXISTS news;

CREATE DATABASE news
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE roles(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE images(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name varchar(50),
    description varchar(20),
    path varchar(200)
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE users(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
	username VARCHAR(100),
    email VARCHAR(100),
    password varchar(200),
    id_role INT(6) UNSIGNED,
    id_image INT(6) UNSIGNED,
    description VARCHAR(500),
    CONSTRAINT fk_id_role FOREIGN KEY (id_role)
    REFERENCES roles(id),
    CONSTRAINT fk_id_image FOREIGN KEY (id_image)
    REFERENCES images(id)
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE categories(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name varchar(50),
    description VARCHAR(200),
    id_image INT(6) UNSIGNED,
    CONSTRAINT fk_id_image_categories FOREIGN KEY (id_image)
    REFERENCES images(id)
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE articles(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date datetime,
    id_author INT(6) UNSIGNED,
    title varchar(200),    
    text text,
    visible boolean,
	id_image INT(6) UNSIGNED,
    CONSTRAINT fk_id_image_articles FOREIGN KEY (id_image)
    REFERENCES images(id),
    CONSTRAINT fk_id_author FOREIGN KEY (id_author)
    REFERENCES users(id)
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE comments(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_article INT(6) UNSIGNED,
    name varchar(50),
    email varchar(100),
    text text,
    date DATETIME,
    CONSTRAINT fk_id_article FOREIGN KEY (id_article)
    REFERENCES articles(id) ON DELETE CASCADE   
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE category_assigns(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_category INT(6) UNSIGNED,
    id_article INT(6) UNSIGNED,
    CONSTRAINT fk_id_category_assign FOREIGN KEY (id_category)
    REFERENCES categories(id),
    CONSTRAINT fk_id_article_assign FOREIGN KEY (id_article)
    REFERENCES articles(id) ON DELETE CASCADE
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

INSERT INTO roles VALUES(DEFAULT, 'Administrator');
INSERT INTO roles VALUES(DEFAULT, 'Editor');
INSERT INTO images VALUES(DEFAULT, 'admin.png', 'Default admin profile image', 'Images/admin.png');
INSERT INTO users VALUES(DEFAULT, 'Admin', 'Admin', 'Admin', 'admin@admin.com', '$2y$10$.0FVBhBbzr66u/3tQ422yehij6j082TSUPhSUzHDzB7p6WNzwAgjq', 1,1, 'Default administrator user')
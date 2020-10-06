/* Make sure the database does not exist */
DROP DATABASE IF EXISTS SmileDatabase;

/* Creating the Database for the Website ubit*/
CREATE DATABASE SmileDatabase
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;


/* Make sure the user does not exist */
DROP USER IF EXISTS "smileUser"@"localhost";

/* Create a user on the server*/
CREATE USER "smileUser"@"localhost" IDENTIFIED BY "123smile";

/* Assign privileges to the user (still Add WITH MAX QUERIES PER HOUR)*/
GRANT SELECT, UPDATE, INSERT, DELETE
ON SmileDatabase.*
TO "smileUser"@"localhost" IDENTIFIED BY "123smile";


/*Create customers table*/
CREATE TABLE SmileDatabase.users
(
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(150) NOT NULL,
    email VARCHAR(200) NOT NULL,
    password VARCHAR(100) NOT NULL,
    start_date DATE NOT NULL
)
ENGINE = InnoDB;

CREATE TABLE SmileDatabase.admin
(
    admin_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(150) NOT NULL,
    institution VARCHAR(300) NOT NULL,
    department VARCHAR(300) NOT NULL,
    email VARCHAR(200) NOT NULL,
    password VARCHAR(100) NOT NULL
)
ENGINE = InnoDB;

CREATE TABLE SmileDatabase.category
(
    category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(200) NOT NULL,
    category_image_url VARCHAR(500) NOT NULL
)
ENGINE = InnoDB;


CREATE TABLE SmileDatabase.chapter
(
    chapter_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    FOREIGN KEY chapter_to_category(category_id)
    REFERENCES category(category_id),
    chapter_title VARCHAR(200) NOT NULL,
    chapter_number INT NOT NULL,
    chapter_image_url VARCHAR(500) NOT NULL
)
ENGINE = InnoDB;

CREATE TABLE SmileDatabase.content
(
    chapter_id INT NOT NULL PRIMARY KEY,
    FOREIGN KEY content_to_chapter(chapter_id)
    REFERENCES chapter(chapter_id),
    reading TEXT NOT NULL,
    reading_image_url VARCHAR(500) NOT NULL,
    video_url VARCHAR(500) NOT NULL,
    video_description TEXT NOT NULL

)
ENGINE = InnoDB;

CREATE TABLE SmileDatabase.quiz
(
    chapter_id INT NOT NULL PRIMARY KEY,
    FOREIGN KEY quiz_to_chapter(chapter_id)
    REFERENCES chapter(chapter_id),
    question1 TEXT NOT NULL,
    answer_1 TEXT NOT NULL,
    falseAnswer1_1 TEXT NOT NULL,
    falseAnswer1_2 TEXT NOT NULL,
    falseAnswer1_3 TEXT NOT NULL,
    question2 TEXT NOT NULL,
    answer_2 TEXT NOT NULL,
    falseAnswer2_1 TEXT NOT NULL,
    falseAnswer2_2 TEXT NOT NULL,
    falseAnswer2_3 TEXT NOT NULL,
    question3 TEXT NOT NULL,
    answer_3 TEXT NOT NULL,
    falseAnswer3_1 TEXT NOT NULL,
    falseAnswer3_2 TEXT NOT NULL,
    falseAnswer3_3 TEXT NOT NULL,
    question4 TEXT NOT NULL,
    answer_4 TEXT NOT NULL,
    falseAnswer4_1 TEXT NOT NULL,
    falseAnswer4_2 TEXT NOT NULL,
    falseAnswer4_3 TEXT NOT NULL,
    question5 TEXT NOT NULL,
    answer_5 TEXT NOT NULL,
    falseAnswer5_1 TEXT NOT NULL,
    falseAnswer5_2 TEXT NOT NULL,
    falseAnswer5_3 TEXT NOT NULL
)
ENGINE = InnoDB;

CREATE TABLE SmileDatabase.generalstats
(
    total_count_achieved_quiz_points INT NOT NULL,
    total_count_quiz_attempts INT NOT NULL,
    total_count_timer_usage INT NOT NULL,
    total_count_reading_accessed INT NOT NULL,
    total_count_videos_accessed INT NOT NULL
)
ENGINE = InnoDB;

CREATE TABLE SmileDatabase.selfdiagnosisstats
(
    total_count INT NOT NULL,
    total_count_message_A INT NOT NULL,
    Q1_count_message_A INT NOT NULL,
    Q2_count_message_A INT NOT NULL,
    Q4_count_message_A INT NOT NULL,
    Q5_count_message_A INT NOT NULL,
    Q6_count_message_A INT NOT NULL,
    Q7_count_message_C INT NOT NULL,
    Q8_count_message_D INT NOT NULL

)
ENGINE = InnoDB;

/*Inserting a root admin account (The password is "rootAdmin" and the username is "root.admin@smile.com") */
INSERT INTO SmileDatabase.admin (first_name, last_name, institution, department, email, password) VALUES ('RootAdmin', 'RootAdmin', 'Admin', 'Admin', 'root.admin@smile.com', '$2y$10$1uuQwVmui9W3j1XH/x6eUO22Y1FpV0oEdk7HkFcZQ9pd3G.gmznAG');

/*Inserting a root user account (The password is "rootUser" and the username is "root.user@smile.com") */
INSERT INTO SmileDatabase.users (first_name, last_name, email, password) VALUES ('RootUser', 'RootUser', 'root.user@smile.com', '$2y$10$q77jy5Jix.T6NpENRYScu.Z32Mdbbb.zAA9G1i3fvzpCVx9yzLV.K');

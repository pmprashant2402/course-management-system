CREATE DATABASE sage; CREATE TABLE `sage`.`students`(
    `id` INT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(20) NOT NULL,
    `last_name` VARCHAR(20) NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = INNODB; 

CREATE TABLE `sage`.`students_details`(
    `id` INT NULL AUTO_INCREMENT,
    `student_id` INT NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `date_of_birth` DATE NOT NULL,
    `contact_number` VARCHAR(15) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = INNODB;

CREATE TABLE `sage`.`course`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `details` MEDIUMTEXT NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = INNODB; 

CREATE TABLE `sage`.`assigned_courses`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `student_id` INT NOT NULL,
    `course_id` INT NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = INNODB;
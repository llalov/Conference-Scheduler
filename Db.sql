CREATE TABLE `conference_scheduler`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `username` NVARCHAR(45) NOT NULL COMMENT '',
  `password` NVARCHAR(45) NOT NULL COMMENT '',
  `email` NVARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '');
  
ALTER TABLE `conference_scheduler`.`users` 
ADD UNIQUE INDEX `username_UNIQUE` (`username` ASC)  COMMENT '',
ADD UNIQUE INDEX `email_UNIQUE` (`email` ASC)  COMMENT '';

CREATE TABLE `conference_scheduler`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `name` NVARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  UNIQUE INDEX `name_UNIQUE` (`name` ASC)  COMMENT '');

ALTER TABLE `conference_scheduler`.`users` 
ADD COLUMN `role_id` INT NOT NULL COMMENT '' AFTER `email`,
ADD INDEX `fk_role_id_idx` (`role_id` ASC)  COMMENT '';
ALTER TABLE `conference_scheduler`.`users` 
ADD CONSTRAINT `fk_role_id`
  FOREIGN KEY (`role_id`)
  REFERENCES `conference_scheduler`.`roles` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `conference_scheduler`.`roles` 
CHANGE COLUMN `name` `name` VARCHAR(45) NOT NULL DEFAULT 'user' COMMENT '' ;

INSERT INTO `conference_scheduler`.`roles` (`id`, `name`) VALUES ('1', 'user');

ALTER TABLE `conference_scheduler`.`users` 
DROP FOREIGN KEY `fk_role_id`;
ALTER TABLE `conference_scheduler`.`users` 
CHANGE COLUMN `role_id` `role_id` INT(11) NOT NULL DEFAULT 1 COMMENT '' ;
ALTER TABLE `conference_scheduler`.`users` 
ADD CONSTRAINT `fk_role_id`
  FOREIGN KEY (`role_id`)
  REFERENCES `conference_scheduler`.`roles` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `conference_scheduler`.`users` 
DROP FOREIGN KEY `fk_role_id`;
ALTER TABLE `conference_scheduler`.`users` 
DROP COLUMN `role_id`,
DROP INDEX `fk_role_id_idx` ;
  
INSERT INTO `conference_scheduler`.`roles` (`id`, `name`) VALUES ('2', 'site administrator');
INSERT INTO `conference_scheduler`.`roles` (`id`, `name`) VALUES ('3', 'conference owner');
INSERT INTO `conference_scheduler`.`roles` (`id`, `name`) VALUES ('4', 'conference administrator');

CREATE TABLE `conference_scheduler`.`venue` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `name` NVARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '');

CREATE TABLE `conference_scheduler`.`hall` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `name` NVARCHAR(45) NOT NULL COMMENT '',
  `venue_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_venue_id_idx` (`venue_id` ASC)  COMMENT '',
  CONSTRAINT `fk_venue_id`
    FOREIGN KEY (`venue_id`)
    REFERENCES `conference_scheduler`.`venue` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
	
ALTER TABLE `conference_scheduler`.`hall` 
ADD COLUMN `limit` INT NOT NULL DEFAULT 50 COMMENT '' AFTER `venue_id`;

CREATE TABLE `conference_scheduler`.`lecture` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `name` NVARCHAR(45) NOT NULL COMMENT '',
  `description` NVARCHAR(45) NOT NULL COMMENT '',
  `start_time` DATETIME NOT NULL COMMENT '',
  `end_time` DATETIME NOT NULL COMMENT '',
  `speaker_id` INT NOT NULL COMMENT '',
  `hall_id` INT NOT NULL COMMENT '',
  `conference_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '');

ALTER TABLE `conference_scheduler`.`lecture` 
ADD INDEX `fk_speaker_id_idx` (`speaker_id` ASC)  COMMENT '',
ADD INDEX `fk_hall_id_idx` (`hall_id` ASC)  COMMENT '';
ALTER TABLE `conference_scheduler`.`lecture` 
ADD CONSTRAINT `fk_speaker_id`
  FOREIGN KEY (`speaker_id`)
  REFERENCES `conference_scheduler`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_hall_id`
  FOREIGN KEY (`hall_id`)
  REFERENCES `conference_scheduler`.`hall` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

CREATE TABLE `conference_scheduler`.`conference` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `name` NVARCHAR(45) NOT NULL COMMENT '',
  `description` NVARCHAR(45) NOT NULL COMMENT '',
  `owner_id` INT NOT NULL COMMENT '',
  `venue_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '');

ALTER TABLE `conference_scheduler`.`conference` 
ADD INDEX `fk_conference_venue_id_idx` (`venue_id` ASC)  COMMENT '';
ALTER TABLE `conference_scheduler`.`conference` 
ADD CONSTRAINT `fk_conference_venue_id`
  FOREIGN KEY (`venue_id`)
  REFERENCES `conference_scheduler`.`venue` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `conference_scheduler`.`conference` 
ADD INDEX `fk_conference_owner_id_idx` (`owner_id` ASC)  COMMENT '';
ALTER TABLE `conference_scheduler`.`conference` 
ADD CONSTRAINT `fk_conference_owner_id`
  FOREIGN KEY (`owner_id`)
  REFERENCES `conference_scheduler`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `conference_scheduler`.`lecture`
ADD CONSTRAINT `fk_lecture_conference_id`
	FOREIGN KEY (`conference_id`)
	REFERENCES `conference_scheduler`.`conference` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION;
	
ALTER TABLE `conference_scheduler`.`conference` 
ADD COLUMN `start_date` DATETIME NOT NULL COMMENT '' AFTER `venue_id`,
ADD COLUMN `end_date` DATETIME NOT NULL COMMENT '' AFTER `start_date`;
  
  CREATE TABLE `conference_scheduler`.`conference_admins` (
  `conference_id` INT NOT NULL COMMENT '',
  `admin_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`conference_id`, `admin_id`)  COMMENT '',
  INDEX `fk_admin_id_idx` (`admin_id` ASC)  COMMENT '',
  CONSTRAINT `fk_conference_id`
    FOREIGN KEY (`conference_id`)
    REFERENCES `conference_scheduler`.`conference` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_admin_id`
    FOREIGN KEY (`admin_id`)
    REFERENCES `conference_scheduler`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
	
CREATE TABLE `conference_scheduler`.`user_roles` (
  `user_id` INT NOT NULL COMMENT '',
  `role_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`user_id`, `role_id`)  COMMENT '',
  INDEX `fk_role_index_id_idx` (`role_id` ASC)  COMMENT '',
  CONSTRAINT `fk_user_role_index_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `conference_scheduler`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_index_id`
    FOREIGN KEY (`role_id`)
    REFERENCES `conference_scheduler`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

  
CREATE TABLE `conference_scheduler`.`user_lectures` (
  `user_id` INT NOT NULL COMMENT '',
  `lecture_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`user_id`, `lecture_id`)  COMMENT '',
  INDEX `fk_lecture_user_id_idx` (`lecture_id` ASC)  COMMENT '',
  CONSTRAINT `fk_user_lecture_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `conference_scheduler`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lecture_user_id`
    FOREIGN KEY (`lecture_id`)
    REFERENCES `conference_scheduler`.`lecture` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
    
ALTER TABLE `conference_scheduler`.`conference` 
DROP FOREIGN KEY `fk_conference_owner_id`,
DROP FOREIGN KEY `fk_conference_venue_id`;
ALTER TABLE `conference_scheduler`.`conference` 
ADD CONSTRAINT `fk_conference_owner_id`
  FOREIGN KEY (`owner_id`)
  REFERENCES `conference_scheduler`.`users` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_conference_venue_id`
  FOREIGN KEY (`venue_id`)
  REFERENCES `conference_scheduler`.`venue` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `conference_scheduler`.`lecture` 
DROP FOREIGN KEY `fk_lecture_conference_id`;
ALTER TABLE `conference_scheduler`.`lecture` 
ADD CONSTRAINT `fk_lecture_conference_id`
  FOREIGN KEY (`conference_id`)
  REFERENCES `conference_scheduler`.`conference` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `conference_scheduler`.`user_lectures` 
DROP FOREIGN KEY `fk_user_lecture_id`,
DROP FOREIGN KEY `fk_lecture_user_id`;
ALTER TABLE `conference_scheduler`.`user_lectures` 
ADD CONSTRAINT `fk_user_lecture_id`
  FOREIGN KEY (`user_id`)
  REFERENCES `conference_scheduler`.`users` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_lecture_user_id`
  FOREIGN KEY (`lecture_id`)
  REFERENCES `conference_scheduler`.`lecture` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `conference_scheduler`.`lecture` 
DROP FOREIGN KEY `fk_speaker_id`;
ALTER TABLE `conference_scheduler`.`lecture` 
ADD CONSTRAINT `fk_speaker_id`
  FOREIGN KEY (`speaker_id`)
  REFERENCES `conference_scheduler`.`users` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `conference_scheduler`.`user_roles` 
DROP FOREIGN KEY `fk_role_index_id`,
DROP FOREIGN KEY `fk_user_role_index_id`;
ALTER TABLE `conference_scheduler`.`user_roles` 
ADD CONSTRAINT `fk_role_index_id`
  FOREIGN KEY (`role_id`)
  REFERENCES `conference_scheduler`.`roles` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_user_role_index_id`
  FOREIGN KEY (`user_id`)
  REFERENCES `conference_scheduler`.`users` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
ALTER TABLE `conference_scheduler`.`conference_admins` 
DROP FOREIGN KEY `fk_admin_id`,
DROP FOREIGN KEY `fk_conference_id`;
ALTER TABLE `conference_scheduler`.`conference_admins` 
ADD CONSTRAINT `fk_admin_id`
  FOREIGN KEY (`admin_id`)
  REFERENCES `conference_scheduler`.`users` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_conference_id`
  FOREIGN KEY (`conference_id`)
  REFERENCES `conference_scheduler`.`conference` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

INSERT INTO `conference_scheduler`.`users` (`id`, `username`, `password`, `email`) VALUES ('1', 'user', '1234', 'user@gmail.com');
INSERT INTO `conference_scheduler`.`users` (`id`, `username`, `password`, `email`) VALUES ('2', 'lucho', '1234', 'lucho@gmail.com');
INSERT INTO `conference_scheduler`.`users` (`id`, `username`, `password`, `email`) VALUES ('3', 'user2', '1234', 'user2@gmail.com');
INSERT INTO `conference_scheduler`.`users` (`id`, `username`, `password`, `email`) VALUES ('4', 'user3', '1234', 'user3@gmail.com');

INSERT INTO `conference_scheduler`.`user_roles` (`user_id`, `role_id`) VALUES('1', '1');
INSERT INTO `conference_scheduler`.`user_roles` (`user_id`, `role_id`) VALUES('2', '2');
INSERT INTO `conference_scheduler`.`user_roles` (`user_id`, `role_id`) VALUES('3', '3');
INSERT INTO `conference_scheduler`.`user_roles` (`user_id`, `role_id`) VALUES('4', '4');

INSERT INTO `conference_scheduler`.`venue` (`id`, `name`) VALUES ('1', 'Hilton Sofia');
INSERT INTO `conference_scheduler`.`venue` (`id`, `name`) VALUES ('2', 'Palace of Sports and culture Varna');
INSERT INTO `conference_scheduler`.`venue` (`id`, `name`) VALUES ('3', 'National Palace of Culture');
INSERT INTO `conference_scheduler`.`venue` (`id`, `name`) VALUES ('4', 'Pleven Panorama');
INSERT INTO `conference_scheduler`.`venue` (`id`, `name`) VALUES ('5', 'South Beach');
INSERT INTO `conference_scheduler`.`venue` (`id`, `name`) VALUES ('6', 'Hotel Rostov Pleven');
INSERT INTO `conference_scheduler`.`venue` (`id`, `name`) VALUES ('7', 'Madison Square Garden');
INSERT INTO `conference_scheduler`.`venue` (`id`, `name`) VALUES ('8', 'Software University');

INSERT INTO `conference_scheduler`.`hall` (`id`, `name`, `venue_id`, `limit`) VALUES ('1', 'Ground Lab', '8', '50');
INSERT INTO `conference_scheduler`.`hall` (`id`, `name`, `venue_id`, `limit`) VALUES ('2', 'Inspiration Lab', '8', '250');
INSERT INTO `conference_scheduler`.`hall` (`id`, `name`, `venue_id`, `limit`) VALUES ('3', 'First Conference Room', '4', '1');
INSERT INTO `conference_scheduler`.`hall` (`id`, `name`, `venue_id`, `limit`) VALUES ('4', 'Open Source Lab', '1', '400');
INSERT INTO `conference_scheduler`.`hall` (`id`, `name`, `venue_id`, `limit`) VALUES ('5', 'The Liquid Hall', '5', '150');
INSERT INTO `conference_scheduler`.`hall` (`id`, `name`, `venue_id`, `limit`) VALUES ('6', '3-rd of March Room', '6', '100');
INSERT INTO `conference_scheduler`.`hall` (`id`, `name`, `venue_id`, `limit`) VALUES ('7', 'Felt Hall', '7', '2000');
INSERT INTO `conference_scheduler`.`hall` (`id`, `name`, `venue_id`, `limit`) VALUES ('8', 'Giant Hall', '7', '3000');
INSERT INTO `conference_scheduler`.`hall` (`id`, `name`, `venue_id`, `limit`) VALUES ('9', 'Kings Hall', '8', '100');

INSERT INTO `conference_scheduler`.`conference` (`description`, `id`, `name`, `owner_id`, `venue_id`, `start_date`, `end_date`) VALUES ('SoftUni Conference for the latest technology trends for developers.', '1', 'SoftUni Conf', '1', '8', '2015-11-22', '2015-11-23');
INSERT INTO `conference_scheduler`.`conference` (`description`, `id`, `name`, `owner_id`, `venue_id`, `start_date`, `end_date`) VALUES ('Engineering Conference for architecture and design', '2', 'We Create The World', '1', '7', '2015-11-30', '2015-12-4');
INSERT INTO `conference_scheduler`.`conference` (`description`, `id`, `name`, `owner_id`, `venue_id`, `start_date`, `end_date`) VALUES ('Agriculture Conference for the newest trends and technology in agriculture', '3', 'AgriConf', '2', '3', '2015-12-1', '2015-12-3');
INSERT INTO `conference_scheduler`.`conference` (`description`, `id`, `name`, `owner_id`, `venue_id`, `start_date`, `end_date`) VALUES ('Sports Conference for developing new sports', '4', 'For the sport', '2', '4', '2015-12-2', '2015-12-5');
INSERT INTO `conference_scheduler`.`conference` (`description`, `id`, `name`, `owner_id`, `venue_id`, `start_date`, `end_date`) VALUES ('Automobile Conference', '5', 'Geneva Auto', '1', '5', '2015-12-1', '2015-12-4');
INSERT INTO `conference_scheduler`.`conference` (`description`, `id`, `name`, `owner_id`, `venue_id`, `start_date`, `end_date`) VALUES ('IT Conference for the latest trends in softwatre development', '6', 'Hack Conf', '1', '7', '2015-12-3', '2015-12-6');

INSERT INTO `conference_scheduler`.`conference_admins` (`admin_id`, `conference_id`) VALUES ('1', '1');
INSERT INTO `conference_scheduler`.`conference_admins` (`admin_id`, `conference_id`) VALUES ('2', '2');
INSERT INTO `conference_scheduler`.`conference_admins` (`admin_id`, `conference_id`) VALUES ('3', '3');
INSERT INTO `conference_scheduler`.`conference_admins` (`admin_id`, `conference_id`) VALUES ('4', '4');
INSERT INTO `conference_scheduler`.`conference_admins` (`admin_id`, `conference_id`) VALUES ('1', '5');
INSERT INTO `conference_scheduler`.`conference_admins` (`admin_id`, `conference_id`) VALUES ('2', '6');

INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('4', 'OOP Encapsulation and Polymorhism', '2015-12-2 14:00:00', '3', '1', 'OOP Lecture', '1', '2015-12-2 12:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('3', 'OOP Inheritance', '2015-12-1 15:00:00', '1', '2', 'C# Lecture', '2', '2015-12-1 13:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('2', 'OOP Exception Handling', '2015-12-3 16:00:00', '2', '3', 'Java Lecture', '4', '2015-12-3 13:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('1', 'Web Dev Basics Security', '2015-11-23 17:00:00', '4', '4', 'Web Dev Lecture', '3', '2015-11-23 14:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('6', 'ASP.NET New Features', '2015-12-3 18:00:00', '5', '5', 'ASP.NET Lecture', '2', '2015-12-3 15:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('5', 'Use Google properly', '2015-12-3 19:00:00', '6', '6', 'Google Lecture', '1', '2015-12-3 17:00:00');

INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('1', 'Strong Cohesion Lecture', '2015-11-22 19:00:00', '4', '7', 'Strong Cohesion', '3', '2015-11-22 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('1', 'Loose Coopling Lecture', '2015-11-22 21:00:00', '4', '8', 'Loose Coopling', '4', '2015-11-22 19:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('1', 'Events Lecture', '2015-11-22 15:00:00', '4', '9', 'Events', '1', '2015-11-22 11:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('1', 'Cloud Lecture Azure', '2015-11-23 19:00:00', '4', '10', 'Azure', '2', '2015-11-23 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('2', 'Primitive types lecture', '2015-11-30 15:00:00', '2', '11', 'Primitive types', '3', '2015-11-30 13:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('2', 'Loops Lecture', '2015-11-30 18:00:00', '2', '12', 'Loops', '4', '2015-11-30 16:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('2', 'Arrays Lecture', '2015-12-1 19:00:00', '2', '13', 'Arrays', '1', '2015-12-1 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('2', 'Conditionals Lecture', '2015-12-3 19:00:00', '2', '14', 'If / else', '1', '2015-12-3 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('3', 'C# 6 -> The future', '2015-12-3 19:00:00', '1', '15', 'C# 6', '2', '2015-12-3 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('3', 'About mice and man', '2015-12-1 19:00:00', '1', '16', 'Mice / man', '2', '2015-12-1 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('3', 'Social engineering Lecture', '2015-12-2 12:30:00', '1', '17', 'Social hacks', '3', '2015-12-2 11:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('3', 'P vs NP lecture', '2015-12-2 16:00:00', '1', '18', 'P vs NP', '3', '2015-12-2 14:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('4', 'Greedy algorithms Lecture', '2015-12-4 19:00:00', '3', '19', 'Greedy', '4', '2015-12-4 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('4', 'Graphs and graph algorithms', '2015-12-4 21:00:00', '3', '20', 'Graphs', '4', '2015-12-4 19:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('4', 'Combinatorics Lecture', '2015-12-5 19:00:00', '3', '21', 'Combinatorics', '1', '2015-12-5 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('4', 'Oracle Database Tools', '2015-12-5 16:00:00', '3', '22', 'Oracle DB', '2', '2015-12-5 13:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('5', 'T-SQL and Microsoft SQL Tools', '2015-12-1 13:00:00', '5', '23', 'T-SQL', '3', '2015-12-1 11:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('5', 'MySQL Lecture', '2015-12-1 19:00:00', '5', '24', 'MySQL', '4', '2015-12-1 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('5', 'XML Basics', '2015-12-2 19:00:00', '5', '25', 'XML', '1', '2015-12-2 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('5', 'Json Basics', '2015-12-4 19:00:00', '5', '26', 'Json', '2', '2015-12-4 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('6', 'HTML Basics', '2015-12-4 11:00:00', '6', '27', 'HTML', '3', '2015-12-4 09:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('6', 'Wordpress Lecture', '2015-12-5 16:00:00', '6', '28', 'Wordpress', '4', '2015-12-5 13:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('6', 'Social networks Lecture', '2015-12-6 15:00:00', '6', '29', 'Social networks', '1', '2015-12-6 12:30:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('6', 'SQL Injection Lecture', '2015-12-6 18:30:00', '6', '30', 'SQL Injection', '2', '2015-12-6 16:00:00');

INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('4', 'Algorithms lecture', '2015-12-3 19:00:00', '3', '31', 'Algorithms', '3', '2015-12-3 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('2', 'PHP Basics lecture', '2015-12-4 19:00:00', '2', '32', 'PHP Basics', '4', '2015-12-4 17:00:00');
INSERT INTO `conference_scheduler`.`lecture` (`conference_id`, `description`, `end_time`, `hall_id`, `id`, `name`, `speaker_id`, `start_time`) VALUES ('3', 'Advanced C# lecture', '2015-12-3 22:00:00', '1', '33', 'Advanced C#', '2', '2015-12-3 19:00:00');

INSERT INTO `conference_scheduler`.`user_lectures` (`user_id`, `lecture_id`) VALUES('1', '1');
INSERT INTO `conference_scheduler`.`user_lectures` (`user_id`, `lecture_id`) VALUES('2', '2');
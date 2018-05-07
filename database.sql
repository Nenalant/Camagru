CREATE DATABASE Camagru;

CREATE TABLE `Camagru`.`accounts` (
	`login` VARCHAR NOT NULL ,
	`email` VARCHAR NOT NULL ,
	`passwd` VARCHAR NOT NULL ) 
ENGINE = InnoDB;
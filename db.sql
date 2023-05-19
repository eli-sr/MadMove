create table LINEAS (
    `line`  char(3) PRIMARY KEY,
    `label` varchar(5),
    `nameA` varchar(30),
    `nameB` varchar(30),
    `group` varchar(3)
);

CREATE TABLE USUARIOS (
    `ID`    INT NOT NULL AUTO_INCREMENT , 
    `USER`  VARCHAR(30) NOT NULL , 
    `PASSWORD`  VARCHAR(30) NOT NULL , 
    `NAME`  VARCHAR(30) NOT NULL , 
    `SURNAME`  VARCHAR(30) NULL , 
    PRIMARY KEY (`ID`)
);

CREATE TABLE PARADAS (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(50) NOT NULL ,
    `lineas` JSON NOT NULL ,
    `geometry` JSON NOT NULL ,
    PRIMARY KEY (`id`)
);

CREATE TABLE RESERVAS (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `date` VARCHAR(20) NOT NULL ,
    `time` VARCHAR(20) NOT NULL,
    `parkingId` INT NOT NULL ,
    `userId` INT NOT NULL ,
    `done` BOOLEAN NOT NULL ,
    PRIMARY KEY (`id`)
);
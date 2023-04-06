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
    PRIMARY KEY (`ID`)
);

CREATE TABLE PARADAS (
    `ID` INT NOT NULL AUTO_INCREMENT ,
    `NAME` VARCHAR(50) NOT NULL ,
    `LINEAS` JSON NOT NULL ,
    `GEO` JSON NOT NULL ,
    PRIMARY KEY (`ID`)
);
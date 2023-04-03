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
/*Creamos la tabla de los fisios*/
CREATE TABLE USUARIOS (ID int(8) NOT NULL AUTO_INCREMENT, USER_FISIO varchar(100) NOT NULL, PASS varchar(100) NOT NULL,PRIMARY KEY (ID));

/*Creamos la tabla de los pedidos*/
CREATE TABLE PEDIDOS (NUMPEDIDO int(10) NOT NULL AUTO_INCREMENT, FECHA varchar(20) NOT NULL, HORA varchar(20) NOT NULL, pagado boolean NOT NULL, fisio varchar(40) NOT NULL,PRIMARY KEY(NUMPEDIDO));

/*Insert para los usuarios fisios*/
INSERT INTO USUARIOS (USER_FISIO,PASS) VALUES ("Pablo_Fisio",SHA1("pass"));


/*Creamos las restricciones y los indices para la tabla*/
ALTER TABLE PEDIDOS ADD UNIQUE (NUMPEDIDO,FECHA,HORA,PAGADO,FISIO);
ALTER TABLE `PEDIDOS` ADD INDEX (  `NUMPEDIDO` )


/*Creamos la tabla de los fisios*/
CREATE TABLE usuarios (id int(8), user varchar(100), pass varchar(100))

/*Creamos la tabla de los pedidos*/
CREATE TABLE pedidos (numpedido int(10), fecha varchar(20), hora varchar(20), pagado boolean, fisio varchar(40))

/*Insert para los usuarios fisios*/
INSERT INTO USUARIOS VALUES (1,"Pablo_Fisio",SHA1("pass"));


/*Creamos las restricciones y los indices para la tabla*/
ALTER TABLE PEDIDOS ADD UNIQUE (NUMPEDIDO,FECHA,HORA,PAGADO,FISIO)
CREATE INDEX INDEX_NUMPEDIDO ON PEDIDOS (NUMPEDIDO(10))


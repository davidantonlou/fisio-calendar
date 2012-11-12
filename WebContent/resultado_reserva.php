<!-- 

	Realizar inserción de la cita (JOSE)
	Mostrar que todo ha ido OK/ERROR (JOSE)
	Enviar mail al fisio administrador (DAVID)
	Borrar datos de sesión (DAVID)
	
	
RESPUESTA DE LA OPERACIÓN **** DUDA: Ver en que formato devuelve la información (GET o POST)

compra ->   ‘si’ la operación es correcta
			‘no’ la operación no es correcta y no se ha autorizado

moneda ->   ‘978’ Euros

numpedido -> Campo numérico de 4 a 12 posiciones que indica el número del pedido de la tienda 

fecha -> AAMMDDhhmmss.

firma -> Campo de 40 posiciones alfanuméricas.
			si el campo compra devuelto vale “si”
			cadena = “0”+CIP+numpedido+importe+fecha;
			
			y si el campo compra devuelto vale “no”
			cadena = “1”+CIP+numpedido+importe+fecha;
	
	
-->
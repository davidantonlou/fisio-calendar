<!-- 

	Realizar inserci�n de la cita (JOSE)
	Mostrar que todo ha ido OK/ERROR (JOSE)
	Enviar mail al fisio administrador (DAVID)
	Borrar datos de sesi�n (DAVID)
	
	
RESPUESTA DE LA OPERACI�N **** DUDA: Ver en que formato devuelve la informaci�n (GET o POST)

compra ->   �si� la operaci�n es correcta
			�no� la operaci�n no es correcta y no se ha autorizado

moneda ->   �978� Euros

numpedido -> Campo num�rico de 4 a 12 posiciones que indica el n�mero del pedido de la tienda 

fecha -> AAMMDDhhmmss.

firma -> Campo de 40 posiciones alfanum�ricas.
			si el campo compra devuelto vale �si�
			cadena = �0�+CIP+numpedido+importe+fecha;
			
			y si el campo compra devuelto vale �no�
			cadena = �1�+CIP+numpedido+importe+fecha;
	
	
-->
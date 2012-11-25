<?php
	include("datos_conexion.php");
	include ("js/sha1.txt");
	
	// Si se ha realizado una reserva y se desea mostrar el detalle
	if (isset($_POST['isReserva'])){		
		$str_fecha = date("dmyHis");
	$isAdmin=false;
	if (isset($_SESSION['user']))
		$isAdmin=true;
	
	if (!$isAdmin){			 
		// Insertamos el pedido
		mysql_query("INSERT INTO pedidos (fecha, importe) VALUES (NOW(), 30)");
		
		// Obtenemos el número de pedido insertado
		$sqlQuery=mysql_query("SELECT MAX(numpedido) AS numpedido FROM pedidos");
		$pedido = @mysql_fetch_assoc($sqlQuery) ;
		
		// Preparamos la longitud del número de pedido
		$num = $pedido["numpedido"];
		if (strlen($pedido["numpedido"]) < 10){
			for ($i=strlen($pedido["numpedido"]); $i<10; $i++)
				$num = "0" + $num;
		}
		
		// Preparamos los datos del pago virtual
		$cip = "111111111111";
		$importe = "000000003000";
		$moneda = "978";
		$fuc = "229011267";
		$terminal = "001";
		$idioma = "0";
		$numpedido = $num;
		$url = "http://localhost//Fisiomaquet/WebContent/resultado_reserva.php";
		
		$sha = new SHA;
		$message = $str_fecha.$cip.$importe.$moneda.$numpedido;
		$digest1 = $sha->hash_string($message);
		$firma = $sha->hash_to_string( $digest1 );
		
		// Fecha + CIP + Importe + Moneda + Numero de Pedido
		//$stringSha1 = $str_fecha + "" + "" + "978" + "";
	}
?>

<!doctype html>
 
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Fisioterapia Valdespartera</title>

    <style type="text/css">
 		div.background{
 			background-image:url('http://www.fisioterapiavaldespartera.com/sites/all/themes/danland/images/fondo-content.jpg');
 		}
 		body{
 		color: #000000;
	    font-family: Verdana,Arial,Helvetica,sans-serif;
	    font-size: 84%;
	    line-height: 1.5em;
       }
    </style>
    	
</head>
<body>
<div class="background">
	<h1>Confirmar Reserva</h1>
	
<?php 
	if ($isAdmin){
?>

	<form name="confirm_date_final" method="post" action="resultado_reserva.php">
	</form>

<?php 
	}else{
?>
	<form name="confirm_date" method="post" action="https://tpv01.cajarural.com/nuevo_tpv/tpv/jsp/tpvjp_validaComercio.jsp">
		<input type="hidden" name="importe" value="<?php echo $importe; ?>"/>
		<input type="hidden" name="numpedido" value="<?php echo $numpedido; ?>"/>
		<input type="hidden" name="moneda" value="<?php echo $moneda; ?>"/>
		<input type="hidden" name="fuc" value="<?php echo $fuc; ?>"></input>
		<input type="hidden" name="idioma" value="<?php echo $idioma; ?>"/>
		<input type="hidden" name="idterminal" value="<?php echo $terminal; ?>"/>
		<input type="hidden" name="fecha" value="<?php echo $str_fecha; ?>"/>
		<input type="hidden" name="firma" value="<?php echo $firma; ?>"/>
		<input type="hidden" name="url" value="<?php echo $url; ?>"/>
	 </form>
<?php }?>


		<table>
		 	<tr>
		 		<td>Fecha: </td> 
		 		<td>27/10/2012 - <?php echo $num; ?>
		 			<!-- echo $_SESSION["startTime"]; -->
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Hora: </td>
		 		<td>18:00
		 			<!--  echo $_SESSION["startTime"]; -->
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Fisioterapeuta: </td>
		 		<td>Pablo
		 			<!-- echo $_SESSION["calendar"]; -->
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Nombre: </td>
		 		<td>Cliente
		 			<!-- echo $_SESSION["title"]; -->
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Descripci&oacute;n: </td>
		 		<td>Descripci&oacute;n reserva
		 			<!-- echo $_SESSION["description"]; -->
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Tratamiento: </td>
		 		<td>General (30,00 &euro;)</td>
		 	</tr>
		 	<tr>
		 		<td><input type="button" value="Confirmar y Pagar" onclick="javascript:document.confirm_date.submit();"/></td>
		 		<td><input type="button" value="Volver" onclick="reservar_cita.php"/></td>
		 	</tr>
		 </table>

 </div>
</body>
</html>
<?php } ?>
<?php

	session_start();
	
	include("datos_conexion.php");
	// 	include ("js/sha1.txt");
	include("sha1.php");
		
	$isAdmin=false;
	if (isset($_SESSION['user']))
		$isAdmin=true;
	
	// Verificamos si ya estaba realizada la reserva
	$sqlQuery=mysql_query("SELECT numpedido FROM pedidos WHERE fecha = '". $_POST["datepicker"] ."' AND hora = '". $_POST["selectDate"] ."' AND fisio = '". $_POST["calendarCombo"] ."' AND pagado = '1'");
	$pedido = @mysql_fetch_assoc($sqlQuery);
		
	// Si se ha realizado una reserva y se desea mostrar el detalle
	if ($pedido["numpedido"] != null || !isset($_POST['isReserva'])){		
		$str_fecha = date("dmyHis");
		
		// Creamos un semaforo para evitar numeros de pedido repetidos
		$sem_key = 12;
		$sem_id = sem_get($sem_key, 1);
		if (! sem_acquire($sem_id)) die ('Error esperando a obtener el numero de pedido.');
		// Obtenemos el n�mero de pedido insertado
		$sqlQuery=mysql_query("SELECT MAX(numpedido) AS numpedido FROM pedidos");
		$pedido = @mysql_fetch_assoc($sqlQuery);
		if (! sem_release($sem_id)) die ('Error esperando a obtener el numero de pedido.');
				
		// Insertamos el pedido en base de datos
		$patientName = $_POST["title"].$_POST["surname"];
		$telephone = $_POST["telephone"];
		$email = $_POST["email"];
		$fecha = $_POST["datepicker"];
		$hora = $_POST["hour"];
		$pagado = false;
		$fisio = $_POST["calendarCombo"];
		$numpedido = $pedido["numpedido"] + 1;
		mysql_query("INSERT INTO pedidos (numpedido, fecha, hora, pagado, fisio,telefono,email,paciente) VALUES (". $numpedido .", '". $fecha ."', '$hora','". $pagado ."', '". $fisio ."', '". $telephone ."', '". $email ."', '". $patientName ."')");
		
		
		// Guardamos en sesi�n la informaci�n de la reserva
		$_SESSION["startDate"] = $_POST["datepicker"];
		$_SESSION["startTime"] = $_POST["hour"];
		$_SESSION["calendar"] = $_POST["calendarCombo"];
		$_SESSION["title"] = $_POST["title"];
		$_SESSION["description"] = $_POST["description"];
		$_SESSION["eventId"] = $_POST["eventId"];

		
		//Muy util fecha de inicio y fin en formatoRFC
		$_SESSION["endDateRFormatRFC"] = $_POST["endDateRFormatRFC"];
		$_SESSION["startDateFormatRFC"] = $_POST["startDateFormatRFC"];
		
		
	if (!$isAdmin){			 		
		// Preparamos la longitud del n�mero de pedido
		$num = '' . $pedido["numpedido"];
		if (strlen($pedido["numpedido"]) < 11){
			for ($i=strlen($pedido["numpedido"]); $i<10; $i++)
				$num = '0' . $num;
		}
		
		// Preparamos los datos del pago virtual
		$cip = "111111111111";
		$importe = "000000003000";
		$moneda = "978";
		$fuc = "229011267";
		$terminal = "001";
		$idioma = "0";
		$numpedido = $num;
		$url = $ini_array["urlResult"];
		
		$sha = new SHA;
		// Fecha + CIP + Importe + Moneda + Numero de Pedido
		$message = $str_fecha.$cip.$importe.$moneda.$numpedido;
		$digest1 = $sha->hash_string($message);
		$firma = $sha->hash_to_string( $digest1 );
		
	}
?>

<!doctype html>
 
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Fisioterapia Valdespartera</title>
	<link rel="stylesheet" href="css/calendarStyle.css"> 
    	
</head>
<body>
<div class="background">

<?php if ($isAdmin){?>
	<a class="button" href="javascript: location.href='login.php?modo=desconectar';" style="margin-left: 90%;margin-top: 15%">Desconectar</a>
<?php }?>
<div class="center" style="margin-top:10 	 %;margin-left: 35%;">
<h1 class="title" style="padding-right: 5%;">Confirmar Reserva</h1>
<table style="margin-left: 10%">
	<tr>
		<td>
			<span class="explica">Para cambiar una reserva  deber&aacute; ponerse en contacto con nuestro centro, llamando al 976 935 739 / 695 701 065. Ser&aacute;n v&aacute;lidas las modificaciones hasta 24h antes de la hora de citaci&oacute;n.</span>
		</td>
	</tr>
</table>
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


		<table 	 style="margin-left: 15%;margin-top: 5%;">
			<tr>
		 		<td>Nombre: </td>
		 		<td><?php echo $_SESSION["title"]; ?>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Apellidos: </td>
		 		<td><?php echo $_POST["surname"]; ?>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Telefono: </td>
		 		<td><?php echo $telephone; ?>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Email: </td>
		 		<td><?php echo $email; ?>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Fecha: </td> 
		 		<td><?php echo $_SESSION["startDate"]; ?>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Hora: </td>
		 		<td><?php echo $_SESSION["startTime"]; ?>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Fisioterapeuta: </td>
		 		<td><?php echo $ini_array['namesList'][$_SESSION["calendar"]] ?>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Descripci&oacute;n: </td>
		 		<td><?php echo $_SESSION["description"]; ?>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td>Tratamiento: </td>
		 		<td>General (30,00 &euro;)</td>
		 	</tr>
		 	<tr>
		 		<td></td>
		 	</tr>
		 	<tr>
		 	
		 	<?php if ($isAdmin){ ?>
		 		<td></td>
		 		<td><a class="button" style="margin-left:50%"  onclick="javascript:document.confirm_date_final.submit();">Confirmar</a></td>
		 	<?php }else{?>	
		 		<td><a class="button"  onclick="javascript:document.confirm_date.submit();">Confirmar y Pagar</a></td>
		 	<?php }?>
		 	
		 		<td><a class="button" style="margin-left:20%"  onclick="javascript:history.back();">Volver</a></td>
		 	</tr>
		 </table>
 </div>
 </div>
</body>
</html>
<?php } ?>
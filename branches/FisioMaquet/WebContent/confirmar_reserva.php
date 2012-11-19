<?php
	// Si se ha realizado una reserva y se desea mostrar el detalle
	if (isset($_POST['isReserva'])){		
		$str_fecha = date("dmyHis");
	$isAdmin=false;
	if (isset($_SESSION['user']))
		$isAdmin=true;
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
<?php include ("js/sha1.txt");?> 
<?
$cip = "111111111111";
$importe = "000000003000";
$moneda = "978";
$numpedido = "0000000001";

$sha = new SHA;
$message = $str_fecha.$cip.$importe.$moneda.$numpedido;
$digest1 = $sha->hash_string($message);
$firma = $sha->hash_to_string( $digest1 );

	// Fecha + CIP + Importe + Moneda + Numero de Pedido 
	//$stringSha1 = $str_fecha + "" + "" + "978" + ""; 
?>
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
		<input type="hidden" name="importe" value="000000003000"/>
		<input type="hidden" name="numpedido" value="0000000001"/>
		<input type="hidden" name="moneda" value="978"/>
		<input type="hidden" name="fuc" value="229011267"></input>
		<input type="hidden" name="idioma" value="0"/>
		<input type="hidden" name="idterminal" value="001"/>
		<input type="hidden" name="fecha" value="<?php echo $str_fecha; ?>"/>
		<input type="hidden" name="firma" value="<?php echo $firma; ?>"/>
		<input type="hidden" name="url" value="http://localhost//Fisiomaquet/WebContent/resultado_reserva.php"/>
	 </form>
<?php }?>


		<table>
		 	<tr>
		 		<td>Fecha: </td> 
		 		<td>27/10/2012
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
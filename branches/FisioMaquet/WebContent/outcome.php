<?php
	$error = $_GET["error"];
?>


<html>


	<head>
	
		<meta charset="utf-8" />
		
		<title>Rerserva satisfactoria</title>
   		<link rel="stylesheet" href="css/calendarStyle.css"> 
   		
	</head>
	
	
	<body>
		<div class="background">
				
				
				
				<table class="center" style="margin-top: 15%;margin-left: 25%;">
					<tr>
						<td>
						<?php 
						if($error=='false'){
							echo '<span class="finishTittle">Su reseva se ha realizado de forma satisfactioria</span>';
						}else{
							echo '<span class="finishBadTittle">Su reseva no se ha podido realizar correctamente</span>';
						}
						
						?>
						</td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td>
						<?php 
						if($error=='false'){
							echo '<p style="margin-left: 20%;margin-top: 5%" class="">Gracias por usar nuestros servicios si tiene alguna sobre la cita o la quiere modifcar no dude en llamar al telefono: 976935739 </p>';
						}else{
							echo '<p style="margin-left: 20%;margin-top: 5%" class="">No se ha podido realizar la reserva, vuelva a intentarlo si tiene alguna duda no dude en llamar al telefono: 976935739 </p>';
						}
						?>
						</td>
					</tr>
					<tr>
						<td><p style="margin-left: 20%;margin-top: 5%">Pulse <a href="reservar_cita.php">aqui</a> para volver</p> </td>
					</tr>
				</table>
			
		</div>
	</body>






</html>
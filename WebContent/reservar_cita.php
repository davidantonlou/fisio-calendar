<?php
	session_start();

	$isAdmin=false;
	if (isset($_SESSION['user']))
		$isAdmin=true;

?>

<!doctype html>
 
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Fisioterapia Valdespartera</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <script src="http://jquery-ui.googlecode.com/svn/trunk/ui/i18n/jquery.ui.datepicker-es.js"></script>
    <script src="js/users_calendars.js"></script>
    <script src="js/calendar.js"></script>

    <style type="text/css">
    	div.ui-datepicker{
    	font-size:10px;
    	}
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
    	
     <script>
	    $(function() {
	        $( "#datepicker" ).datepicker($.datepicker.regional['es']);
	    });
	    
     </script>
  	 <script src="js/calendarActions.js"></script>
  	 
     <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
</head>
<body onLoad="javascript:handleAuthClick();">
<div class="background">
<input type="button" value="Desconectar" onclick="javascript: location.href='login.php?modo=desconectar';"/></td>
<h1>Reserva de citas</h1>
<form name="createEvent" method="post" action="confirmar_reserva.php">
	<input type="hidden" name="calendar"/>
	 <table>
	 	<tr>
	 		<td>Seleccione doctor :
	 			<select id="calendarCombo" onchange="changeCalendar(this.value);">
	 				<option selected="selected" value="0">-- Selecciona un Fisio</option>
	 				<option value="1">Pablo</option>
	 				<option value="2">Jose</option>
	 				<option value="3">Maria</option>
	 			</select>
	 		</td>
	 	</tr>
	 	<tr width="50px">
	 		<td> Fecha: <input type="text" id="datepicker" name="datepicker"/> Hora: <select  id="selectDate" name="selectDate" disabled="disabled"/> </td>
	 	</tr>
	 	<tr>
	 		<td> Nombre: <input type="text" size="55px" id="title" name="title"/> </td>
	 	</tr>
	 	<tr>
	 		<td> Anotaciones adicionales: <textarea id="description" name="description" style="resize: none;" cols="25" rows="2"></textarea>
	 	</tr>
	 	<tr>
	 		<td><input type="submit" value="Reservar" name="isReserva" id="isReserva" onclick=""/></td>
	 	</tr>
	 </table>
 </form>
 <table>
 	<tr>
 		<td><iframe id="doctorCalendar" src="https://www.google.com/calendar/embed?title=Fisioterapia%20Valdespartera&amp;showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;mode=WEEK&amp;height=600&amp;wkst=2&amp;bgcolor=%23ffffff&amp;src=hv5gfg41m9g2a87kr27uso10p0%40group.calendar.google.com&amp;color=%23B1440E&amp;src=t82rb1fmjt84v4mq2sso91fr7c%40group.calendar.google.com&amp;color=%232F6309&amp;src=fisiocalendar%40gmail.com&amp;color=%232952A3&amp;ctz=Europe%2FMadrid" style=" border-width:0 " width="800" height="600" frameborder="0" scrolling="no"></iframe></td>
 	</tr>
 </table>
 </div>
</body>
</html>
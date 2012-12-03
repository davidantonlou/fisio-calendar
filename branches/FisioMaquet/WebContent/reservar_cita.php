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
    <link rel="stylesheet" href="css/calendarStyle.css"> 
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
    
    <!-- Configuramos el calendario -->
     <script>
	    $(function() 
	    {
	    	 $( "#datepicker" ).datepicker({ dateFormat: "dd/mm/yy" });
	    	 $( "#datepicker" ).datepicker("option", "minDate", new Date());
	         
	    });	    
     </script>
     
     <!-- realizamos validacion javascript -->
     <script type="text/javascript">
   		  $(document).ready(function(){
    	    $("#createEvent").validate();
    	  });
     </script>
     
     <script>
	    function validar() {
		    // Validaciones antes de enviar el formulario
		    if (document.getElementById("calendarCombo").value == "0"){
	        	alert("Debes de seleccionar un fisio de la lista.");
		    }
		    else if (document.getElementById("datepicker").value == ""){
			    alert("Debes de seleccionar una fecha.");
		    }
		    else if (document.getElementById("selectDate").value == ""){
			    alert("Debes de seleccionar una hora.");
		    }
		    else if (document.getElementById("title").value == ""){
			    alert("Debes introducir un nombre para la reserva.");
		    }
		    else{
			    document.createEvent.eventId.value =document.createEvent.selectDate.options[document.createEvent.selectDate.options.selectedIndex].value;
			    document.createEvent.hour.value =   document.createEvent.selectDate.options[document.createEvent.selectDate.options.selectedIndex].innerHTML;
		    	document.createEvent.submit();
		    }
	    };	    
     </script>
     
  	 <script src="js/calendarActions.js"></script>  	 
</head>
<body>
<div class="background">
<?php if ($isAdmin){?>
	<a class="button" href="javascript: location.href='login.php?modo=desconectar';" style="margin-left: 90%">Desconectar</a>
<?php }?>

<h1 class="title">Reserva de citas</h1>
<form id="createEvent" name="createEvent" method="post" action="confirmar_reserva.php">
	<input type="hidden" name="calendar"/>
	<input type="hidden" name="eventId"/>
	<input type="hidden" name="hour"/>
	<br/><br/>
	 <table style="padding-left: 10%">
	 	<tr>
	 		<td>
	 			<span class="text">Seleccione doctor :</span>
	 		</td>
	 		<td>
	 			<select id="calendarCombo" name="calendarCombo" onchange="changeCalendar(this.value);"  class="required">
	 				<option selected="selected" value="0">-- Selecciona un Fisio</option>
	 				<option value="1">Pablo</option>
	 				<option value="2">Jose</option>
	 				<option value="3">Maria</option>
	 			</select>
	 		</td>
	 	</tr>
	 	<tr>
	 		<td> 
	 			<span class="text">Fecha:</span>
	 		</td>
	 		<td>
		 		<input type="text" id="datepicker" name="datepicker" onchange="loadFreeHours(this.value)" disabled="disabled"  class="required" readony="readonly"/>		 		
	 		</td>
	 		
	 	</tr>
	 	<tr>
	 		<td>
	 			<span class="text">Hora:</span>  
	 		</td>
	 		<td>
	 			<select  id="selectDate" name="selectDate" disabled="disabled"  class="required"/>
	 		</td>
	 	</tr>
	 	<tr>
	 		<td> <span class="text">Nombre: </span>  </td>
	 		<td> <input type="text" size="55px" id="title" name="title"  class="required"/> </td>
	 	</tr>
	 	<tr>
	 		<td> <span class="text"> Anotaciones adicionales: </span> </td>
	 		<td> <textarea id="description" name="description" style="resize: none;" cols="25" rows="2"></textarea> </td>
	 	</tr>
	 </table>
	 <br/><br/>
	 
	 <a style="margin-left:45%" class="button submit" onclick="javascript:validar();">Reservar</a>
 </form>
 <br/><br/>
 <table>
 	<tr>
 		<td><iframe id="doctorCalendar" src="https://www.google.com/calendar/embed?title=Fisioterapia%20Valdespartera&amp;showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;mode=WEEK&amp;height=600&amp;wkst=2&amp;bgcolor=%23ffffff&amp;src=hv5gfg41m9g2a87kr27uso10p0%40group.calendar.google.com&amp;color=%23B1440E&amp;src=t82rb1fmjt84v4mq2sso91fr7c%40group.calendar.google.com&amp;color=%232F6309&amp;src=fisiocalendar%40gmail.com&amp;color=%232952A3&amp;ctz=Europe%2FMadrid" style=" border-width:0 " width="800" height="600" frameborder="0" scrolling="no"></iframe></td>
 	</tr>
 </table>
 </div>
</body>
</html>
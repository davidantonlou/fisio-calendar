<?php
	session_start();

	$isAdmin=false;
	if (isset($_SESSION['user']))
		$isAdmin=true;
	
	$ini_array = parse_ini_file("config.ini");

?>

<!doctype html>
 
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Fisioterapia Valdespartera</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <link rel="stylesheet" href="css/calendarStyle.css"/> 
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <script src="js/validations.js"></script>
    <script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
    <style>
  	    div.backgroundSpecial
    	{
   		 background-image:url('http://www.fisioterapiavaldespartera.com/sites/all/themes/danland/images/fondo-content.jpg');
   		}
   	 	
    </style>
    <script>
	    function changeCalendar(value)
	    {
	    	var listado=new Array();
	    	<?php
	    		for($i=0; $i<sizeof($ini_array['calendarList']); $i++){
	    			echo "listado[".$i."]='".$ini_array['calendarList'][$i]."';\n";
	    		}			
	    	?>
	        document.getElementById("doctorCalendar").src=listado[value];
	            	
	    	//Restablecemos los campos
	    	if(value!=0)document.getElementById("datepicker").disabled = false;  
	    	document.getElementById("datepicker").value = '';
	    	document.getElementById("selectDate").disabled = true;
	    	deleteOptions("selectDate");
	    }
    </script>
    
    
    <!-- Configuramos el calendario -->
     <script>
	    $(function() 
	    {
	    	 $( "#datepicker" ).datepicker({ dateFormat: "dd/mm/yy" });
	    	 $( "#datepicker" ).datepicker('option', 'firstDay', 1);
	    	 $( "#datepicker" ).datepicker("option", "minDate", '+1d');
	         
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
		    else if ($.trim(document.getElementById("title").value) == ""){
			    alert("Debes introducir un nombre para la reserva.");
		    }
		    else if ($.trim(document.getElementById("surname").value) == ""){
			    alert("Debes introducir el apellido para la reserva.");
		    }
		    else if ($.trim(document.getElementById("telephone").value).length==0){
			    alert("Debes introducir un telefono para la reserva.");
		    }
		    else if (!validateTelephone(document.getElementById("telephone").value)){
			    alert("Debes introducir un telefono valido para la reserva.");
		    }
		    else if ($.trim(document.getElementById("email").value).length==0){
			    alert("Debes introducir un email para la reserva.");
		    }
		    else if (!validateEmail(document.getElementById("email").value)){
			    alert("Debes introducir un email valido para la reserva.");
		    }
		    else{
			    document.createEvent.eventId.value =document.createEvent.selectDate.options[document.createEvent.selectDate.options.selectedIndex].value;
			    document.createEvent.hour.value =   document.createEvent.selectDate.options[document.createEvent.selectDate.options.selectedIndex].innerHTML;
				document.createEvent.endDateRFormatRFC.value = arrayGlobalDates[document.createEvent.selectDate.options.selectedIndex].endDate;
				document.createEvent.startDateFormatRFC.value = arrayGlobalDates[document.createEvent.selectDate.options.selectedIndex].startDate;
		    	document.createEvent.submit();
		    }
	    }	    
     </script>
     
  	 <script src="js/calendarActions.js"></script>  	 
</head>
<body>
<div class="backgroundSpecial">
<?php if ($isAdmin){?>
	<a class="button" href="javascript: location.href='administracion.php?modo=desconectar';" style="margin-left: 90%">Desconectar</a>
<?php }?>

<h1 class="title" style="margin-left: 5%">Reserva de citas</h1>
<table style="width: 60%;margin-left: 10%">
	<tr>
		<td>
			<span class="explica">El sistema de reserva de citas online &uacute;nicamente permite reservar con un m&iacute;nimo de 24h de antelaci&oacute;n y exige siempre un pago en concepto de reserva. Por este motivo si usted quiere reservar sesi&oacute;n en el mismo d&iacute;a o tiene su sesi&oacute;n de fisioterapia ya abonada (bonos, tarjetas-regalo, etc.) tendr&aacute; que hacer la reserva llamando directamente al centro de Fisioterapia Valdespartera (976 935 739 / 695 701 065).</span>
		</td>
	</tr>
</table>

<form id="createEvent" name="createEvent" method="post" action="confirmar_reserva.php">
	
	<input type="hidden" name="calendar"/>
	<input type="hidden" name="eventId"/>
	<input type="hidden" name="endDateRFormatRFC"/>
	<input type="hidden" name="startDateFormatRFC"/>
	<input type="hidden" name="hour"/>
	
	<br/><br/>
	<table style="width: 100%;">
		<tr>
			<td>
				 <table style="padding-left: 5%;margin-bottom: 45%;">
				 	<tr>
				 		<td> <span class="text">Nombre: </span>  </td>
				 		<td> <input type="text" size="55px" id="title" name="title"  class="required"/> </td>
				 	</tr>
				 	<tr>
				 		<td> <span class="text">Apellidos: </span>  </td>
				 		<td> <input type="text" size="55px" id="surname" name="surname"  class="required"/> </td>
				 	</tr>
				 	<tr>
				 		<td> <span class="text">Telefono: </span>  </td>
				 		<td> <input type="text" size="55px" id="telephone" name="telephone"  class="required"/> </td>
				 	</tr>
				 	<tr>
				 		<td> <span class="text">Email</span>  </td>
				 		<td> <input type="text" size="55px" id="email" name="email"  class="required"/> </td>
				 	</tr>
				 	<tr>
				 		<td>
				 			<span class="text">Seleccione fisio :</span>
				 		</td>
				 		<td>
				 			<select id="calendarCombo" name="calendarCombo" onchange="changeCalendar(this.value);"  class="required">
				 				<?php 
				 					for ($i=0; $i<sizeof($ini_array['namesList']); $i++){
				 						echo '<option value="'. $i .'">'. $ini_array["namesList"][$i] .'</option>';
				 					}
				 				?>
				 			</select>
				 		</td>
				 	</tr>
				 	<tr>
				 		<td> 
				 			<span class="text">Fecha:</span>
				 		</td>
				 		<td>
					 		<input type="text" id="datepicker" name="datepicker" onchange="loadFreeHours(this.value)" disabled="disabled"  class="required" readonly="readonly"/>		 		
				 		</td>
				 		
				 	</tr>
				 	<tr>
				 		<td>
				 			<span class="text">Hora:</span>  
				 		</td>
				 		<td>
				 			<select  id="selectDate" name="selectDate" disabled="disabled"  class="required"></select>
				 		</td>
				 	</tr>
				 	<tr>
				 		<td>
				 		</td>
				 		<td>
				 			 <a style="margin-left:65%;" class="button submit" onclick="javascript:validar();">Reservar</a>
				 		</td>
				 	</tr>
				 </table>
				 <br/><br/>
				 
				
			</td>
			<td style="padding-left: 8%;">
				<table>
				 	<tr>
				 		<td><iframe id="doctorCalendar" src="https://www.google.com/calendar/embed?title=Fisioterapia%20Valdespartera&amp;showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;mode=WEEK&amp;height=600&amp;wkst=2&amp;bgcolor=%23ffffff&amp;src=hv5gfg41m9g2a87kr27uso10p0%40group.calendar.google.com&amp;color=%23B1440E&amp;src=t82rb1fmjt84v4mq2sso91fr7c%40group.calendar.google.com&amp;color=%232F6309&amp;src=fisiocalendar%40gmail.com&amp;color=%232952A3&amp;ctz=Europe%2FMadrid" style=" border-width:0 " width="700" height="600" frameborder="0" scrolling="no"></iframe></td>
				 	</tr>
				 </table>
			</td>
		</tr>
	</table>
	</form>	
 <br/><br/>
 
 </div>
</body>
</html>
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
    
    function changeCalendar(value)
    {
    	// Opcion 0 -> Todos calendarios por defecto
    	if(value == 0)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?title=Fisioterapia%20Valdespartera&amp;showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;mode=WEEK&amp;height=600&amp;wkst=2&amp;bgcolor=%23ffffff&amp;src=hv5gfg41m9g2a87kr27uso10p0%40group.calendar.google.com&amp;color=%23B1440E&amp;src=t82rb1fmjt84v4mq2sso91fr7c%40group.calendar.google.com&amp;color=%232F6309&amp;src=fisiocalendar%40gmail.com&amp;color=%232952A3&amp;ctz=Europe%2FMadrid";
    	if(value == 1)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?src=fisiocalendar%40gmail.com&ctz=Europe/Madrid";
    	if(value == 2)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?src=hv5gfg41m9g2a87kr27uso10p0%40group.calendar.google.com&ctz=Europe/Madrid";
    	if(value == 3)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?src=t82rb1fmjt84v4mq2sso91fr7c%40group.calendar.google.com&ctz=Europe/Madrid";

    	document.createEvent.calendar.value = document.getElementById("calendarCombo").options[document.getElementById("calendarCombo").selectedIndex].text;
    }
    
    </script>
    
    <script>
    var clientId = '555913871761.apps.googleusercontent.com';
    var apiKey = 'AIzaSyAC_gse6kyOwfawjhN1STkE_LkK_pCHHPI';
    var scopes = 'https://www.googleapis.com/auth/calendar';
    
    function handleClientLoad() {
  	  gapi.client.setApiKey(apiKey);
  	  window.setTimeout(checkAuth,1);
  	  checkAuth();
  	}

  	function checkAuth() {
  	  gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true},
  	      handleAuthResult);
  	}

  	function handleAuthResult(authResult) {

  		gapi.client.load('calendar', 'v3', function(){listCalendar();});
  	    
  	  
  	}

  	function handleAuthClick() {
  	  gapi.auth.authorize(
  	      {client_id: clientId, scope: scopes, immediate: false},
  	      handleAuthResult);
  	  return false;
  	}
  	
  	function listCalendar()
  	{
  		var request = gapi.client.calendar.events.list({
  		      'calendarId': 'primary',
  		      'timeMax' : '2012-11-11T23:59:59.000-00:00',
  		      //'timeMin': '2012-11-11T00:00:00.000-00:00',
  		      'timeZone':'Europe/Madrid'
  	    });
  		
  		request.execute(function(resp) {
  			alert(resp);
  			if(resp.items != undefined)
  			{
  			  var arrayOfDates = new Array();
  		      for (var i = 0; i < resp.items.length; i++)
				  {  		    	  
  		    	 arrayOfDates[i] =  createDateObject(resp.items[i]);  		       
  		      }
  		      createSelectWithFreeHours(arrayOfDates)
  			}else
  			{	
  				var dateFinded = createDateObject(resp);
  				createSelectWithFreeHours(dateFinded)
  			} 

  		    });
  		  
  	}
  	
  	function createSelectWithFreeHours(object)
  	{ 		
      	var hoursOfTheDay = new Array();
      	var objectDate;
      	for(var i= 0;i<object.length;i++)
      	{
      		objectDate = object[i];
      		if(objectDate.summary != undefined && objectDate.summary != null && objectDate.summary.indexOf("LIBRE") != -1) 
      			hoursOfTheDay.push(objectDate.hour+":"+objectDate.minutes);
      	}
      	
      	var select = document.getElementById("selectDate");
      	
      	for(i=0;i<hoursOfTheDay.length;i++)
      	{
      		if(hoursOfTheDay[i] != null)
      		{
      			var objOption=document.createElement("option");
          		objOption.innerHTML = hoursOfTheDay[i];
          		objOption.value = hoursOfTheDay[i];
          		select.appendChild(objOption);
      		}
      			
      	}
  	}
  	
  	function createDateObject(resp)
  	{
  		var timeString;
			if(resp.result != undefined)
				timeString = resp.result.updated;
			else
				timeString = resp.updated;
			//Create the dateObject
			var dateObject = {};
			dateObject.hour = timeString.split("T")[1].split(":")[0];
			dateObject.minutes = timeString.split("T")[1].split(":")[1];
			dateObject.day = timeString.split("-")[2].split("T")[0];
			dateObject.month = timeString.split("-")[1];
			dateObject.year = timeString.split("-")[0];
			if(resp.result != undefined)
				dateObject.summary = resp.result.summary;
			else
				dateObject.summary = resp.summary;
			
			return dateObject;
  	}
    	
    </script>
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
	 		<td> Fecha: <input type="text" id="datepicker" name="datepicker"/> Hora: <input type="text" id="hour" name="hour" disabled="disabled"/> </td>
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
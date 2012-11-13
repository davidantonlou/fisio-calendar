<?php
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
    	// Opción 0 -> Todos calendarios por defecto
    	if(value == 0)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?title=Fisioterapia%20Valdespartera&amp;showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;mode=WEEK&amp;height=600&amp;wkst=2&amp;bgcolor=%23ffffff&amp;src=hv5gfg41m9g2a87kr27uso10p0%40group.calendar.google.com&amp;color=%23B1440E&amp;src=t82rb1fmjt84v4mq2sso91fr7c%40group.calendar.google.com&amp;color=%232F6309&amp;src=fisiocalendar%40gmail.com&amp;color=%232952A3&amp;ctz=Europe%2FMadrid";
    	if(value == 1)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?src=fisiocalendar%40gmail.com&ctz=Europe/Madrid";
    	if(value == 2)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?src=hv5gfg41m9g2a87kr27uso10p0%40group.calendar.google.com&ctz=Europe/Madrid";
    	if(value == 3)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?src=t82rb1fmjt84v4mq2sso91fr7c%40group.calendar.google.com&ctz=Europe/Madrid";
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

    		gapi.client.load('calendar', 'v3', function(){addEvent('NUEVO', '2012-10-22T10:00:00.000-07:00','2012-10-22T10:25:00.000-07:00');});
    	    
    	  
    	}

    	function handleAuthClick() {
    	  gapi.auth.authorize(
    	      {client_id: clientId, scope: scopes, immediate: false},
    	      handleAuthResult);
    	  return false;
    	}
    	
    	function addEvent(title, startDateTime, endDateTime)
    	{
    		var resource = {
    			  "summary": title,
    			  "location": "Somewhere",
    			  "start": {
    			    "dateTime": startDateTime
    			  },
    			  "end": {
    			    "dateTime": endDateTime
    			  }
    			};
    			var request = gapi.client.calendar.events.insert({
    			  'calendarId': 'primary',
    			  'resource': resource
    			});
    			request.execute(function(resp) {
    			  console.log(resp);
    			});
    	}
    </script>
     <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
</head>
<body onLoad="javascript:handleAuthClick();">
<div class="background">
<input type="button" value="Desconectar" onclick="javascript: location.href='login.php?modo=desconectar';"/></td>
<h1>Reserva de citas</h1>
<form name="createEvent" type="post">
	 <table>
	 	<tr>
	 		<td>Seleccione doctor :
	 			<select onchange="changeCalendar(this.value);">
	 				<option selected="selected" value="0">-- Selecciona un Fisio</option>
	 				<option value="1">Pablo</option>
	 				<option value="2">Jose</option>
	 				<option value="3">Maria</option>
	 			</select>
	 		</td>
	 	</tr>
	 	<tr width="50px">
	 		<td> Fecha: <input type="text" id="datepicker" /> Hora: <input type="text" id="hour" /> </td>
	 	</tr>
	 	<tr>
	 		<td> Nombre: <input type="text" size="55px" id="title" /> </td>
	 	</tr>
	 	<tr>
	 		<td> Anotaciones adicionales: <textarea id="description" style="resize: none;" cols="25" rows="2"></textarea>
	 	</tr>
	 	<tr>
	 		<td><input type="button" value="Reservar" onclick=""/></td>
	 	</tr>
	 </table>
 </form>
 <table>
 	<tr>
 		<td><iframe id="doctorCalendar" src="https://www.google.com/calendar/embed?title=Fisioterapia%20Valdespartera&amp;showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;mode=WEEK&amp;height=600&amp;wkst=2&amp;bgcolor=%23ffffff&amp;src=hv5gfg41m9g2a87kr27uso10p0%40group.calendar.google.com&amp;color=%23B1440E&amp;src=t82rb1fmjt84v4mq2sso91fr7c%40group.calendar.google.com&amp;color=%232F6309&amp;src=fisiocalendar%40gmail.com&amp;color=%232952A3&amp;ctz=Europe%2FMadrid" style=" border-width:0 " width="800" height="600" frameborder="0" scrolling="no"></iframe></td>
 		<td style="padding-left:30px;">
 			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
			<div class="fb-comments" data-href="http://www.fisioterapiavaldespartera.com" data-num-posts="5" data-width="300"></div>
 		</td>
 	</tr>
 </table>

 
 </div>
</body>
</html>
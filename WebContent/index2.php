<?php 


	$path = '/Zend/library';
	$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	require_once 'Zend/Loader.php';
	Zend_Loader::loadClass('Zend_Gdata');
	Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
	Zend_Loader::loadClass('Zend_Gdata_Calendar');
	// User whose calendars you want to access
	$user = 'fisiocalendar@gmail.com';
	$pass = 'fisiofisio';
	$serviceName = Zend_Gdata_Calendar::AUTH_SERVICE_NAME; // predefined service name for calendar
	$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $serviceName);
	$service = new Zend_Gdata_Calendar($client);


	
	$event= $service->newEventEntry();
	
	// Create a new title instance and set it in the event
	$event->title = $service->newTitle("Some Event");
	// Where attribute can have multiple values and hence passing an array of where objects
	$event->where = array($service->newWhere("Nagpur, India"));
	$event->content = $service->newContent("Some event content.");
	
	// Create an object of When and set start and end datetime for the event
	$when = $service->newWhen();
	// Set start and end times in RFC3339 (http://www.ietf.org/rfc/rfc3339.txt)
	$when->startTime = "2012-11-19T16:30:00.000+05:30"; // 8th July 2010, 4:30 pm (+5:30 GMT)
	$when->endTime = "2012-11-19T17:30:00.000+05:30"; // 8th July 2010, 5:30 pm (+5:30 GMT)
	// Set the when attribute for the event
	$event->when = array($when);
	
	// Create the event on google server
	$newEvent = $service->insertEvent($event);
	// URI of the new event which can be saved locally for later use
	$eventUri = $newEvent->id->text;
	

?>

 
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Fisioterapia Valdespartera</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <script src="http://jquery-ui.googlecode.com/svn/trunk/ui/i18n/jquery.ui.datepicker-es.js"></script>
    <!-- <script src="js/users_calendars.js"></script>
    <script src="js/calendar.js"></script> -->

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
    	if(value!=0)document.getElementById("datepicker").disabled = false;   	
    	document.getElementById("selectDate").disabled = true;
    }
    
    </script>
    
    <script>
    var authorized = false;
    var clientId = '92001327095.apps.googleusercontent.com';
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
    	
    	function handleAuthClick() {
      	  gapi.auth.authorize(
      	      {client_id: clientId, scope: scopes, immediate: false},
      	      handleAuthResult);
      	  return false;
      	}

    	function handleAuthResult(authResult) {

    	//	gapi.client.load('calendar', 'v3', function(){listCalendar();});
    	   authorized = true; 
    	  
    	}
    	
    	
    	function loadFreeHours(day,calendar)
		{
    		deleteOptions("selectDate")
			if(authorized == true)
			{
				var dateObject = transformToDateObejct(day);				
				gapi.client.load('calendar', 'v3', function(){listCalendar(dateObject);});
			}else{
				console.log("Not authorized in google accounts");
				handleClientLoad();
				alert("Se ha producido un error permita las ventanas de esta pagina y espere unos segundos");
			}
		}
    	
    	function transformToDateObejct(day){
    		var dateObject = {};
			dateObject.day = day.split("/")[1];
			dateObject.month = day.split("/")[0];
			dateObject.year = day.split("/")[2];
			if(document.createEvent.calendar.value == 1) dateObject.calendar = "fisiocalendar@gmail.com";
			if(document.createEvent.calendar.value == 2) dateObject.calendar = "hv5gfg41m9g2a87kr27uso10p0@group.calendar.google.com";
			if(document.createEvent.calendar.value == 3) dateObject.calendar = "t82rb1fmjt84v4mq2sso91fr7c@group.calendar.google.com";
			
			return dateObject;
    	}
    	
    	
    	
    	function listCalendar(dayObject)
    	{
    		var request = gapi.client.calendar.events.list({
    		      'calendarId': dayObject.calendar,
    		      'timeMax' : dayObject.year+'-'+dayObject.month+'-'+dayObject.day+'T23:59:59.000+01:00',
    		      'timeMin' : dayObject.year+'-'+dayObject.month+'-'+dayObject.day+'T00:00:00.000+01:00',
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
			select.disabled = false;
    	}
    	
    	function createDateObject(resp)
    	{
    		var timeString;
			if(resp.result != undefined)
				timeString = resp.result.start.dateTime;
			else
				timeString = resp.start.dateTime;
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
    	
    	function getFinshHour(hour)
    	{
    		var minutes = hour.split(":")[1];
    		var newMinutesInt= parseInt(minutes);
    		newMinutesInt+= 45;
    		return hour.split(":")[0]+":"+newMinutesInt;
    	}
    	
    	function createReserve(){
    		var date = transformToDateObejct(document.getElementById("datepicker").value);
    		var hour = getSelectedOption("selectDate");
    		var finshHour = getFinshHour(hour);
    		
    		var startDateTime = date.year+'-'+date.month+'-'+date.day+'T'+hour+':00.000+01:00';
    		var endDateTime = date.year+'-'+date.month+'-'+date.day+'T'+finshHour+':00.000+01:00';
    		var title = document.getElementById("title").value;
    		addEvent(title,startDateTime,endDateTime,date.calendar)
    	}
    	function addEvent(title, startDateTime, endDateTime,idCalendar)
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
    			var request = gapi.client.calendar.events.update({
    			  'calendarId': idCalendar,
    			  'resource': resource
    			});
    			request.execute(function(resp) {
    			  console.log(resp);
    			  changeCalendar(document.createEvent.calendar.value);
    			});
    	}
    	function getSelectedOption(id)
    	{
    		var select = document.getElementById(id);
    		return select.options[select.selectedIndex].value;
    	}
    	function deleteOptions(id)
    	{
    		document.getElementById(id).options.length = 0;
    	}
    </script>
     <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
</head>
<body onLoad="javascript:handleAuthClick();">
<div class="background">
<h1>Reserva de citas</h1>
<form name="createEvent" type="post">
<div >
<h1>Events</h1>
      <ul id='events'></ul>
</div>
	 <table>
	 	<tr>
	 		<td>Seleccione doctor :
	 			<select name="calendar" onchange="changeCalendar(this.value);">
	 				<option selected="selected" value="0">-- Selecciona un Fisio</option>
	 				<option value="1">Pablo</option>
	 				<option value="2">Jose</option>
	 				<option value="3">Maria</option>
	 			</select>
	 		</td>
	 	</tr>
	 	<tr width="50px">
	 		<td> Fecha: <input disabled="disabled" type="text" id="datepicker" onchange="loadFreeHours(this.value)" /> Hora: <select id="selectDate" disabled="disabled"></select> </td>
	 	</tr>
	 	<tr>
	 		<td> Nombre: <input type="text" size="55px" id="title" /> </td>
	 	</tr>
	 	<tr>
	 		<td> Anotaciones adicionales: <textarea id="description" style="resize: none;" cols="25" rows="2"></textarea>
	 	</tr>
	 	<tr>
	 		<td><input type="button" value="Reservar" onclick="createReserve();"/></td>
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
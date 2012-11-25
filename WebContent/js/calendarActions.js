
	//Global variables
    var clientId = '555913871761.apps.googleusercontent.com';
    var apiKey = 'AIzaSyAC_gse6kyOwfawjhN1STkE_LkK_pCHHPI';
    var scopes = 'https://www.googleapis.com/auth/calendar';
    
    
    //Cambia el los calendarios
    function changeCalendar(value)
    {
    	// Opci—n 0 -> Todos calendarios por defecto
    	if(value == 0)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?title=Fisioterapia%20Valdespartera&amp;showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;mode=WEEK&amp;height=600&amp;wkst=2&amp;bgcolor=%23ffffff&amp;src=hv5gfg41m9g2a87kr27uso10p0%40group.calendar.google.com&amp;color=%23B1440E&amp;src=t82rb1fmjt84v4mq2sso91fr7c%40group.calendar.google.com&amp;color=%232F6309&amp;src=fisiocalendar%40gmail.com&amp;color=%232952A3&amp;ctz=Europe%2FMadrid";
    	if(value == 1)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?src=fisiocalendar%40gmail.com&ctz=Europe/Madrid";
    	if(value == 2)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?src=hv5gfg41m9g2a87kr27uso10p0%40group.calendar.google.com&ctz=Europe/Madrid";
    	if(value == 3)document.getElementById("doctorCalendar").src="https://www.google.com/calendar/embed?src=t82rb1fmjt84v4mq2sso91fr7c%40group.calendar.google.com&ctz=Europe/Madrid";
    	
    	//Restablecemos los campos
    	if(value!=0)document.getElementById("datepicker").disabled = false;  
    	document.getElementById("datepicker").value = '';
    	document.getElementById("selectDate").disabled = true;
    	deleteOptions("selectDate");
    }
    
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
		deleteOptions("selectDate");
		var dateObject = transformToDateObejct(day);				
		gapi.client.load('calendar', 'v3', function(){listCalendar(dateObject);});
	}
    	
    function transformToDateObejct(day)
    {  	
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
			if(resp.items != undefined)
			{
			  var arrayOfDates = new Array();
		      for (var i = 0; i < resp.items.length; i++)
			  {  		    	  
		    	 arrayOfDates[i] =  createDateObject(resp.items[i]);  		       
		      }
		      createSelectWithFreeHours(arrayOfDates);
			}else
			{	
				var dateFinded = createDateObject(resp);
				createSelectWithFreeHours(dateFinded);
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
    	
	function createReserve()
	{
		var date = transformToDateObejct(document.getElementById("datepicker").value);
		var hour = getSelectedOption("selectDate");
		var finshHour = getFinshHour(hour);
		
		var startDateTime = date.year+'-'+date.month+'-'+date.day+'T'+hour+':00.000+01:00';
		var endDateTime = date.year+'-'+date.month+'-'+date.day+'T'+finshHour+':00.000+01:00';
		var title = document.getElementById("title").value;
		addEvent(title,startDateTime,endDateTime,date.calendar);
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
			var request = gapi.client.calendar.events.insert({
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

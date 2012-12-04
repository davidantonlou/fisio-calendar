
	//Global variables
    var apiKey = 'AIzaSyAC_gse6kyOwfawjhN1STkE_LkK_pCHHPI';
    
    //Carga las horas libres 
    function loadFreeHours(day,calendar)
	{
		deleteOptions("selectDate");
		var dateObject = transformToDateObejct(day);				
		listCalendar(dateObject);
	}
    
    //Convierte un string de la fecha del select en un objeto de tipo date
    function transformToDateObejct(day)
    {  	
		var dateObject = {};
		dateObject.day = day.split("/")[0];
		dateObject.month = day.split("/")[1];
		dateObject.year = day.split("/")[2];
		
		if(document.createEvent.calendarCombo.value == 1) dateObject.calendar = "fisiocalendar@gmail.com";
		if(document.createEvent.calendarCombo.value == 2) dateObject.calendar = "hv5gfg41m9g2a87kr27uso10p0@group.calendar.google.com";
		if(document.createEvent.calendarCombo.value == 3) dateObject.calendar = "t82rb1fmjt84v4mq2sso91fr7c@group.calendar.google.com";
		
		return dateObject;
    }
    	
  //Lista los eventos del calendario
	function listCalendar(dayObject)
	{
		var requestParameters =
		{
		      'timeMax' : dayObject.year+'-'+dayObject.month+'-'+dayObject.day+'T23:59:59.000+01:00',
		      'timeMin' : dayObject.year+'-'+dayObject.month+'-'+dayObject.day+'T00:00:00.000+01:00',
		      'timeZone':'Europe/Madrid'
	    };

		var request = $.ajax({
			  url: 'https://www.googleapis.com/calendar/v3/calendars/'+encodeURIComponent(dayObject.calendar)+'/events?timeMax='+encodeURIComponent(requestParameters.timeMax)+'&timeMin='+encodeURIComponent(requestParameters.timeMin)+'&key='+apiKey,
			  type: "GET",
			  beforeSend: function ( xhr ) {xhr.overrideMimeType("application/json"); },
			});

			request.done(
					function(resp) {
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

					    }		
			);

			request.fail(function(jqXHR, textStatus) {
			  console.log( "Request failed: " + textStatus );
			  alert("Ha ocurrido un error vuelva a intentarlo de nuevo");
			});
		
		
		  
	}
    	
	function createSelectWithFreeHours(object)
	{ 		
    	var objectDate;
    	var select = document.getElementById("selectDate");
    	for(var i= 0;i<object.length;i++)
    	{
    		objectDate = object[i];
    		if(objectDate.summary != undefined && objectDate.summary != null && objectDate.summary.indexOf("LIBRE") != -1)
    		{
    			var objOption=document.createElement("option");
        		objOption.innerHTML = objectDate.hour+":"+objectDate.minutes;
        		objOption.value = objectDate.id;
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
		{
			dateObject.summary = resp.result.summary;
			dateObject.id = rep.result.id;
		}else{
			dateObject.summary = resp.summary;
			dateObject.id = resp.id;
		}
			
		
		return dateObject;
	}
    	
	function getFinshHour(hour)
	{
		var minutes = hour.split(":")[1];
		var newMinutesInt= parseInt(minutes);
		newMinutesInt+= 45;
		return hour.split(":")[0]+":"+newMinutesInt;
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
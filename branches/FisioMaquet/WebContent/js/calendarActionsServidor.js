
	//Global variables
    var apiKey = 'AIzaSyCNktjV9zBXqVpfXh_b4mixfhlLIZZPU_E';
    var arrayGlobalDates;
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
		var valueCalendarCombo = getSelectedOption("calendarCombo");
		if(valueCalendarCombo == 1) dateObject.calendar = "fisioterapiavaldespartera.es_peqjduu5k98ck3imq4j6ttpcls@group.calendar.google.com" ;//Angel
		if(valueCalendarCombo == 2) dateObject.calendar = "uq4ekv100c8dhvqbbaghj2vno0%40group.calendar.google.com" ;//Pablo
		if(valueCalendarCombo == 3) dateObject.calendar = "fisioterapiavaldespartera.es_amm58uvk6guook08ulfvbbdgtc@group.calendar.google.com" ;//Javi
		if(valueCalendarCombo == 4) dateObject.calendar = "fisioterapiavaldespartera.es_jnptk0j0e6vk2fvsmkb5i5u4j0@group.calendar.google.com" ;//Juanan
		if(valueCalendarCombo == 5) dateObject.calendar = "fisioterapiavaldespartera.es_3jp88fldi6aepm6p3cvpkffn50@group.calendar.google.com" ;//Mapi
		if(valueCalendarCombo == 6) dateObject.calendar = "fisioterapiavaldespartera.es_2id3c2eid2tv9adlci8r82m0i8@group.calendar.google.com" ;//Victor
		if(valueCalendarCombo == 7) dateObject.calendar = "fisioterapiavaldespartera.es_pce2rbmv9vmp03jcoqm51pqf18@group.calendar.google.com" ;//Raul
		
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
						 arrayGlobalDates = new Array();
						if(resp.items != undefined)
						{
						  var arrayOfDates = new Array();						
					      for (var i = 0; i < resp.items.length; i++)
						  {  		    	  
					    	  var object = createDateObject(resp.items[i]);
					    	  if(object!=null) arrayOfDates.push(object); 		       
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
    	var j=0;
    	for(var i= 0;i<object.length;i++)
    	{
    		objectDate = object[i];
    		if(objectDate.summary != undefined && objectDate.summary != null && objectDate.summary.indexOf("LIBRE") != -1)
    		{
    			arrayGlobalDates[j] = objectDate;
    			j++;
    			var objOption=document.createElement("option");
        		objOption.innerHTML = objectDate.hour+":"+objectDate.minutes;
        		objOption.value = objectDate.id;
        		select.appendChild(objOption);
    		}

    	}

    	if(select.length>0)	select.disabled = false;
	}
    	
	function createDateObject(resp)
	{
		var timeString = null;
		var dateObject = {};
		if(resp.status != "cancelled")
		{
			if(resp.result != undefined )
			{
				timeString = resp.result.start.dateTime;
				if(resp.result.visibility != undefined 
						&& resp.result.visibility != null && resp.result.visibility == "private")
				{
					//Si es privado no lo queremos ver
					return null;
				}
			}else
			{
				if(resp.visibility != undefined && resp.visibility != null
						&& resp.visibility == "private")
				{
					//Si es privado no lo queremos ver
					return null;
				}
				timeString = resp.start.dateTime;
			}
			//Create the dateObject
			
				dateObject.hour = timeString.split("T")[1].split(":")[0];
				dateObject.minutes = timeString.split("T")[1].split(":")[1];
				dateObject.day = timeString.split("-")[2].split("T")[0];
				dateObject.month = timeString.split("-")[1];
				dateObject.year = timeString.split("-")[0];
				
				dateObject.startDate = timeString;
				
				if(resp.result != undefined)
				{
					dateObject.summary = resp.result.summary;
					dateObject.id = rep.result.id;
					dateObject.endDate = resp.resutl.end.dateTime; 				
				}else{
					dateObject.summary = resp.summary;
					dateObject.id = resp.id;
					dateObject.endDate = resp.end.dateTime; 
				}
		}else{
			return null;
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

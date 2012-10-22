/*******************************************************
 * 
 * Librería de funciones para la API de Google Calendar
 * 
 *******************************************************/

var clientId = '555913871761.apps.googleusercontent.com';
var apiKey = 'AIzaSyAC_gse6kyOwfawjhN1STkE_LkK_pCHHPI';
var scopes = 'https://www.googleapis.com/auth/calendar';

// Comprueba si el cliente esta autorizado
function checkAuth() {
	gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true},
    handleAuthResult);
}

// Inicializamos el cliente con la API Key
function handleClientLoad() {
	gapi.client.setApiKey(apiKey);
	window.setTimeout(checkAuth,1);
	checkAuth();
}

// Resultado de la autentificación
function handleAuthResult(authResult) {
	gapi.client.load('calendar', 'v3', function(){addEvent();});
}

// Autorización al hacer click
function handleAuthClick(event) {
	gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false},handleAuthResult);
	return false;
}

// Añadir un evento al calendario
// ** Date: yyyy-mm-dd
// ** Time: hh:mm:ss
// ** TimeZone: Europe/Madrid
// ** Visibility: default, public, private, confidential
function addEvent(calendarId, title, description, location, startDate, startHour, endDate, endHour, timeZone, visibility){
	var resource = {
			"summary": title,
			"description": description,
			"location": location,
			"start": {
				"date": startDate,
				"dateTime": startHour,
				"timeZone": timeZone
			},
			"end": {
				"date": endDate,
				"dateTime": endHour,
				"timeZone": timeZone
			},
			"visibility": visibility
		};
	var request = gapi.client.calendar.events.insert({
		'calendarId': calendarId,
		'resource': resource
	});
	request.execute(function(resp) {
	  	console.log(resp);
	});
	
}

// Eliminar un evento del calendario
function deleteEvent(){
	
	
}

// Modificar un evento
function updateEvent(){
	
	
}

// Listar los eventos de un calendario
function listEvents(){
	
	
}



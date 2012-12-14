<?php

		session_start();
		$ini_array = parse_ini_file("config.ini");
		
        $isAdmin=false;
        if (isset($_SESSION['user']))
                $isAdmin=true;
       
        if (!$isAdmin){
                // Recogemos el resultado del pago
                $compra = $_GET["compra"];       // compra ->   si / no
                $moneda = $_GET["moneda"];       // moneda ->   978 Euros
                $numpedido = $_GET["numpedido"]; // numpedido -> Campo numerico de 4 a 12 posiciones que indica el numero del pedido de la tienda
                $fecha = $_GET["fecha"];         // fecha -> AAMMDDhhmmss
                $firma = $_GET["firma"];         // firma -> Campo de 40 posiciones alfanumericas.
                                                 //          si el campo compra devuelto vale si
                                                 //          cadena = 0+CIP+numpedido+importe+fecha;
                                                 //          y si el campo compra devuelto vale no
                                                 //          cadena = 1+CIP+numpedido+importe+fecha;
        }
                                                             
        // Recogemos de sesion el detalle de la cita
        $title = $_SESSION["title"];
        $description = $_SESSION["description"];
        $startDate = $_SESSION["startDate"];
        $startTime = $_SESSION["startTime"];
        $eventId = $_SESSION["eventId"];
		$calendar = $_SESSION["calendar"];
		$idFisio = $_SESSION["calendar"];
		$endDateRFC = 	$_SESSION["endDateRFormatRFC"];
		$startDateRFC = $_SESSION["startDateFormatRFC"];
        
        if ($isAdmin || $compra == "si"){ // El pago se ha realizado correctamente
        	if (!$isAdmin){
	        	// Actualizamos el numero de pedido y lo ponemos como pagado
	        	mysql_query("UPDATE pedidos SET pagado='true' WHERE numpedido = ". $numpedido ."");
        	}

        	$path = '/Zend/library';
	        $oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	        require_once 'Zend/Loader.php';
	        Zend_Loader::loadClass('Zend_Gdata');
	        Zend_Loader::loadClass('Zend_Gdata_AuthSub');
	        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
	        Zend_Loader::loadClass('Zend_Gdata_HttpClient');
	        Zend_Loader::loadClass('Zend_Gdata_Calendar');
	        	
	   
	        // User whose calendars you want to access
	        $user = $ini_array["adminCalendar"];
	        $pass = $ini_array["passCalendar"];
   	
	        $serviceName = Zend_Gdata_Calendar::AUTH_SERVICE_NAME; // predefined service name for calendar
	        $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $serviceName);
	        $service = new Zend_Gdata_Calendar($client);
	        	
	        $eventURI = "http://www.google.com/calendar/feeds/".$ini_array['fisioGooglId'][$idFisio-1]."/private/full/".$eventId;
	        	
	        	
	        try
	        {
		       	// Get the event
				$event = $service->getCalendarEventEntry($eventURI);
	
				$when = $service->newWhen();
				// Set start and end times in RFC3339 (http://www.ietf.org/rfc/rfc3339.txt)
				$when->startTime = $startDateRFC; // 8th July 2010, 4:30 pm (+5:30 GMT)
				$when->endTime = $endDateRFC; // 8th July 2010, 5:30 pm (+5:30 GMT)
				// Set the when attribute for the event
				$event->when = array($when);
						        	
				$borradoCorrecto = true;
			
        	
        		$service->delete($event->getEditLink()->href);
        	} catch (Exception $e) {
        		$borradoCorrecto = false;
        	}
	        	
				
       		if($borradoCorrecto == true){
       		    $eventToInsert= $service->newEventEntry();
       		    //Creamos un nuevo Evento 
       		    $eventToInsert->title = $service->newTitle($title);
				$eventToInsert->content = $service->newContent($description);
				$eventToInsert->visibility = $service->newVisibility("http://schemas.google.com/g/2005#event.private");
				$when2 = $service->newWhen();
					$when2->startTime = $startDateRFC; // 8th July 2010, 4:30 pm (+5:30 GMT)					
					$when2->endTime = $endDateRFC; // 8th July 2010, 5:30 pm (+5:30 GMT)
				$eventToInsert->when = array($when2);
					
				try{
					// Create the event on google server
					$newEvent = $service->insertEvent($eventToInsert);
					header('Location: outcome.php');
						 
					session_unset();
					session_destroy();
						 
				}catch(Exception $e)
				{
					echo "<script>alert('Ha ocurrido un error insertando en el calendario ')</script>";
				}
					
			}
       		    
	        	
        }
        else{ // Ha ocurrido un erro al realizar el pago
                echo "<script>alert('Ha ocurrido un error al realizar el pago.')</script>";
                session_unset();
                session_destroy();
        }

        
        
        
        function updateEvent ($client, $eventId, $newTitle)
        {
        	$gdataCal = new Zend_Gdata_Calendar($client);
        	if ($eventOld = getEvent($client, $eventId)) {
        		/* echo "Old title: " . $eventOld->title->text . "<br />\n";*/
        		$eventOld->title = $gdataCal->newTitle($newTitle);
        		$eventOld->setVisibility('private');
        		try {
        			$eventOld->save();
        		} catch (Zend_Gdata_App_Exception $e) {
        			var_dump($e);
        			return null;
        		}
        		$eventNew = getEvent($client, $eventId);
        		/* echo "New title: " . $eventNew->title->text . "<br />\n";*/
        		return $eventNew;
        	} else {
        		return null;
        	}
        }
        
        function getEvent($client, $eventId)
        {
        	$gdataCal = new Zend_Gdata_Calendar($client);
        	$query = $gdataCal->newEventQuery();
        	//$query->setUser('default');
        	//$query->setVisibility('private');
        	//$query->setProjection('full');
        	$query->setEvent($eventId);
        
        	try {
        		$eventEntry = $gdataCal->getCalendarEventEntry($query);
        		return $eventEntry;
        	} catch (Zend_Gdata_App_Exception $e) {
        		var_dump($e);
        		return null;
        	}
        }
        
        function deleteEventById ($client, $eventId)
        {
        	$event = getEvent($client, $eventId);
        	$event->delete();
        }
?>


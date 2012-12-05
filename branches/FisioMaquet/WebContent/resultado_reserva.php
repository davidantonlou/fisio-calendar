<?php

		session_start();
		
        $isAdmin=false;
        if (isset($_SESSION['user']))
                $isAdmin=true;
       
        if (!$isAdmin){
                // Recogemos el resultado del pago
                $compra = $_GET["compra"];       // compra ->   si / no
                $moneda = $_GET["moneda"];       // moneda ->   978 Euros
                $numpedido = $_GET["numpedido"]; // numpedido -> Campo numérico de 4 a 12 posiciones que indica el número del pedido de la tienda
                $fecha = $_GET["fecha"];         // fecha -> AAMMDDhhmmss
                $firma = $_GET["firma"];         // firma -> Campo de 40 posiciones alfanuméricas.
                                                  //          si el campo compra devuelto vale si
                                                  //          cadena = 0+CIP+numpedido+importe+fecha;
                                                  //          y si el campo compra devuelto vale no
                                                  //          cadena = 1+CIP+numpedido+importe+fecha;
        }
                                                             
        // Recogemos de sesión el detalle de la cita
        $title = $_SESSION["title"];
        $description = $_SESSION["description"];
//         $startTime = $_SESSION["startTime"];
//         $endTime = $_SESSION["endTime"];
//         $calendar = $_SESSION["calendar"];
//         $private = $_SESSION["private"];
        $eventId = $_SESSION["eventId"];
                                                                         
        if ($isAdmin || $compra == "si"){ // El pago se ha realizado correctamente
        	if (!$isAdmin){
	        	// Actualizamos el n�mero de pedido y lo ponemos como pagado
	        	mysql_query("UPDATE pedidos SET pagado='true' WHERE numpedido = ". $numpedido ."");
        	}
        	
                // TODO: Realizar inserción en el calendario!!!
                // TODO: Enviar mail al fisio
                // TODO: Mostrar pantalla de okey
	        	
        		$path = '/Zend/library';
	        	$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	        	require_once 'Zend/Loader.php';
	        	require_once '/Zend/library/Zend/Gdata/Calendar/CalendarActions.php';
	        	Zend_Loader::loadClass('Zend_Gdata');
	        	Zend_Loader::loadClass('Zend_Gdata_AuthSub');
	        	Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
	        	Zend_Loader::loadClass('Zend_Gdata_HttpClient');
	        	Zend_Loader::loadClass('Zend_Gdata_Calendar');
	        	Zend_Loader::loadClass('CalendarActions');
	        	
	        	// User whose calendars you want to access
	        	$user = 'fisiocalendar@gmail.com';
	        	$pass = 'fisiofisio';
   	
	        	$serviceName = Zend_Gdata_Calendar::AUTH_SERVICE_NAME; // predefined service name for calendar
	        	$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $serviceName);
	        	$service = new Zend_Gdata_Calendar($client);
	        	$actions = new CalendarActions();
	        	
	        	$event = $actions->updateEvent ($client, $eventId, $title);
	        	
       		    if ($event != null) {
	
	        		echo "<script>alert('Se ha reservado correctamente')</script>";
	        		
	        		session_unset();
	        		session_destroy();
	        		
	        	} else {
	        		echo "<script>alert('Ha ocurrido un error insertando en el calebdarui ')</script>";
                	session_unset();
                	session_destroy();
	        	}
	        	
	        	
        }
        else{ // Ha ocurrido un erro al realizar el pago
                // TODO: Mostrar pantalla de error
                 echo "<script>alert('Ha ocurrido un error reservado ')</script>";
                session_unset();
                session_destroy();
        }

?>


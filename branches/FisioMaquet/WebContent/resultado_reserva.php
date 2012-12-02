<!--
        Realizar inserción de la cita (JOSE)
        Mostrar que todo ha ido OK/ERROR (JOSE)
        Enviar mail al fisio administrador (DAVID)
        Borrar datos de sesión (DAVID)          
-->

<?php
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
        $startTime = $_SESSION["startTime"];
        $endTime = $_SESSION["endTime"];
        $calendar = $_SESSION["calendar"];
        $private = $_SESSION["private"];
       
                                                                         
        if ($isAdmin || $compra == "si"){ // El pago se ha realizado correctamente
        	// Actualizamos el n�mero de pedido y lo ponemos como pagado
        	mysql_query("UPDATE pedidos SET pagado='true' WHERE numpedido = ". $numpedido ."");
        	
                // TODO: Realizar inserción en el calendario!!!
                // TODO: Enviar mail al fisio
                // TODO: Mostrar pantalla de okey
                <script>
                	alert("La reserva se ha realizado correctamente");
                </script>
                session_unset();
                session_destroy();
        }
        else{ // Ha ocurrido un erro al realizar el pago
                // TODO: Mostrar pantalla de error
                 <script>
                	alert("Ha habido un error al procesar su pago, por favor vuelva a intentarlo");
                </script>
                session_unset();
                session_destroy();
        }

?>


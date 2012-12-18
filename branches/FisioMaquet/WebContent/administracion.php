<?php

		session_start();
   		include_once("datos_conexion.php");
   		
   		ini_set('display_errors', 0);
    
   		if(isset($_POST['modo']) == 'desconectar'){
   			session_unset();
   			session_destroy();
   		}
   	   	   		
   		if(isset($_POST['user']) && isset($_POST['pass']))
   		{  			
   			$user= $_POST['user'];
   			$pass= $_POST['pass'];
   			$b_user=mysql_query("SELECT * FROM usuarios WHERE USER_FISIO='".$user."'");
   			$ses = @mysql_fetch_assoc($b_user);
   			if(@mysql_num_rows($b_user)){
   				if($ses["PASS"] == sha1($pass)){
   					$logger->info("Login: " . $ses["USER_FISIO"]);
   					$_SESSION['id']= $ses["ID"];
   					$_SESSION['user']= $ses["USER_FISIO"];
   					header('Location: reservar_cita.php');
   				}
   				else{
   					header('Location: administracion.php');
   					echo 'Nombre de Usuario o contrase&#241;a incorrecta.';
   				}
   			}
   			else{
   				header('Location: administracion.php');
   				echo 'Nombre de Usuario o contrase&#241;a incorrecta.';
   			}
   		}
   ?>
   
   <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    <head>
	    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	    <title>Administraci&#243;n</title>
	    <link rel="stylesheet" href="css/calendarStyle.css"> 
	    <script type="text/javascript" src="js/login.js"></script>  
    </head>
    <body>  
    <div  class="background">
    	<div class="center" style="margin-top: 15%;margin-left: 25%;">
   		 	<h1 class="title">Administraci&#243;n Fisioterapia Valdespartera</h1>
    	</div>
        <form name="login_user" action="administracion.php" method="post" >
        
        	<table style="margin-left:38%; margin-right:60%;margin-top:5%">
        	<tr>
            <td><span class="text">Usuario:</span></td>
            <td><input type='text' id='user' name='user'/></td>
            </tr>
            <tr>
            <td><span class="text">Contrase&#241;a:</span></td>
           	<td> <input type="password" id='pass' name='pass' /></td>
           	</tr>
           	<tr>
           		<td><br/></td>
           	</tr>
           	<tr>
           		<td></td>
           		<td>
           		 <a style="margin-left:50%" class="button" onclick="javascript:doLogin();">Entrar</a>
           		</td>
           		<td>
           		 <a style="margin-left:20%" class="button" onclick="javascript:clearLoginFields();">Limpiar</a>
           		</td>
           	</tr>
        	</table>
           
        </form>
    </div>
    </body>
    </html>
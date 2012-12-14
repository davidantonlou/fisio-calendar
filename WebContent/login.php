<?php

		session_start();
   		include("datos_conexion.php");
    
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
   					$_SESSION['id']= $ses["ID"];
   					$_SESSION['user']= $ses["USER_FISIO"];
   					header('Location: reservar_cita.php');
   				}
   				else{
   					header('Location: login.php');
   					echo 'Nombre de Usuario o contrase&#241;a incorrecta.';
   				}
   			}
   			else{
   				header('Location: login.php');
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
    
    </head>
    <body>
    <h1 class="title">Administraci&#243;n Fisioterapia Valdespartera</h1>
    <div padding-left="20px"  class="background">
        <form name="login_user" action="login.php" method="post" >
        
        	<table style="margin-left:30%; margin-right:60%;">
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
           		<td>&nbsp;</td>
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
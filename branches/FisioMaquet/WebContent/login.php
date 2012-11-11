   <?php 
   		include("datos_conexion.php");
    
   		if(isset($_POST['modo']) == 'desconectar')
   			session_destroy();
   	   		
   		if(isset($_POST['login'])){
   			session_start();
   			session_regenerate_id();
   			$user= $_POST['user'];
   			$pass= $_POST['pass'];
   			$b_user=mysql_query("SELECT * FROM usuarios WHERE user='".$user."'");
   			$ses = @mysql_fetch_assoc($b_user) ;
   			if(@mysql_num_rows($b_user)){
   				if($ses['pass'] == $pass){
   					session_register("id");
   					session_register("user");
   					$_SESSION["id"]= $ses["id"];
   					$_SESSION["user"]= $ses["user"];
   					header('Location: reservar_cita.php');
   				}
   				else{
   					header('Location: login.php');
   				}
   			}
   			else{
   				header('Location: login.php');
   			}
   		}
   ?>
   
   <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Administraci&#243;n</title>
    
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
    <h2>Administraci&#243;n Fisioterapia Valdespartera</h2>
    <div padding-left="20px"  class="background">
        <form name="login_user" action="" method="post" >
            <td><label>Usuario:</label></td>
            <input type='text' id='user' name='user'/><br /><br />
            <td><label>Contrase&#241;a:</label></td>
            <input type="password" id='pass' name='pass' /><br /><br />
           
            <input type="submit" name="login" style="width:100px;" tabindex="6" value="Entrar" />
            <input type="reset" name="Limpiar" style="width:100px;" tabindex="6" value="Limpiar" />
        </form>
    </div>
    </body>
    </html>
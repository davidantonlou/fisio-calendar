    <?php
    include("datos_conexion.php");
    
    if(isset($_POST['login'])){
        $user= $_POST['user'];
        $pass= md5(md5($_POST['pass']));
        $b_user=mysql_query("SELECT * FROM usuarios WHERE user='$user'");   
        $ses = @mysql_fetch_assoc($b_user) ;
        if(@mysql_num_rows($b_user)){
            if($ses['pass'] == $pass){
                $_SESSION['id']= $ses["id"];
                $_SESSION['user']= $ses["user"];
            }
            else echo 'Nombre de usuario o contrase&#241;a incorrecta.';
        }
        else echo 'Nombre de Usuario o contrase&#241;a incorrecta.';
    }
       
    if(isset($_GET['modo']) == 'desconectar'){
    	session_destroy();
    	window.location='login.php';

    }
       
    if(isset($_SESSION['id'])){
        window.location='index.php';
    }
    else
    {
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
        <form name="login_user" action="login.php" method="post" />
            <dt><label>Usuario:</label></dt>
            <input type='text' name='user' /><br /><br />
            <dt><label>Contrase&#241;a:</label></dt>
            <input type="password" name='pass' /><br /><br />
           
            <input type="submit" name="login" style="width:100px;" tabindex="6" value="Entrar" />
            <input type="reset" name="Limpiar" style="width:100px;" tabindex="6" value="Limpiar" />
        </form>
    </div>
    <?php
    }
    ?>
    </body>
    </html>
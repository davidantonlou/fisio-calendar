    <?php
        $nombre_server[1] = 'localhost'; //Servidor al cual nos vamos a conectar.
        $nombre_user[2] = 'root'; //Nombre del usuario de la base de datos.
        $password[3] = ''; //Contraseña de la base de datos
        $nombre_db[4] = 'fisio_adm'; //nombre de la base de datos

        $conectar = mysql_connect($nombre_server[1],$nombre_user[2],$password[3]) or exit('Datos de conexion incorrectos.');
        mysql_select_db($nombre_db[4]) or exit('No existe la base de datos.');   

    ?>
    <?php
        $ini_array = parse_ini_file("config.ini");

        $conectar = mysql_connect($ini_array['serverBBDD'],$ini_array['userBBDD'],$ini_array['passBBDD']) or exit('Datos de conexion incorrectos.');
        mysql_select_db($ini_array['nameBBDD']) or exit('No existe la base de datos.');   

    ?>
<?php
		$ini_array = parse_ini_file("config.ini");
        $conectar = mysql_connect($ini_array['serverBBDD'],$ini_array['userBBDD'],$ini_array['passBBDD']) or exit('Datos de conexion incorrectos.');
        mysql_select_db($ini_array['nameBBDD']) or exit('No existe la base de datos.');

        //ini_set('session_save_path', '/home/fisioter/tmp/sessions');
        
        if ( !function_exists('sem_get') ) {
        	function sem_get($key) {
        		return fopen(__FILE__.'.sem.'.$key, 'w+');
        	}
        	function sem_acquire($sem_id) {
        		return flock($sem_id, LOCK_EX);
        	}
        	function sem_release($sem_id) {
        		return flock($sem_id, LOCK_UN);
        	}
        }
?>
<?php

 	/*function obtenerQuery($query){		//obsoleta
		$foo = file('config/bd.properties');
		$cadena;		
		foreach ($foo as $i => $line)
		{
			if (strstr($line, $query))
			{
				strpos($line,":");
				$cadena = substr($line,strpos($line,":")+1);
				return $cadena;
			}
		}
	}*/
	
	function leerFichero($tipo,$dato){
		$cadena;		
		$foo = file('config/files.properties'); //abrimos el fichero de tipos de archivos
		foreach ($foo as $i => $line)
		{
			if (strstr($line, $tipo))
			{
				strpos($line,":");
				$cadena = substr($line,strpos($line,":")+1); //buscamos el tipo de archivo que necesitamos				
			} 
		}		
		$foo = file(ltrim(rtrim(strval($cadena))));//abrimos el archivo que necesitamos quitando espacios en blanco de la cadena obtenida
		foreach ($foo as $i => $line)
		{
			if (strstr($line, $dato))
			{
				strpos($line,":");
				$cadena = substr($line,strpos($line,":")+1);//buscamos el contenido que necesitamos
				return $cadena;
			}
		}
	}
	
	
	/*function leerFichero($tipo,$dato){
		$cadena;
		if ($tipo == "status"){
			$foo = file('config/status.properties');
		}elseif ($tipo == "query"){
			$foo = file('config/bd.properties');
		}
		foreach ($foo as $i => $line)
		{
			if (strstr($line, $dato))
			{
				strpos($line,":");
				$cadena = substr($line,strpos($line,":")+1);
				return $cadena;
			}
		}
	}*/

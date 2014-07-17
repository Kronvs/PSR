<?php
	include 'db/dbHandler.php';
	
	function existeUsuario($nombreUsu){
		
		$dbh = new dbHandler();    //creamos el handler
		
		$tipoArgOper[0]='s';       //asignamos el tipo de variable a buscar 
		$argOper[0]= $nombreUsu;   //asignamos el valor de la variable a buscar
		
		$datos = array();
		
		$datos[0][0]='existe';		
		for($j=0;$j<count($argOper);$j++){
			$datos[1][$j]=$argOper[$j];	
		}		
		
		//return($argOper[0]);
		$valor = $dbh->handler($datos);//$dbh->verifyUser('query','eusuario',$tipoArgOper,$argOper); //invocamos al metodo verificar usuario del handler que hemos definido
		return($valor);
	}
	
	/*function altaUsuario{
		
		return componerSql('usuario',arrayTipos,arrayValores);
		//return (alta ok);
	}
	
	function verificarCampos{
		
	}
	
	llamada a verificarCampos();
	llamada a existeUsuario();
	si (!existeUsuario) entonces{
		llamada a altaUsuario();
	}sino{
		return error
	}*/

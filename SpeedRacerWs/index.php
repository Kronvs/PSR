<?php
//include ("commons/utils.php");
//include ("services/process.php");
//include ("db/dbHandler.php");
include ("config/PassEncrypt.php");
include ('services/webService.php');
include ('services/usuario/alta.php');

//$prueba = leerFichero("usuario");

$db = new dbHandler();
$conex = $db->connect();
$salida =null;


$operacion ="usuario";

$tipoArgOper[0]='s';
$tipoArgOper[1]='i';
$tipoArgOper[2]='s';
$tipoArgOper[3]='s';
$tipoArgOper[4]='s';				
$tipoArgOper[5]='s';
$tipoArgOper[6]='s';
$tipoArgOper[7]='s';
$tipoArgOper[8]='s';
$tipoArgOper[9]='s';
$tipoArgOper[10]='s';
$tipoArgOper[11]='s';
$tipoArgOper[12]='s';
$tipoArgOper[13]='s';

$argOper[0]= "1@1.com,";
$argOper[1]= "1";
$argOper[2]="ESP";
$argOper[3]="Y";
$argOper[4]="1";
$argOper[5]= "1980-01-01";
$argOper[6]="1980-01-01";
$argOper[7]="1980-01-01";
$argOper[8]="idalta";
$argOper[9]="idmodi";
$argOper[10]="1";
$argOper[11]="ESP";
$argOper[12]="1";
$argOper[13]="1";


/*for ($i=0; $i <count($tipoArgOper);$i++){
	echo $tipoArgOper[$i];
}

for ($i=0; $i <count($argOper);$i++){
	echo $argOper[$i];
}*/

//echo $prueba;
$clave=PassHash::hash('Penacles');
//echo $clave;

/*$prueba = obtenerQuery("usuario");
echo $prueba;*/

$tipo ="query";
//echo $tipo;
//echo $operacion;

/*$resultado = leerFichero($tipo,$operacion);
echo $resultado;*/
//$resultado=$db->componerSql(leerFichero($tipo,$operacion),$tipoArgOper,$argOper);
/*$ws = new webService();
$resultado = $ws->getStatusCodeMessage('404');*/
$resultado = existeUsuario('Albatros');

//echo gettype($resultado);
if (is_array($resultado)){
	for ($i=0;$i<count($resultado);$i++){
		$salida=$salida.'-'.$resultado[$i];
	}
	echo $salida;
}

$resultado = existeUsuario('Argos');
$salida=null;
//echo gettype($resultado);
echo 'PRUEBAAAAAAAAAAAAaa';
if (is_array($resultado)){
	for ($i=0;$i<count($resultado);$i++){
		$salida=$salida.';'.$resultado[$i];
	}
	if(is_null($salida)){
		echo "Sin resultados";
	}
}







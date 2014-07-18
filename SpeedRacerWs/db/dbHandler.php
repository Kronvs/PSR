
<?php

/**
 * Handling database connection
*
* @author Moises Rusillo
*/
include ("config/Config.php");

class dbHandler {

	private $conn;
	private $stmt;

	function __construct() {
	}

	/**
	 * Establishing database connection
	 * @return database connection handler asdfasdfasdfasd
	 */
	function connect() {
		//include_once dirname(__FILE__) . './Config.php';

		// Connecting to mysql database
		$this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

		// Check for database connection error
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		// returing connection resource
		return $this->conn;
	}
	
	function close() {
		if ($this->conn->close()){
			return 0;  //si se cierra correctamente la conexión retorna 0
		}else{
			return 1;  //sino se cierra correctamente la conexión retorna 1
		}
		
	}
	
	function leerFichero($fichero,$accion){
		$cadena;
		$foo = file('config/files.properties'); //abrimos el fichero de tipos de archivos
		foreach ($foo as $i => $line)
		{
			if (strstr($line, $fichero))
			{
				strpos($line,":");
				$cadena = substr($line,strpos($line,":")+1); //buscamos el tipo de archivo que necesitamos
			}
		}
		$foo = file(ltrim(rtrim(strval($cadena))));//abrimos el archivo que necesitamos quitando espacios en blanco de la cadena obtenida
		foreach ($foo as $i => $line)
		{
			if (strstr($line, $accion))
			{
				strpos($line,":");
				$cadena = substr($line,strpos($line,":")+1);//buscamos el contenido que necesitamos
				return $cadena;
			}
		}
	}
	
	function obtenerTipoAccion($accion){ //devuelve la accion a buscar
		$cadena;
		$foo = file(ltrim(rtrim(strval(FILE)))); //abrimos el fichero de acciones
		foreach ($foo as $i => $line)
		{
			if (strstr($line, $accion))
			{
				strpos($line,":");
				$cadena = substr($line,strpos($line,":")+1); //buscamos el tipo de acción
			}
		}
		return $cadena;
		
	}
	
	/**
	 * create a generic database statement
	 * @return execution statement result
	 */
	function componerSql($consulta,$argsType,$args){
			
		$valores = array();//array wich is used to create bind_param dinamically
		$valoresType='';
			
		//create array of types and pass by reference to our array for bind_params
		for ($i=0; $i<count($argsType);$i++){
			$valoresType .= $argsType[$i];
		}
			
		$valores[]=&$valoresType;
			
		for ($i=0; $i < count($argsType); $i++){
			$valores[] = &$args[$i];
		}
		
		//prepare statement
		$stamt = $this->conn->prepare($consulta);
		//creating bind_params
		call_user_func_array(array($stamt,'bind_param'),$valores);

		$this->stmt=$stamt;
	
	}
	
	
	function excuteQuery(){// 2.0
		
		$this->stmt->execute(); //execute prepared statement
	    $result = $this->stmt->get_result();  //store the statement result in a var.
	    
		// vincular las variables de resultados		
		$fila = $result->fetch_array(MYSQLI_NUM);//create an array with n elements, wich are every one of the elements on the prepared statement
		
		return  $fila;
	}
	
	function getType($var)//@override gettype function, to obtain first char of data´s type
	{
		if(is_null($var)){
			return 'null';
		}
		if(is_string($var)){
			return 's';
		}
		if(is_array($var)){
			return 'a';
		}
		if(is_int($var)){
			return 'i';
		}
		if(is_bool($var)){
			return 'b';
		}
		if(is_float($var)){
			return 'f';
		}
		//throw new NotImplementedException();
		return 'unknown';
	}
	
	function execute($tipo,$operacion,$tipoArgOper,$argOper){
		$this->connect();  //abrimos conexión a la BBDD
	
		$query=$this->leerFichero($tipo,$operacion); //obtenemos la query sin valores
	
		$this->componerSql($query,$tipoArgOper,$argOper); //obtenemos la query con valores lista para ejecutar
	
		$resultado = $this->excuteQuery();  //ejecutamos la query
	
		$this->close();//cerramos conexión
	
		return $resultado;
	}
	
	function handler($datos){
	
		//obtain type of action, ALWAYS MUST BE at $datos[0][0]
		$action = $datos[0][0];
		$tipoArgOper=null;
		$argOper=null;
		
		for ($i=0; $i<count($datos[1]);$i++){//data to execute statmente ALWAYS MUST BE at $datos[1][x]
			$tipoArgOper=$tipoArgOper.$this->getType($datos[1][$i]); //create type of vars for the bind_params phase.
			$argOper[$i]=$datos[1][$i];//create args wich vars from input
		}
		
		if ($action == 'existe'){			
			$resultado=$this->execute(CONSULTA,$this->obtenerTipoAccion($action),$tipoArgOper,$argOper); //return
		}
		if ($action == 'alta'){
			$resultado=$this->execute(CONSULTA,$this->obtenerTipoAccion($action),$tipoArgOper,$argOper); //return
		}
		return $resultado;
	}
	
	
	
	
	
}

?>
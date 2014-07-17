<?php

	class request{
		public $url_elements;
		public $verb;
		public $parameters;
		
		public function __construct(){
			$this->verb = $_SERVER['REQUEST_METHOD'];//Asignamos el tipo de metodo a la variable verb
			$this->url_elements = explode('/',$_SERVER['PATH_INFO']);//asignamos el contenidod e la URL separado a Url_elements
			
			$this->parseIncomingParams();//ajustamos el tipo de parametros que llegan por parametros
			// initialise json as default format
			$this->format = 'json';
			if(isset($this->parameters['format'])) { //si todos los parametros están en formato json entonces los asignamos isste devuelve true si es correcto o false en caso contrario
				$this->format = $this->parameters['format'];
			}
			return true;
		}
		
		public function parseIncomingParams() {
			$parameters = array();
		
			//para get
			if (isset($_SERVER['QUERY_STRING'])) {//si hay cadena de url entonces
				parse_str($_SERVER['QUERY_STRING'], $parameters);//tomamos la cadena de la url, y almacenamos las variables que traiga, en el array de variables $parameter
			}
		
			// para post/put
			$body = file_get_contents("php://input");//obtenemos el flujo en pho 
			$content_type = false;
			if(isset($_SERVER['CONTENT_TYPE'])) {//comprobamos el tipo de contenido que ha llegado al servidor y lo asignamos a una variable local
				$content_type = $_SERVER['CONTENT_TYPE'];
			}
			switch($content_type) {// si el formato es de tipo Json, hacemos el tratamiento para JSON
				case "application/json":
					$body_params = json_decode($body);
					if($body_params) {
						foreach($body_params as $param_name => $param_value) {//para cada elemento del cuerpo de la url, le asignamos al array de parametros en ese parametro el valor que hemos obtenido del cuerpo
							$parameters[$param_name] = $param_value;
						}
					}
					$this->format = "json";
					break;
				case "application/x-www-form-urlencoded":
					parse_str($body, $postvars);
					foreach($postvars as $field => $value) {//para cada elemento del cuerpo de la url, le asignamos al array de parametros en ese parametro el valor que hemos obtenido del cuerpo
						$parameters[$field] = $value;
		
					}
					$this->format = "html";
					break;
				default:
					// we could parse other supported formats here
					break;
			}
			$this->parameters = $parameters;
		}
	}
	
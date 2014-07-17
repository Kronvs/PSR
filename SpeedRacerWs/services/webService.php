<?php

include ('commons/utils.php');

	class webService{
		
		function getStatusCodeMessage($status)
		{
			return $status.':'.leerFichero('status',$status);
		}
		
		function sendResponse($status = 200, $body = '', $content_type = 'text/html')
		{
			$status_header = 'HTTP/1.1 ' . $status . ' ' . getStatusCodeMessage($status);
			header($status_header);
			header('Content-type: ' . $content_type);
			echo $body;
		}
		
	}
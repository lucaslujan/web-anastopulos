<?php

	//-------------------------------------------------------------------
	// VARIABLES DEL MENSAJE
	$mensaje = preg_replace('/\n/','<br>',htmlspecialchars(urldecode($_POST['mensaje'])));
	$importe = urldecode($_POST['importe']);
	//$email = urldecode($_POST['email']);
	//$asunto = urldecode($_POST['asunto']);
	$direccion = urldecode($_POST['direccion']);
	$unidad = urldecode ($_POST['unidad']);
	$fecha = ($_POST['fecha']);

	// Título del mensaje
	$titulo = "Nuevo pago de $direccion para Administración Anastópulos";

	// El cuerpo del mensaje
	$data = "";


	// Definir si es una solicitud AJAX
	define('IS_AJAX', isset($_GET['ajax']) && $_GET['ajax'] === 'true');

	// Aquí almacenaremos los errores
	$errores = array();

	// Variables para manejar el adjunto
	$hay_adjunto = false;
	$adjunto = null;
	$boundary = null;

	/*
	 * Si hay archivos, hay que cambiar el inicio del mensaje y crear un separador (boundary)
	 */
	if( isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] === 0) {
		$hay_adjunto = true;
		$adjunto = $_FILES['adjunto'];
		$boundary = md5(time());
		$data = "--".$boundary. "\r\n";
		// Y el comienzo del HTML
		$data .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
		$data .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
	}

	/*
	 * Comprobaciones de los campos requeridos
	//  */
	// if( ! filter_var($email, FILTER_VALIDATE_EMAIL) )
	// 	$errores[] = $mensajes_error['email'];

	if( ! isset($_POST['mensaje']) )
		$errores[] = $mensajes_error['mensaje'];

	if( ! isset($_POST['importe']) )
		$errores[] = $mensajes_error['importe'];

	if( ! isset($_POST['unidad']) )
		$errores[] = $mensajes_error['unidad'];

	if( ! isset($_POST['direccion']) )
		$errores[] = $mensajes_error['direccion'];

	if( ! isset($_POST['fecha']) )
		$errores[] = $mensajes_error['fecha'];


	// El mensaje HTML
	$data .= "<div class='mensaje'>
			<h1>Nuevo mensaje de $direccion</h1>
			<p><strong>Dirección del consorcio:</strong> $direccion</p>
			<p><strong>Unidad funcional/departamento</strong> $unidad</p>
			<p><strong>Importe pagado:</strong> $importe</p>
			<p><strong>Fecha de pago</strong> $fecha</p>
			<p><strong>Mensaje:</strong><br>$mensaje</p>

		</div>";

	// Las cabeceras empiezan igual
	$cabeceras = "MIME-Version: 1.0\r\n";
	$cabeceras .= "From: $direccion<$email>\r\n";
	$cabeceras .= "To: $receptor\r\n";

	// Si no hay errores probamos a enviar el archivo
	if( count($errores) === 0 ) {

		// Content-Type dependiente de si hay adjunto
		if( $hay_adjunto ) {
			$cabeceras .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"";

			// Si hay archivo
			// También añadimos al cuermo del mensaje un separador
			$data .= "\r\n";
			$data .= "--" . $boundary . "\r\n";
			// Y el archivo con su correspondiende Content-Type (octet-stream para aplicaciones) y nombre
			$data .= "Content-Type: application/octet-stream; name=\"".$adjunto['name']."\"\r\n";
			$data .= "Content-Transfer-Encoding: base64\r\n";

			// Indicamos que es un adjunto
			$data .= "Content-Disposition: attachment\r\n\n\r";

			// Vamos con el adjunto: chunk_split transforma la cadena en base64 en estandar
			$data .= chunk_split(base64_encode(file_get_contents($adjunto['tmp_name']))) . "\r\n";

			// Acabamos el mensaje
			$data .= "--" . $boundary . "--";
		} else {
			// Si no lo hay nos bastará con decir que es un mensaje HTML
			$cabeceras .= "Content-type: text/html; charset=utf-8\r\n";
		}

		// Enviamos nuestro email y damos cuenta sy hay algún error
		if(mail($receptor, $titulo, $data, $cabeceras, '-f pagos@admanasto.com.ar')) {
			// Si no hay ningún error, lo indicamos con null
			$errores = null;
		} else {
			// Si no indicamos que hubo un error
			$errores[] = "Hubo un error al enviar el e-mail";
		}
	}

	// Si es una solicitud AJAX, enviamos el JSON y no ejecutamos más código
	if( IS_AJAX ) {
		echo json_encode(array(
			'success' => $errores === null,
			'errors' => $errores,
			'has_files' => $hay_adjunto
		));
		exit;
	}
	// Si no ahora vendría el documento (index.php)

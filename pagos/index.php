<?php
	// Aquí el email al que queres recibir el correo
	$receptor = 'pagos@estudiointegralka.com.ar';

	$mensajes_error = array(
		// 'email' => 'Introduce un e-mail válido',
		'mensaje' => 'Tienes que introducir un mensaje',
		'importe' => 'Introduce un importe',
		'unidad' => 'Introduce una unidad/departamento',
		'direccion' => 'Introduce una dirección',
		'fecha' => 'Introduce una fecha de pago'
	);

	$mensaje_correcto = "Gracias, el pago se envió correctamente";

	$enviado = $_SERVER['REQUEST_METHOD'] === "POST" || isset($_GET['ajax']);
	if( $enviado ) {
		include('message.php');
	}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="ie6 lt-ie7 lt-ie8 lt-ie9 no-js" lang="es">
<![endif]-->
<!--[if IE 7]>
<html class="ie7 lt-ie8 lt-ie9 no-js" lang="es">
<![endif]-->
<!--[if IE 8]>
<html class="ie8 lt-ie9 no-js" lang="es">
<![endif]-->
<!--[if (gte IE 9) | !(IE)  ]><!-->
<html class="no-js" lang="es">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!--<![endif]-->
	<head>
		<!-- Arriba: hacks para IE ;) -->
		<title>Informando pago | Administración Anastopulos</title>
		<!--
			Charset (juego de caracteres para que se vean las tildes, etc)
		-->
		<meta charset="UTF-8">

		<!--
			Viewport (la usan los móviles para calcular el ancho de las páginas)
		-->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

		<!--
			Referencia a nuestros archivos CSS
		-->
		<!-- Core theme CSS (includes Bootstrap)-->
		<link href="../css/styles.css" rel="stylesheet" />
		<link href="../css/custom.css" rel="stylesheet">
		<!--
			Referencia a modernizr (en el head)
			script.js => encima de </body>,
						 para acelerar la carga
						 y evitar conflictos con el DOM
		-->
		<script type="text/javascript" src="js/modernizr.js"></script>

	</head>
	<body>
		<!-- Navigation-->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="mainNav">
				<div class="container">
						<a class="navbar-brand js-scroll-trigger" href="../index.html"><img src="../img/logo_h.svg" alt=""/></a>
						<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
								Menu
								<i class="fas fa-bars ml-1"></i>
						</button>
						<div class="collapse navbar-collapse" id="navbarResponsive">
								<ul class="navbar-nav text-uppercase ml-auto">
										<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#servicios">Servicios</a></li>
										<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#nosotros">Nosotros</a></li>
										<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#consorcistas">Consorcistas</a></li>
										<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#ubicacion">Ubicación</a></li>
										<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Contacto</a></li>
								</ul>
						</div>
				</div>
		</nav>
		<!-- Slider-->
		<header>
		</header>
		 <section class="page-section bg-secondary">
		<div class="container">

			<!--
				Aquí pondremos los errores (de existir alguno)
			-->
			<div id="error"><?php if( $enviado && $errores !== null ) {
				echo '<ul><li>' . implode('</li><li>', $errores) . '</li></ul>';
			} ?></div>

			<!--
				Definimos el método de envío (POST hace que nuestros datos no se puedan ver desde
				el navegador, que es lo más seguro), y la URL a la que enviarlo (post.php)
			-->
			<div class="col-md-6 mx-auto text-center">
				 <div class="header-title">
					<h1 class="wv-heading--title">
						Informar un pago</h1>
				 </div>
				</div>
				<div class="row">
			 <div class="col-md-4 mx-auto">
				   <div class="myform form ">
						 <form id="formulario" name="formulario" method="POST" action="" enctype="multipart/form-data">

				<div class="form-group">
					<label for="direccion">Dirección del consorcio</label><span class="requerido">*</span>
					<input class="form-control my-input" type="text" name="direccion" id="direccion" placeholder="Introduzca la direccion" required>
				</div>

				<div class="form-group">
					<label for="unidad">Unidad funcional/departamento</label><span class="requerido">*</span>
					<input class="form-control my-input" type="text" name="unidad" id="unidad" placeholder="Introduce la unidad" required>
				</div>

				<div class="form-group">
					<label for="importe">Importe pagado</label><span class="requerido">*</span>
					<input class="form-control my-input" type="number" name="importe" id="importe" size="30" required placeholder="Importe pagado" required>
				</div>

				<div class="form-group">
					<label for="fecha">Fecha de pago</label><span class="requerido">*</span>
					<input class="form-control my-input" type="date" name="fecha" id="fecha" placeholder="Introduce la fecha de pago" required>
				</div>

				<div class="form-group">
					<label for="mensaje">Información adicional</label><span class="requerido">*</span>
					<textarea class="form-control my-input" id="mensaje" name="mensaje" placeholder="Detalle su forma de pago: transferencia o depósito bancario" required></textarea>
				</div>

				<div class="form-group">
					<label for="asunto">Agregar un archivo</label>
					<input type="file" name="adjunto" id="adjunto" required></input>
				</div>

				<p class="submit">
					<input type="submit" id="submit" value="Enviar">
				</p>
			</form>
		</div>
	</div>
</div>
</div>

<div class="col-md-6 mx-auto text-center">
	 <div class="header-title">
		<h1 class="wv-heading--title">
			<!--
				Aquí pondremos el mensaje cuando enviemos el mensaje
			-->
			<div id="correcto"><?php if( $enviado && $errores === null ) {
				echo $mensaje_correcto;
			} ?></div>
			</div></h1>
	 </div>
	</div>
</section>
<!-- Footer -->
<footer class="footer py-4 bg-dark">
<div class="container">
<div class="row">
<div class="col-sm">
	<img src="../img/logo_h_byn.png" alt="">
</div>
<hr class="my-4">
<div class="col-sm">
	<ul class="list-unstyled">
		<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#servicios">Servicios</a></li>
		<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#consorcistas">Consorcistas</a></li>
		<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#empresa">Empresa</a></li>
		<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#ubicacion">Ubicación</a></li>
		<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Contacto</a></li>
	</ul>
</div>
<hr class="my-4">
<div class="col-sm">
	<ul class="list-unstyled">
		<li>
			<i class="fas fa-envelope fa-1x"></i>
			<a href="mailto:info@admanasto.com.ar">info@admanasto.com.ar</a>
		</li>
		<li>
			<i class="fas fa-map-marker fa-1x"></i>
			<span>Timbó 1816, Flores, Capital Federal</span>
		</li>
		<li>
			<i class="fas fa-phone fa-1x"></i>
			<span>4876-6985</span>
		</li>
		<li>
			<i class="fab fa-whatsapp fa-1x"></i>
			<span>15-1848-4562</span>
		</li>
	</ul>
</div>
</div>
</footer>
<!-- Bootstrap core JS-->

			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
			<!-- Third party plugin JS-->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
			<!-- Contact form JS-->
			<!-- Core theme JS-->
			<script type="text/javascript" src="js/script.js"></script>
			<script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>

		<script>
			window.ec_form_messages = {
				correcto: "<?php echo $mensaje_correcto ?>",
				error: <?php echo json_encode($mensajes_error) ?>
			}
		</script>
		<script src="/js/scripts.js"></script>
		<script>
			if ( window.history.replaceState ) {
			  window.history.replaceState( null, null, window.location.href );
			}
</script>
	</body>
</html>

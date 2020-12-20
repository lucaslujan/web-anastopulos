<?php
session_start();

$verifica = $_SESSION["verifica"];

$nombre = $_POST['nombre'];
$email = $_POST['email'];


if ($verifica == 1)
{
unset($_SESSION['verifica']);

// Aqui colocamos el codigo que queremos que se ejecute

echo "<p>Los datos recibidos son:</p>
Nombre: $nombre <br>
E-mail: $email <br>";

}
else
{
// Si no viene del formulario o trata de recargar pagina los enviamos al formulario
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; url=form.php'>";
}

?> 

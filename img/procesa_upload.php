<?

//datos del arhivo

$nombre_archivo = $HTTP_POST_FILES['archivo']['name'];
$tipo_archivo = $HTTP_POST_FILES['archivo']['type'];
$tamano_archivo = $HTTP_POST_FILES['archivo']['size'];


//compruebo si la extension es correcta

if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos ($tipo_archivo, "png") ))) {

    echo "<p>La extensión <b>$tipo_archivo</b> no es correcta.</p>";
    echo "<p>Solo pueden subir archivos con extension .....";

}else{

//compruebo si el tamaño es correcto

if (!($tamano_archivo < 3145728)) {

    echo "<p>El tamaño del archivo debe ser inferior a <b>3Mb</b> (<b>3072Kb</b>).</p>";


}else{

    if (move_uploaded_file($HTTP_POST_FILES['archivo']['tmp_name'], $nombre_archivo)){


echo "<p>El archivo subio correctamente</p>";

    }else{

       echo "<p>Ocurrió algún error al subir el archivo. Intenta subirlo nuevamente</p>";

    }
}
}
?>

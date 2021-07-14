<?php

class Email {

 //nombre
 var $nombre;
 //email del emisor
 var $mail;

 var $asunto;
 //mensaje
 var $msn;
 //archivo adjunto
 var $adjunto;

var $importe;
 //enviar el mensaje
 private $sender;
 //url para redireccionar
 private $url;

 //función constructora
 public function __construct(){
 //cada uno de ellos es el parámetro que enviamos desde el formulario
 $this->nombre = $n;
 $this->mail = $m;
 $this->asunto = $a;
 $this->msn = $ms;
 $this->adjunto = $ad;
 $this->importe = $im;
 }

 //método enviar con los parámetros del formulario
 public function enviar($n,$m,$a,$ms,$ad,$im){
 //si existe post
 if(isset($_POST)){

 //si existe adjunto
 if($ad) {
 //añadimos texto al nombre original del archivo
 $dir_subida = 'fichero_';
 //nombre del fichero creado -> fichero_nombreArchivo.pdf
 $fichero_ok = $dir_subida . basename($ad);
 //y lo subimos a la misma carpeta
 move_uploaded_file($_FILES['adjunto']['tmp_name'], $fichero_ok);
 }
 //creamos el mensaje
 $contenido = '
 <h2>Direccion consorcio: '.$n.'</h2>
 <hr>
 Unidad funcional/departamento: <b>'.$a.'</b><br>
 Importe abonado:<b>'.$im.'</b><br>
 Informacion adicional: <br><b>'.$ms.'</b><br>
 ';
 //adjuntamos el archivo necesario para enviar los archivos adjuntos
 require_once 'AttachMailer.php';

 //enviamos el mensaje (emisor,receptor,asunto,mensaje)
 $this->sender = new AttachMailer($m, $im, $a, $contenido);
 $this->sender->attachFile($fichero_ok);
 //eliminamos el fichero de la carpeta con unlink()
 //si queremos que se guarde en nuestra carpeta, lo comentamos o borramos
 unlink($fichero_ok);
 //enviamos el email con el archivo adjunto
 $this->sender->send();
 //url para redireccionar
 $this->url = 'http://www.webcamp.es/email';
 //redireccionamos a la misma url conforme se ha enviado correctamente con la variable si
 header('Location:'.$this->url.'?s=si');
 }
 else{
 //redireccionamos a la misma url conforme NO se ha enviado correctamente con la variable no
 header('Location:'.$this->url.'?s=no');
 }
 }
}

//llamamos a la clase
$obj = new Email();
//ejecutamos el método enviar con los parámetros que recibimos del formulario
$obj->enviar($_POST['nombre'], $_POST['email'], "info@admanasto.com.ar", $_POST['asunto'], $_POST['msn'], $_FILES['adjunto']['name'], $_POST['importe']);
?>

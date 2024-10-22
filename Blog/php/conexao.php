<?php 
$host = "localhost";
$usuario = "root";
$senha = ""; 
$bd = "login";

$mysqli = new mysqli($host, $usuario, $senha , $bd);
if ($mysqli -> connect_errno){
    echo "Falha ao conectar: (" . $mysqli -> connect_errno . ")" . $mysqli -> connect_error;


}



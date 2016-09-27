<?php
include 'conexion.php';

$v1 = $_POST['servidor'];
echo "fdgyhrfe $v1";
$v2 = $_POST['dataBase'];
$v3 = $_POST['usuario'];
$v4 = $_POST['contraseña'];
$conn = login();


include('principal.php');





/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
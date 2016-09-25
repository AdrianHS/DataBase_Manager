<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$servidor = $_GET['servidor'];
$dataBase =  $_GET['dataBase'];
$usuario =  $_GET['usuario'];
$contraseña =  $_GET['contraseña'];
#$servidor = 'DESKTOP-Q5KK7KC';
#$dataBase =  'redTEC';
#$usuario =  'sa';
#$contraseña =  '1234';

$connectionInfo = array( "Database"=>$dataBase, "UID"=>$usuario, "PWD"=>$contraseña);
$conn = sqlsrv_connect( $servidor,$connectionInfo);



if( $conn ) {
    //llama a la pagina principal
    include('principal.php');
}
else{
    echo "Conexión no se pudo establecer.<br />";
    die( print_r( sqlsrv_errors(), true));
}
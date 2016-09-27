<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//inicio de sección
session_start();

$servidor = $_GET['servidor'];
$_SESSION['servidor']=$servidor;
$dataBase =  $_GET['dataBase'];
$_SESSION['dataBase']=$dataBase;
$usuario =  $_GET['usuario'];
$_SESSION['usuario']=$usuario;
$contraseña =  $_GET['contraseña'];
$_SESSION['contraseña']=$contraseña;

if(($servidor == "")or($dataBase == "")or($usuario == "")or($contraseña == "")){
    include 'index.php';
}
 else {
    $connectionInfo = array( "Database"=>$dataBase, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $servidor,$connectionInfo);



    if( $conn ) {
        //llama a la pagina principal
        include('principal.php');
    }
    else{
        include('index.php');
        echo "Conexión no se pudo establecer.<br />";
        die( print_r( sqlsrv_errors(), true));
    }
}



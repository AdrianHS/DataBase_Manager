<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $serverName = "Andrew"; //serverName\instanceName
            $connectionInfo = array( "Database"=>"redTEC", "UID"=>"sa", "PWD"=>"1234");
            $conn = sqlsrv_connect( $serverName, $connectionInfo);

            if( $conn ) {
                 echo "Conexion establecida.<br />";
            }else{
                 echo "Conexión no se pudo establecer.<br />";
                 die( print_r( sqlsrv_errors(), true));
            }
        ?>
    </body>
</html>

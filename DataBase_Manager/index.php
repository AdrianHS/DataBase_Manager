<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link type="text/css" rel="stylesheet" href="css/style.css">
    </head>
    <body>
        
        <form name="datos" method="get" action="Conexion.php" class="login">
            <h2 style="text-align: center">Data Base Manager</h2>
            Servidor:<input type="text"name="servidor"value="">
            <br>
            Data Base:<input type="text"name="dataBase"value="">
            <br>
            Usuario:<input type="text"name="usuario"value="">
            <br>
            Contraseña:<input type="text"name="contraseña"value="">
            <nav class="botonLogin">
                <input type="submit"/>
            </nav>
        </form>
        <?php
           
        ?>
    </body>
</html>

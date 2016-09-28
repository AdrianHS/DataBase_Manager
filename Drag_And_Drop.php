<!DOCTYPE HTML>
<html>
<head>
<link type="text/css" rel="stylesheet" href="css/style.css">
<script>
<?php
    session_start();
    $serverName = $_SESSION['servidor']; //serverName\instanceName
        $connectionInfo = array( "Database"=>$_SESSION['dataBase'], "UID"=>$_SESSION['usuario'], "PWD"=>$_SESSION['contraseña']);
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn ) {
        }else{
            die( print_r( sqlsrv_errors(), true));
        }
    $consulta = sqlsrv_query($conn, "SELECT name FROM 
    sys.foreign_keys AS fk INNER JOIN sys.foreign_key_columns AS fc ON fk.OBJECT_ID = fc.constraint_object_id");
    $list = array();
    while ($objeto = sqlsrv_fetch_array($consulta)){
           $list[]=$objeto;
    }   
    ?>
    var listaConsulta = <?php echo json_encode($list);?>;

 function start(){
    var llavesForaneas = '';
    
    for (i in listaConsulta){
        var name = listaConsulta[i].name;
        llavesForaneas += '<div draggable="true" ondragstart="drag(event)" id="drag1" value="'+name+'">'+name+'</div>';
    }
    llavesForaneas += '<div draggable="true" ondragstart="drag(event)" id="drag1"></div>';
    document.getElementById('div1').innerHTML = llavesForaneas; 
 }
    
 
function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
}
</script>
</head>
<body onload="start()">
  <div id="navegador">
    <ul>
    <li><a href="">Drag and Drop FOREIGN KEY</a></li>
    <li><a href="principal.php">Atras</a></li>
    </ul>
</div>

<div id="div1"  ondragover="allowDrop(event)">
  
  <div draggable="true" ondragstart="drag(event)" id="drag1"></div>
</div>

<div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)">
    
        
</div>

</body>
</html>


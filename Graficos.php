<html>
<head>
<script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/style.css">
<script type="text/javascript">
    <?php
    session_start();
    $serverName = $_SESSION['servidor']; //serverName\instanceName
        $connectionInfo = array( "Database"=>$_SESSION['dataBase'], "UID"=>$_SESSION['usuario'], "PWD"=>$_SESSION['contraseña']);
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn ) {
        }else{
            die( print_r( sqlsrv_errors(), true));
        }
    $consulta = sqlsrv_query($conn, "select  name, size as 'Tamano', usedspace as 'EspacioUsado', (size - usedspace) as 
'EspacioDisponible' from (SELECT db_name(s.database_id) as BDName, s.name AS [Name], s.physical_name AS [FileName],
 (s.size * CONVERT(float,8))/1024 AS [Size], (CAST(CASE s.type WHEN 2 THEN 0 ELSE CAST(FILEPROPERTY(s.name, 'SpaceUsed')
  AS float)* CONVERT(float,8) END AS float))/1024 AS [UsedSpace], s.file_id AS [ID] FROM sys.filegroups AS g INNER JOIN 
  sys.master_files AS s ON ((s.type = 2 or s.type = 0) and s.database_id = db_id() and (s.drop_lsn IS NULL)) AND
   (s.data_space_id=g.data_space_id) ) DBFileSizeInfo");
    $list = array();
    while ($objeto = sqlsrv_fetch_array($consulta)){
           $list[]=$objeto;
    }   
    ?>
    var listaConsulta = <?php echo json_encode($list);?>;
 function start(){
    var botones = '';
    
    for (i in listaConsulta){
        var name = listaConsulta[i].name;
        botones += '<li class = "liG" onclick="graficaArvhivo('+i+')">'+name+'</li>'
    }
    botones += '<li><a href="principal.php">Atras</a></li>'   
    document.getElementById('boton').innerHTML = botones; 
 }
function graficaArvhivo (num){

    
	
            var chart = new CanvasJS.Chart("chartContainer", {
                    theme: "theme2",//theme1
                    title:{
                        
                            text: listaConsulta[num].name           
                    },
                    animationEnabled: false,   // change to true
                    data: [              
                    {
                            // Change type to "bar", "area", "spline", "pie",etc.
                            type: "column",
                            dataPoints: [
                                    { label:"Tamaño",  y: listaConsulta[num].Tamano },
                                    { label: "Espacio Usado", y: listaConsulta[num].EspacioUsado },
                                    { label: "Espacio Disponible", y: listaConsulta[num].EspacioDisponible  }


                            ]
                    }
                    ]
            });
            chart.render();

};




</script>
</head>
<body onload="start()">


  <div id="navegador">
    <ul id="boton">
        
    
    </ul>
</div>
    <div id="chartContainer"></div>
</body>
   
</html>
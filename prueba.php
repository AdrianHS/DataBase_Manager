<html>
<head>
<script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript">
 
window.onload=function grafica (){
	var chart = new CanvasJS.Chart("chartContainer", {
		theme: "theme2",//theme1
		title:{
			text: "Basic Column Chart - CanvasJS"              
		},
		animationEnabled: false,   // change to true
		data: [              
		{
			// Change type to "bar", "area", "spline", "pie",etc.
			type: "column",
			dataPoints: [
				{ label: "apple",  y: 10  },
				{ label: "orange", y: 15  },
				{ label: "banana", y: 25  },
				{ label: "mango",  y: 30  },
				{ label: "grape",  y: 28  }
			]
		}
		]
	});
	chart.render();
};

</script>
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
    <?php      
        $serverName = "Bianka"; 
        $connectionInfo = array( "Database"=>"redTEC", "UID"=>"sa", "PWD"=>"12345");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn ) {
          
        $consulta = sqlsrv_query($conn, "     select name, size as 'Tamano', usedspace as 'EspacioUsado', (size - usedspace) as 
        'EspacioDisponible' from (SELECT db_name(s.database_id) as BDName, s.name AS [Name], s.physical_name AS [FileName],
         (s.size * CONVERT(float,8))/1024 AS [Size], (CAST(CASE s.type WHEN 2 THEN 0 ELSE CAST(FILEPROPERTY(s.name, 'SpaceUsed')
          AS float)* CONVERT(float,8) END AS float))/1024 AS [UsedSpace], s.file_id AS [ID] FROM sys.filegroups AS g INNER JOIN 
          sys.master_files AS s ON ((s.type = 2 or s.type = 0) and s.database_id = db_id() and (s.drop_lsn IS NULL)) AND
           (s.data_space_id=g.data_space_id) ) DBFileSizeInfo");
           while ($extraido = sqlsrv_fetch_array($consulta))
           {
            $name=$extraido['name'];
            $dispo=$extraido['EspacioDisponible'];
            $tama=$extraido['Tamano'];
            $uso=$extraido['EspacioUsado'];
            $send="<button type ='button' name = ".$name."onclick =  > $name </button>";
            $send="<button type='button' name=".$name." onclick= >$name</button>";
            echo $send; 
 
              
        } 
          
        
    ?> ;   

</body>

</html>
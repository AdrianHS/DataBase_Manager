<!DOCTYPE html>
<html>
<head>
<title>Entity Relationship</title>
<meta name="description" content="Interactive entity-relationship diagram or data model diagram implemented by GoJS in JavaScript for HTML." />
<!-- Copyright 1998-2016 by Northwoods Software Corporation. -->
<meta charset="UTF-8">
<script src="go.js"></script>
<link type="text/css" rel="stylesheet" href="css/style.css">

<?php
    session_start();

?>
<script id="code">
function init() {
    if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this
    var $ = go.GraphObject.make;  // for conciseness in defining templates
    myDiagram =
      $(go.Diagram, "myDiagramDiv",  // must name or refer to the DIV HTML element
        {
          initialContentAlignment: go.Spot.Center,
          allowDelete: false,
          allowCopy: false,
          layout: $(go.ForceDirectedLayout),
          "undoManager.isEnabled": true
        });
    // define several shared Brushes
    var bluegrad = $(go.Brush, "Linear", { 0: "rgb(150, 150, 250)", 0.5: "rgb(86, 86, 186)", 1: "rgb(86, 86, 186)" });
    var greengrad = $(go.Brush, "Linear", { 0: "rgb(158, 209, 159)", 1: "rgb(67, 101, 56)" });
    var redgrad = $(go.Brush, "Linear", { 0: "rgb(206, 106, 100)", 1: "rgb(180, 56, 50)" });
    var yellowgrad = $(go.Brush, "Linear", { 0: "rgb(254, 221, 50)", 1: "rgb(254, 182, 50)" });
    var lightgrad = $(go.Brush, "Linear", { 1: "#E6E6FA", 0: "#FFFAF0" });
    // the template for each attribute in a node's array of item data
    var itemTempl =
      $(go.Panel, "Horizontal",
        $(go.Shape,
          { desiredSize: new go.Size(10, 10) },
          new go.Binding("figure", "figure"),
          new go.Binding("fill", "color")),
                   $(go.TextBlock, new go.Binding("text", "name"),
                { column: 0, margin: 9, font: "bold 10pt sans-serif" }),
              $(go.TextBlock, new go.Binding("text", "type"),
                { column: 1, margin: 9 }),
              $(go.TextBlock, new go.Binding("text", "precision"),
                { column: 2, margin: 9 })
      );
    // define the Node template, representing an entity
    myDiagram.nodeTemplate =
      $(go.Node, "Auto",  // the whole node panel
        { selectionAdorned: true,
          resizable: true,
          layoutConditions: go.Part.LayoutStandard & ~go.Part.LayoutNodeSized,
          fromSpot: go.Spot.AllSides,
          toSpot: go.Spot.AllSides,
          isShadowed: true,
          shadowColor: "#C5C1AA" },
        new go.Binding("location", "location").makeTwoWay(),
        // define the node's outer shape, which will surround the Table
        $(go.Shape, "Rectangle",
          { fill: lightgrad, stroke: "#756875", strokeWidth: 3 }),
        $(go.Panel, "Table",
          { margin: 8, stretch: go.GraphObject.Fill },
          $(go.RowColumnDefinition, { row: 0, sizing: go.RowColumnDefinition.None }),
          // the table header
          $(go.TextBlock,
            {
              row: 0, alignment: go.Spot.Center,
              margin: new go.Margin(0, 14, 0, 2),  // leave room for Button
              font: "bold 16px sans-serif"
            },
            new go.Binding("text", "key")),
          // the collapse/expand button
          $("PanelExpanderButton", "LIST",  // the name of the element whose visibility this button toggles
            { row: 0, alignment: go.Spot.TopRight }),
          // the list of Panels, each showing an attribute
          $(go.Panel, "Vertical",
            {
              name: "LIST",
              row: 1,
              padding: 3,
              alignment: go.Spot.TopLeft,
              defaultAlignment: go.Spot.Left,
              stretch: go.GraphObject.Horizontal,
              itemTemplate: itemTempl
            },
            new go.Binding("itemArray", "items"))
        )  // end Table Panel
      );  // end Node
    // define the Link template, representing a relationship
   
        
    <?php

        $serverName = $_SESSION['servidor']; //serverName\instanceName
        $connectionInfo = array( "Database"=>$_SESSION['dataBase'], "UID"=>$_SESSION['usuario'], "PWD"=>$_SESSION['contraseña']);
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn ) {
        }else{
            die( print_r( sqlsrv_errors(), true));
        }
        
        $query = "select Columna.TABLE_NAME as Tabla,columna.COLUMN_NAME as Atributo,Columna.DATA_TYPE as Tipo, Columna.NUMERIC_PRECISION as pre
	from INFORMATION_SCHEMA.TABLES Tablas inner join INFORMATION_SCHEMA.COLUMNS  Columna 
	on Columna.TABLE_NAME = Tablas.TABLE_NAME";
        $result = sqlsrv_query($conn,$query );
        
        $query2 = "SELECT OBJECT_NAME(fk.parent_object_id) AS Tabla, OBJECT_NAME (fk.referenced_object_id) AS Referencia 
        FROM sys.foreign_keys AS fk INNER JOIN sys.foreign_key_columns AS fc 
        ON fk.OBJECT_ID = fc.constraint_object_id";
        $result2 = sqlsrv_query($conn,$query2 );
         
        $query3 = "
        select Columna.TABLE_NAME as nombreTabla,columna.COLUMN_NAME as llavePrimaria
	from	
		INFORMATION_SCHEMA.TABLE_CONSTRAINTS  Tablas inner join
		INFORMATION_SCHEMA.CONSTRAINT_COLUMN_USAGE  Columna 
			on
				Columna.CONSTRAINT_NAME=Tablas.CONSTRAINT_NAME
				AND Columna.TABLE_NAME = Tablas.TABLE_NAME
				AND CONSTRAINT_TYPE = 'PRIMARY KEY'";
        $result3 = sqlsrv_query($conn,$query3 );
        
        
        
        $query4 = 
        "select Columna.TABLE_NAME as nombreTabla,columna.COLUMN_NAME as llaveForanea
	from	
		INFORMATION_SCHEMA.TABLE_CONSTRAINTS  Tablas inner join
		INFORMATION_SCHEMA.CONSTRAINT_COLUMN_USAGE  Columna 
			on
				Columna.CONSTRAINT_NAME=Tablas.CONSTRAINT_NAME
				AND Columna.TABLE_NAME = Tablas.TABLE_NAME
				AND CONSTRAINT_TYPE = 'FOREIGN KEY'";
        $result4 = sqlsrv_query($conn,$query4);
        
        $list = array();
        while ($object = sqlsrv_fetch_object($result))
        {
           $list[]=$object;

        }  
        
        $list2 = array();
        while ($object2 = sqlsrv_fetch_object($result2))
        {
           $list2[]=$object2;

        } 
        
        $list3 = array();
        while ($object3 = sqlsrv_fetch_object($result3))
        {
           $list3[]=$object3;
        } 
        
        $list4 = array();
        while ($object4 = sqlsrv_fetch_object($result4))
        {
           $list4[]=$object4;
        } 
        //sqlsrv_close($conn); 
    ?>
                
    var listaConsulta = <?php echo json_encode($list);?>;
    var listaPrimary = <?php echo json_encode($list3);?>;
    var listaForeing = <?php echo json_encode($list4);?>;
    var nodeDataArray = [];
   
    var comp = listaConsulta[0].Tabla;
    var tam = listaConsulta.length;
    var tam3 = listaPrimary.length;
    var tam4 = listaForeing.length;
    var i =0;
    var j = 0;
    
    
    
    while (i < tam){
        var dicc = {key: comp, items:[]};
        while (j < tam) {
            var k = 0;
            var l = 0;
            if (comp !== listaConsulta[j].Tabla){
                comp = listaConsulta[j].Tabla;
                break;   
            }
            while(k<tam3){
                if(listaPrimary[k].llavePrimaria===listaConsulta[j].Atributo && listaPrimary[k].nombreTabla===listaConsulta[j].Tabla){
                    var item = { name: listaConsulta[j].Atributo,type:listaConsulta[j].Tipo, iskey: true, figure: "Decision", color: yellowgrad, precision:listaConsulta[j].pre };
                    dicc.items.push(item);
                    k = tam3+1;
                }
                k++;
            }
            
            while(l<tam4){
                if(listaForeing[l].llaveForanea===listaConsulta[j].Atributo && listaForeing[l].nombreTabla===listaConsulta[j].Tabla){
                    var item = { name: listaConsulta[j].Atributo,type:listaConsulta[j].Tipo, iskey: true, figure: "TriangleUp", color: redgrad, precision:listaConsulta[j].pre };
                    dicc.items.push(item);
                    l = tam4+1;
                }
                l++;
            }
            
            
            
            if (k!==tam3+2 && l!==tam4+2){
                var item = { name: listaConsulta[j].Atributo,type:listaConsulta[j].Tipo, iskey: false, figure: "MagneticData", color: bluegrad, precision:listaConsulta[j].pre };
                dicc.items.push(item);
            }
            i++;
            j++;
        }
        nodeDataArray.push(dicc);
    }  
    var listaConsulta2 = <?php echo json_encode($list2);?>;
    var linkDataArray = [];
    var tam2 = listaConsulta2.length ;
    var h =0;

    while (h < tam2){
        console.log("entre");
        var dicc2 = { from: listaConsulta2[h].Tabla, to:listaConsulta2[h].Referencia };
        linkDataArray.push(dicc2);
        h+=1;
    }  
    myDiagram.model = new go.GraphLinksModel(nodeDataArray, linkDataArray);
    console.log(linkDataArray);
    
}
</script>
</head>
<body onload="init()">
<div id="sample">
  <div id="navegador">
    <ul>
    <li><a href="">Modelo Relacional</a></li>
    <li><a href="principal.php">Atras</a></li>
    </ul>
</div>
 <div id="myDiagramDiv" style="background-color: rgba(0, 255, 255, 0.3); border: solid 1px black; width: 100%; height: 700px"></div>
 
</div>
</body>
</html>
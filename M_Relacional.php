<!DOCTYPE html>
<html>
<head>
<title>Entity Relationship</title>
<meta name="description" content="Interactive entity-relationship diagram or data model diagram implemented by GoJS in JavaScript for HTML." />
<!-- Copyright 1998-2016 by Northwoods Software Corporation. -->
<meta charset="UTF-8">
<script src="go.js"></script>

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
        $(go.TextBlock,
          { stroke: "#333333",
            font: "bold 14px sans-serif" },
          new go.Binding("text", "name"))
    
                  
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
    myDiagram.linkTemplate =
      $(go.Link,  // the whole link panel
        {
          selectionAdorned: true,
          layerName: "Foreground",
          reshapable: true,
          routing: go.Link.AvoidsNodes,
          corner: 5,
          curve: go.Link.JumpOver
        },
        $(go.Shape,  // the link shape
          { stroke: "#303B45", strokeWidth: 2.5 }),
        $(go.TextBlock,  // the "from" label
          {
            textAlign: "center",
            font: "bold 14px sans-serif",
            stroke: "#1967B3",
            segmentIndex: 0,
            segmentOffset: new go.Point(NaN, NaN),
            segmentOrientation: go.Link.OrientUpright
          },
          new go.Binding("text", "text")),
        $(go.TextBlock,  // the "to" label
          {
            textAlign: "center",
            font: "bold 14px sans-serif",
            stroke: "#1967B3",
            segmentIndex: -1,
            segmentOffset: new go.Point(NaN, NaN),
            segmentOrientation: go.Link.OrientUpright
          },
          new go.Binding("text", "toText"))
      );
    // create the model for the E-R diagram
    /*var nodeDataArray = [
      { key: "Products",
        items: [ { name: "ProductID", iskey: true, figure: "Decision", color: yellowgrad },
                 { name: "ProductName", iskey: false, figure: "Cube1", color: bluegrad },
                 { name: "SupplierID", iskey: false, figure: "Decision", color: "purple" },
                 { name: "CategoryID", iskey: false, figure: "Decision", color: "purple" } ] },
      { key: "Suppliers",
        items: [ { name: "SupplierID", iskey: true, figure: "Decision", color: yellowgrad },
                 { name: "CompanyName", iskey: false, figure: "Cube1", color: bluegrad },
                 { name: "ContactName", iskey: false, figure: "Cube1", color: bluegrad },
                 { name: "Address", iskey: false, figure: "Cube1", color: bluegrad } ] },
      { key: "Categories",
        items: [ { name: "CategoryID", iskey: true, figure: "Decision", color: yellowgrad },
                 { name: "CategoryName", iskey: false, figure: "Cube1", color: bluegrad },
                 { name: "Description", iskey: false, figure: "Cube1", color: bluegrad },
                 { name: "Picture", iskey: false, figure: "TriangleUp", color: redgrad } ] },
      { key: "Order Details",
        items: [ { name: "OrderID", iskey: true, figure: "Decision", color: yellowgrad },
                 { name: "ProductID", iskey: true, figure: "Decision", color: yellowgrad },
                 { name: "UnitPrice", iskey: false, figure: "MagneticData", color: greengrad },
                 { name: "Quantity", iskey: false, figure: "MagneticData", color: greengrad },
                 { name: "Discount", iskey: false, figure: "MagneticData", color: greengrad } ] },
    ];
    var linkDataArray = [
      { from: "Products", to: "Suppliers", text: "0..N", toText: "1" },
      { from: "Products", to: "Categories", text: "0..N", toText: "1" },
      { from: "Order Details", to: "Products", text: "0..N", toText: "1" }
    ];
    myDiagram.model = new go.GraphLinksModel(nodeDataArray, linkDataArray);*/
        
    <?php
        $serverName = "ANDRES"; //serverName\instanceName
        $connectionInfo = array( "Database"=>"redTEC", "UID"=>"sa", "PWD"=>"vacaslocas1");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn ) {
        }else{
            die( print_r( sqlsrv_errors(), true));
        }
        
        $query = "select Columna.TABLE_NAME as Tabla,columna.COLUMN_NAME as Atributo,Columna.DATA_TYPE as Tipo
	from INFORMATION_SCHEMA.TABLES Tablas inner join INFORMATION_SCHEMA.COLUMNS  Columna 
	on Columna.TABLE_NAME = Tablas.TABLE_NAME";
        $result = sqlsrv_query($conn,$query );
        
        $query2 = "SELECT OBJECT_NAME(fk.parent_object_id) AS Tabla, OBJECT_NAME (fk.referenced_object_id) AS Referencia 
        FROM sys.foreign_keys AS fk INNER JOIN sys.foreign_key_columns AS fc 
        ON fk.OBJECT_ID = fc.constraint_object_id";
        $result2 = sqlsrv_query($conn,$query2 );
         
        
        
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
        //sqlsrv_close($conn); 
        ?>
    var listaConsulta = <?php echo json_encode($list);?>;
    var nodeDataArray = [];
   
    var comp = listaConsulta[0].Tabla;
    var tam = listaConsulta.length -1;
    var i =0;
    var j = 0;
    while (i < tam){
        var dicc = {key: comp, items:[]};
        while (j < tam) {
            if (comp !== listaConsulta[j].Tabla){
                comp = listaConsulta[j].Tabla;
                break;   
            }
        var item = { name: listaConsulta[j].Atributo,name2:listaConsulta[j].Tipo, iskey: true, figure: "Decision", color: yellowgrad };
        dicc.items.push(item);
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
        var dicc2 = { from: listaConsulta2[h].Referencia, to:listaConsulta2[h].Tabla, text: "0..N", toText: "1" };
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
  <h3>Modelo Relacional</h3>
  <div id="myDiagramDiv" style="background-color: gray; border: solid 1px black; width: 100%; height: 700px"></div>
 
</div>
</body>
</html>
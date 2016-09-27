<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Crear Tablas</title>
    </head>
    
    
<script type="text/javascript">
function createTable()
{
    var num_rows = document.getElementById('rows').value;
    var num_cols = 4;
    var theader = '<table border="1">\n';
    var tbody = '';
    
    

    for( var i=0; i<num_rows;i++)
    {
        tbody += '<tr>';
        for( var j=0; j<num_cols;j++)
        {
            tbody += '<td>';
            tbody += '<input></input>' + i + ',' + j;;
            tbody += '</td>'
        }
        tbody += '</tr>\n';
    }
    var tfooter = '</table>';
    document.getElementById('wrapper').innerHTML = theader + tbody + tfooter;
}
</script>
</head>

<body>
<form name="tablegen">
    <label>Nombre Tabla: <input type="text" name="tabla" id="tabla"/></label><br />
    <label>Rows: <input type="text" name="rows" id="rows"/></label><br />

    <input name="generate" type="button" value="Create Table!" onclick='createTable();'/>
</form>

<div id="wrapper"></div>
        <?php
        // put your code here
        ?>
    </body>
</html>

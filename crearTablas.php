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
    var num_cols = 5;
    var theader = '<table border="1">\n';
    var tbody = '';
    
    for( var i=0; i<num_rows;i++)
    {
        tbody += '<tr>';
        for( var j=0; j<num_cols;j++)
        {
            //tipos de variables
            if(j===1)
            {
                tbody += '<td>';
                tbody += '<select id="'+i + '.' + j +'"><option value="varchar">Varchar</option>\n\
                                                        <option value="int">Int</option>\n\
                                                        <option value="char">Char</option>\n\
                                                        <option value="smallint">Smallint</option>\n\
                                                        <option value="smallint">Smallint</option>\n\\n\
                                                        <option value="datetime">Datetime</option>\n\\n\
                                                        <option value="float">Float</option>\n\
                          </select>';
    
                tbody += '</td>';
            }
            //primary
            if(j===3)
            {
                tbody += '<td>';
                tbody += '<select id="'+i + '.' + j +'"><option value="primary key">Primary Key</option>\n\
                                                        <option value="">No Primary Key</option>\n\
                          </select>';
    
                tbody += '</td>';
            }
            //null
            if(j===4)
            {
                tbody += '<td>';
                tbody += '<select id="'+i + '.' + j +'"><option value="null">Null</option>\n\
                                                        <option value="not null">Not null</Not null>\n\
                          </select>';
    
                tbody += '</td>';
            }
            //tamano y nombre
            if(j===0 || j===2)
            {
                tbody += '<td>';
                tbody += '<input id="'+i + '.' + j +'"></input>';
                tbody += '</td>';
            }
        }
        tbody += '</tr>\n';
    }
    var tfooter = '</table>';
    document.getElementById('wrapper').innerHTML = theader + tbody + tfooter;
}

function recoger(){
    var num_rows = document.getElementById('rows').value;
    var num_cols = 5;
    var lista=[];
    for( var i=0; i<num_rows;i++)
    {
        var dic={nombre:'',tipo:'',tamano:'',primary:'',nulidad:''};
        for( var j=0; j<num_cols;j++)
        {
            if(j==0){
                var dato = document.getElementById(''+i + '.' + j +'').value;
                dic.nombre=dato;
            }
            if(j==1){
                var dato = document.getElementById(''+i + '.' + j +'').value;
                dic.tipo=dato;
            } 
            if(j==2){
                var dato = document.getElementById(''+i + '.' + j +'').value;
                dic.tamano=dato;
            } 
            if(j==3){
                var dato = document.getElementById(''+i + '.' + j +'').value;
                dic.primary=dato;
            }
            if(j==4){
                var dato = document.getElementById(''+i + '.' + j +'').value;
                dic.nulidad=dato;
            }
        }
        lista.push(dic);
        console.log(dic);
    }
}


</script>
</head>

<body>
    <form name="tablegen">
        <label>Nombre de la tabla: <input type="text" name="tabla" id="tabla"/></label><br />
        <label>Cantidad de columnas: <input type="text" name="rows" id="rows"/></label><br />
        <input name="generate" type="button" value="Crear Grilla" onclick='createTable();'/>
    </form>
    <div id="wrapper"></div>
    <input name="rec" type="button" value="Crear Tabla" onclick='recoger();'/>
            <?php
            // put your code here
            ?>
    </body>
</html>

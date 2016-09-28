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
        <link type="text/css" rel="stylesheet" href="css/style.css">

    </head>
    
    
<script type="text/javascript">
    var codigo2="";
     <?php
        session_start();  
    ?>
    
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
    var codigo="Create table "+document.getElementById('esquema').value+"."+document.getElementById('tabla').value+" ( \n\ ";
    for( var i=0; i<num_rows;i++)
    {
        for( var j=0; j<num_cols;j++)
        {
            if(j===0){
                var dato = document.getElementById(''+i + '.' + j +'').value;
                codigo+=dato+" ";
            }
            if(j===1){
                var dato = document.getElementById(''+i + '.' + j +'').value;
                codigo+=dato+" ";
            } 
            if(j===2){
                var dato = document.getElementById(''+i + '.' + j +'').value;
                codigo+="("+dato+") ";
            } 
            if(j===3){
                var dato = document.getElementById(''+i + '.' + j +'').value;
                codigo+=dato+" ";  
            }
            if(j===4){
                var dato = document.getElementById(''+i + '.' + j +'').value;
                codigo+=dato+", \n\ ";   
            }
        }
    }
    codigo+=")";
    console.log(codigo);  
    codigo2=codigo;
    <?php   
        $serverName = $_SESSION['servidor']; //serverName\instanceName
        $connectionInfo = array( "Database"=>$_SESSION['dataBase'], "UID"=>$_SESSION['usuario'], "PWD"=>$_SESSION['contraseña']);
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn ) {
        }else{
            die( print_r( sqlsrv_errors(), true));
        }
        $sql = "<scrit> document.write(codigo)</script>";
        $resultado = sqlsrv_query($conn,$sql);     
    ?>
   
}
</script>

</head>

<body>

    <div id="navegador">
    <ul>
    <li><a href="">Crear Tablas</a></li>
    <li><a href="principal.php">Atras</a></li>
    </ul>
</div>
    <form name="tablegen" class="crearTablas1">
        <label>Nombre de la tabla: <input type="text" name="tabla" id="tabla"/></label><br 
        <label>Esquema: <input type="text" name="esquema" id="esquema"/></label><br />
        <label>Cantidad de columnas: <input type="text" name="rows" id="rows"/></label><br />
        <input name="generate" type="button" value="Crear Grilla" onclick='createTable();'/>
        <input name="rec" type="button" value="Crear Tabla" onclick='recoger();'/>
    </form>
    <div id="wrapper"style="margin-left: 350px; padding-top: 20px;"></div>
    
            <?php
            // put your code here
            ?>
    </body>
</html>

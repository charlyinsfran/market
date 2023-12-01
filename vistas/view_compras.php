<?php


session_start();

if(isset($_SESSION['usuario'])){
    require_once "../clases/Conexion.php";
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagenes/listadecompras.png">
    <link rel="stylesheet" href="../librerias/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../librerias/datatables/css/dataTables.bootstrap.css">
        <link rel="stylesheet" href="../librerias/datatables/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="../css/estilovistascompras.css">

        <script src="../librerias/DataTables/js/jquery.dataTables.js"></script>
        <script src="../librerias/DataTables/js/dataTables.bootstrap.js"></script>
   
    <title>COMPRAS</title>
    <?php require_once "menu.php";?>
</head>
<body>
<div class="col-sm-2">
            <div class="container">
                <div class="row">
                    <br>
                    <br>

                    

                </div>
            </div>

        </div>

        <div class="col-sm-9">

            <div id="tablaCOMPRAS" style="align-content:left;">

            </div>

        </div>
   
</body>
</html>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#tablaCOMPRAS').load("compras/table_compras.php");
        

        });
    </script>





<?php
}else{
    header("location:../index.php");

}
?>
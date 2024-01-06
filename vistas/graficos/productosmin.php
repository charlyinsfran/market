<?php

require_once "../../clases/Conexion.php";


$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT id_producto,CONCAT(nombre, ' ', descripcion),cantidad from productos where cantidad < 50 ORDER BY cantidad";

$result = mysqli_query($conexion, $sql);

?>

<table class="table table-borderless table-info">
    
    <thead>
    <tr style="text-align: center; font-size: 1.1em;font-weight: bold;" class="danger">
        <td style="width: 10px; text-align:center; height:5px;">COD</td>
        <td tyle="width: 20px; text-align:center; height:5px;">DESCRIPCION</td>
        <td tyle="width: 20px; text-align:center; height:5px;">EXISTENCIA</td>
    </tr>
    </thead>
    <tbody>


    <?php


    while ($ver = mysqli_fetch_row($result)) :
    ?>

        <tr style="font-size: 1.2em;font-weight: bold;" class="warning">
            <td style="width: 10px; text-align:center; height:3px;"><?php echo utf8_encode($ver[0]); ?></td>
            <td style="width: 20px; text-align:left; height:3px;"><?php echo strtoupper($ver[1]); ?></td>
            <td style="width: 10px; text-align:center; height:3px;"><?php echo $ver[2];?></td>
        </tr>


    <?php endwhile; ?>
    </tbody>


</table>
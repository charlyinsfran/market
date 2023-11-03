<?php

require_once "../../clases/Conexion.php";


$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT id_producto,nombre,cantidad,precio,iva
FROM productos where cantidad <= 0 ORDER BY cantidad asc";

$result = mysqli_query($conexion, $sql);

?>

<label style="text-align: center;">Productos</label>
<p></p>

<table class="table table-hover table-condensed table-bordered">

    <tr style="font-weight: bold; background-color: #f1f8f9; text-align: center;">
        <td>Codigo</td>
        <td>Descripcion</td>
        <td>Stock</td>
        <td>Precio Compra</td> 
        <td>IVA</td>  
        <td>Precio Venta</td>
        <td style="text-align: center;">Actualizar Stock</td>
        
    </tr>
    <?php


while ($ver = mysqli_fetch_row($result)) :

    $numero = $ver[3];
    
?>

    <tr style="font-size: 13;">
            <td><?php echo utf8_encode($ver[0]); ?> </td>
            <td><?php echo utf8_encode($ver[1]); ?></td>
            <td><?php echo utf8_encode($ver[2]); ?></td>
            <td>Gs. <?php echo number_format($numero, 0, ",", ".");?></td>
            <td><?php echo utf8_encode($ver[4]); ?>%</td>
            <?php $precio = $ver[3]; 
                    $iva = ($precio*$ver[4])/100;
                    $preciofinal = $precio + $iva;
                
                
                ?>
            <td>Gs. <?php echo number_format($preciofinal, 0, ",", "."); ?></td>

            <td style="text-align: center;">
                <span class="btn btn-info btn-sm" >
                    <span class="glyphicon glyphicon-pencil" 
                    <?php 
                    
                    $id = $ver[0];
                    $impresion = $id;

                    ?>

                    data-toggle="modal" data-target="#agregastock" onclick="agregadatoproducto('<?php echo $impresion;?>')"></span>
                </span>

            </td>
            
        </tr>
        <?php endwhile; ?>
</table>  
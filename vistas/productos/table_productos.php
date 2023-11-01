<?php

require_once "../../clases/Conexion.php";


$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT p.id_producto,p.nombre,p.descripcion,c.nombreCategoria,im.ruta,p.cantidad,p.precio,p.iva 
FROM productos p  
join categorias c on p.id_categoria = c.id_categoria 
join imagenes im on im.id_imagen = p.id_imagen";

$result = mysqli_query($conexion, $sql);

?>

<label style="text-align: center;">Productos</label>
<p></p>

<table class="table table-hover table-condensed table-bordered">

    <tr style="font-weight: bold; background-color: #f1f8f9; text-align: center;">
        <td>Codigo</td>
        <td>Descripcion</td>
        <td>Detalle</td>
        <td>Categoria</td>
        <td>Imagen</td>
        <td>Stock</td>
        <td>Precio Compra</td>
        <td>Iva</td>    
        <td>Precio Venta</td>
        <td>Editar</td>
        <td>Borrar</td>
    </tr>
    <?php


while ($ver = mysqli_fetch_row($result)) :
?>

    <tr style="font-size: 13;">
            <td><?php echo utf8_encode($ver[0]); ?> </td>
            <td><?php echo utf8_encode($ver[1]); ?></td>
            <td><?php echo utf8_encode($ver[2]); ?></td>
            <td><?php echo utf8_encode($ver[3]); ?></td>
            <td>
            <?php 
            $imagen =explode("/",$ver[4]);
            $imagenruta = $imagen[1]."/".$imagen[2]."/".$imagen[3];
            ?>

             <img width="100" height="100" src="<?php echo $imagenruta?>">
        
        </td>
            <td><?php echo utf8_encode($ver[5]); ?></td>
            <td>Gs. <?php echo utf8_encode($ver[6]); ?></td>
            <td> <?php echo utf8_encode($ver[7]); ?>%</td>
            <?php $precio = $ver[6]; 
                    $iva = ($precio*$ver[7])/100;
                    $preciofinal = $precio + $iva;
                
                
                ?>
            <td>Gs. <?php echo $preciofinal; ?></td>

            <td>
                <span class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-pencil" 
                    data-toggle="modal" data-target="#actualizaProductos" onclick="agregadatoproducto('<?php echo $ver[0] ?>')"></span>
                </span>

            </td>
            <td>
            <span class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-remove" onclick="eliminaProducto('<?php echo $ver[0] ?>')"></span>
            </span>

            </td>
        </tr>
        <?php endwhile; ?>
</table>  
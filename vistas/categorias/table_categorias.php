<?php

require_once "../../clases/Conexion.php";


$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT id_categoria,nombreCategoria,fechaCaptura from categorias  ORDER BY id_categoria limit 0,10";

$result = mysqli_query($conexion, $sql);

?>

<label for="">Categorias de Productos</label>
<p></p>

<table class="table table-hover table-condensed table-bordered">

    <tr style="font-weight: bold; background-color: #0C9C93; text-align: center;">
        <td>Codigo</td>
        <td>Descripcion</td>
        <td>Editar</td>
        <td>Borrar</td>
    </tr>


    <?php


    while ($ver = mysqli_fetch_row($result)) :
    ?>

        <tr style="font-size: 13;">
            <td><?php echo utf8_encode($ver[0]); ?></td>
            <td><?php echo utf8_encode($ver[1]); ?></td>

            <td>
                <span class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-pencil" 
                    data-toggle="modal" data-target="#actualizaCategorias" 
                    onclick="agregaDato('<?php echo $ver[0] ?>','<?php echo utf8_encode($ver[1]) ?>')"></span>
                </span>

            </td>
            <td>
            <span class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-remove"></span>
            </span>

            </td>
        </tr>


    <?php endwhile; ?>



</table>
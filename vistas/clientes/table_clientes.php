<?php

require_once "../../clases/Conexion.php";


$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT cl.idclientes,cl.nombre,cl.apellido,cl.cedula,cl.direccion,c.detalle,cl.email,cl.telefono 
FROM clientes cl  join ciudad c on cl.id_ciudad = c.idciudad";

$result = mysqli_query($conexion, $sql);
?>

<label style="text-align: center;">CLIENTES</label>
<p></p>

<table class="table table-hover table-condensed table-bordered">
<tr style="font-weight: bold; background-color: #f1f8f9; text-align: center;">
        <td>Codigo</td>
        <td>Nombre</td>
        <td>Cedula / R.U.C</td>
        <td>Direccion</td>
        <td>Ciudad</td>
        <td>Email</td>
        <td>Telefono</td>
        <td>Editar</td>
        <td>Borrar</td>
    </tr>
    <?php while ($ver = mysqli_fetch_row($result)) :
?>


    <tr style="font-size: 13;">
   
            <td><?php echo utf8_encode($ver[0]); ?></td>
            <td><?php echo utf8_encode($ver[1]). ' '.$ver[2]; ?></td>
            <td><?php echo ($ver[3]); ?></td>
            <td><?php echo $ver[4]; ?></td>
            <td><?php echo $ver[5]; ?></td>
            <td><?php echo utf8_encode($ver[6]); ?></td>
            <td><?php echo utf8_encode($ver[7]); ?></td>
            
           
            
            <td>
                <span class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-pencil" 
                    data-toggle="modal" data-target="#nuevoclientemodalupdate" onclick="agregadato('<?php echo $ver[0] ?>')"></span>
                </span>

            </td>
            <td>
            <span class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-remove" onclick="eliminacliente('<?php echo $ver[0] ?>')"></span>
            </span>

            </td>
        </tr>
        <?php endwhile; ?>
</table>
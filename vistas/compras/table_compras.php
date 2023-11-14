<?php

require_once "../../clases/Conexion.php";


$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT dc.compra_nro,pro.razon_social,p.nombre,dc.cantidad,dc.precio,dc.iva,c.condicion,c.subtotal 
from detalle_compra dc join compras c on dc.compra_nro = c.idcompras 
join productos p on dc.id_producto = p.id_producto 
join proveedores pro on c.idproveedores = pro.idproveedores ";

$result = mysqli_query($conexion, $sql);

?>

<label style="font-size: 2em; text-align:center">LISTA DE COMPRAS</label>
<p></p>

<table class="table table-hover table-condensed table-bordered" id="tabladinamica" style="text-align: center;">
    <thead>
    <tr style="font-weight: bold; background-color: #f1f8f9; text-align: center;">
        <td>Compra Nro</td>
        <td>Proveedor</td>
        <td>Producto</td>
        <td>Cantidad</td>
        <td>Precio</td>
        <td>IVA</td>
        <td>Condicion</td>
        <td>Sub</td>
        <td>Total</td>    
        
    
    </tr>
    </thead>
    <tbody>
    
    <?php 
    //echo number_format($ver[6], 0, ",", ".");
while ($ver = mysqli_fetch_row($result)) :

$iva = $ver[5];
$precio = $ver[4];
$cantidad = $ver[3];
$valor10 = 0;
$valor5 = 0;
$subtotal = 0;
$impresion = 0;
$valorimpresion = 0;


if($iva == "10"){
        $subtotal = ($precio*$cantidad);
        $impresion = round($subtotal * 0.090909);
        $valorimpresion = $subtotal - $impresion;

}

if($iva == "5"){
    $subtotal = ($precio*$cantidad);
    $impresion = round($subtotal * (5/100));
    $valorimpresion = $subtotal - $impresion;
}
    
?>


    <tr style="font-size: 13;">
            <td><?php echo $ver[0]; ?> </td>
            <td><?php echo $ver[1]; ?></td>
            <td><?php echo strtoupper($ver[2]); ?></td>
            <td><?php echo $ver[3]; ?></td>
            <td>GS. <?php echo number_format($ver[4], 0, ",", "."); ?></td>
            <td><?php echo $ver[5].' %'; ?> </td>
            <td><?php echo $ver[6]; ?></td>
            <td>GS. <?php echo number_format($valorimpresion, 0, ",", ".");?></td>
            <td>GS. <?php echo number_format($ver[7], 0, ",", ".");?></td>
            
          
        </tr>
        <?php endwhile; ?>
        </tbody>
</table>  

<script type="text/javascript">
    $(document).ready(function(){
   $('#tabladinamica').DataTable({
    dom: 'Bfrtip',
    buttons: [
            {
                extend:    'copyHtml5',
                className: 'btn btn-success',
                titleAttr: 'Copiar'
            },
            {
                extend:    'excelHtml5',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                titleAttr: 'PDF'
            }
        ],
       "language": {
        "decimal": ",",
        "thousands": ".",
        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "infoPostFix": "",
        "search": "Buscar:",
        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "lengthMenu": "Mostrar _MENU_ registros",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }
            
        });


    });
</script>
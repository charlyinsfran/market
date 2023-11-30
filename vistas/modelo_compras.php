<?php
error_reporting (0); 

echo "<pre>";
print_r($_REQUEST['cancelar2']);
echo "<pre>";

session_start();

$operacion = $_REQUEST['operacion'];

switch ($operacion){
    case 'BUSCAR': buscarproveedor();
            break;

    case 'CANCELAR': cancelar();
            break;
    
     case 'buscarproducto': buscarproductos();
     break; 
     
     case 'cancelar2': cancelarcompras();
     break;

     case 'generarcompra': guardarcompra();
            break;
    
}


function buscarproveedor(){
    include "../clases/conection.php";
    if(empty($_REQUEST['rucproveedor'])){
        header("location:compras.php?aviso=2");
    }
    else{
    $ruc = $_REQUEST['rucproveedor'];
    $proveedor= $bd->query("SELECT * FROM proveedores where ruc = '$ruc' OR razon_social 
    = '$ruc' OR idproveedores = '$ruc'")->fetch(PDO::FETCH_OBJ);
    $_SESSION['proveedor'] = $proveedor;
    if(empty($proveedor)){
        header("location:compras.php?error=1");

    }
    else{
header("location:compras.php?aviso=1");
}
}

}

function buscarproductos(){
    include "../clases/conection.php";
    
    if(empty($_REQUEST['producto'])){ header("location:compras.php?aviso=3");} 
    if(empty($_REQUEST['cantidad'])) {header("location:compras.php?aviso=5");}
    if(empty($_REQUEST['ivaselect'])){header("location:compras.php?aviso=6");} 
    if($_REQUEST['ivaselect'] == "cero"){  header("location:compras.php?aviso=7");}
    else{
    $codigoproducto = $_REQUEST['producto'];
    $cantidad = $_REQUEST['cantidad'];
    $iva = $_REQUEST['ivaselect'];
    

    $producto= $bd->query("SELECT * FROM productos where id_producto = '$codigoproducto'")->fetch(PDO::FETCH_OBJ);
    $producto->cantidadtipeada= $cantidad;
    $producto->iva=$iva;
    $_SESSION['productos'][] = $producto;
       

    if(empty($producto)){
        header("location:compras.php?error=2");

    }

    else{
header("location:compras.php");

}
    }

}  





//-------------------------------------------------------------------------------------------------------------------------------------------



function guardarcompra(){
    include "../clases/conection.php";
    date_default_timezone_set('America/Asuncion');
    $fecha = date('Y-m-d');

    $fecha_guardado = date('Y-m-d H:i:s');
    $proveedor = $_SESSION['proveedor'];
    $productos = $_SESSION['productos'];
    $idusuario = $_SESSION['iduser'];
    $condicion = $_REQUEST['condicion'];
    $total = $_REQUEST['totalfactura'];
    $subtotal = $_REQUEST['subtotalfactura'];
    if($condicion == "A"){
        header("location:compras.php?error=3");
    }else{

    
    $bd->query("INSERT INTO compras(idproveedores,fecha,id_usuario,fecha_save,condicion,total,subtotal) values
     ('$proveedor->idproveedores','$fecha','$idusuario','$fecha_guardado','$condicion','$total','$subtotal')");
    $venta = $bd->lastInsertId();

    foreach($productos as $p){
       
        $bd->query("INSERT INTO detalle_compra(id_producto,compra_nro,precio,iva,cantidad) VALUES
         ($p->id_producto,$venta,$p->precio,$p->iva,$p->cantidadtipeada)");
      
    }

    header("location:compras.php");
    vaciar();
}

}



function cancelar(){
    unset($_SESSION['proveedor']);
    header("location:compras.php");
}


function cancelarcompras(){
    unset($_SESSION['productos']);
    unset($_SESSION['proveedor']);
    header("location:compras.php");

}

function vaciar(){
    unset($_SESSION['productos']);
    unset($_SESSION['proveedor']);
    unset($_SESSION['factura']);
    header("location:compras.php");
    
}

function actualizar (){
    include "../clases/conection.php";
    $bd->query("UPDATE productos SET cantidad = cantidad + $p->$cantidadtipeada WHERE id_producto = $p->id_producto");
}

?>
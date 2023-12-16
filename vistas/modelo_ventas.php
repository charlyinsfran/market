<?php
//error_reporting (0); 
session_start();
$operacion = $_REQUEST['operacion'];

/*echo "<pre>";
print_r($_REQUEST);
echo "<pre>";
*/

switch ($operacion) {
    case 'buscar':
        buscar_cliente();
        break;

    case 'cancelar':
        vaciar_cliente();
        break;

    case 'buscarproducto':
        agregarproducto();
        break;

    case 'anularventa':
        anularventa();
        break;

    case 'eliminarproducto':
        eliminarproducto();
        break;

    case 'facturar':
        grabarproducto();
        break;
}


function buscar_cliente()
{
    include "../clases/conection.php";
    if (empty($_REQUEST['cicliente'])) {
        header("location:ventas.php?error=1");
    } else {
        $cicliente = $_REQUEST['cicliente'];
        $clientes = $bd->query("SELECT * FROM clientes where cedula = '$cicliente'")->fetch(PDO::FETCH_OBJ);
        $_SESSION['clientes'] = $clientes;

        if (empty($clientes)) {
            header("location:ventas.php?error=2");
            unset($_SESSION['clientes']);
        } else {

            header("location:ventas.php");
            header("location:ventas.php?aviso=1");
        }
    }
}

function grabarproducto()
{
    /*echo "<pre>";
    print_r($_SESSION['clientes']);
    echo "<pre>";*/

    include "../clases/conection.php";
    //datos para guardar table(ventas)
    //-------------------------------
    date_default_timezone_set('America/Asuncion');
    $fecha = date('Y-m-d');
    $fecha_guardado = date('Y-m-d H:i:s');
    $ventanro = $_REQUEST['numerofact'];
    $idcliente = $_SESSION['clientes'];
    $subtotal = $_REQUEST['subtotalmodal'];
    $total = $_REQUEST['totalapagar'];
    $condicion = $_REQUEST['pagoselect'];
    $idusuario = $_SESSION['iduser'];
    $vuelto = $_REQUEST['vuelto'];
    //----------------------------------
    $productos = $_SESSION['productos'];

   


    $bd->query("INSERT INTO ventas(fecha,idcliente,subtotal,total,vuelto,condicion,idusuarioventa,fecha_save) values
     ('$fecha','$idcliente->idclientes','$subtotal','$total','$vuelto','$condicion','$idusuario','$fecha_guardado')");
   $venta = $bd->lastInsertId();
    //-------------------------------------------
    

    
    header("location:ventas.php");
    postventa();




}

function vaciar_cliente()
{
    unset($_SESSION['clientes']);
    header("location:ventas.php");
}

function agregarproducto()
{
    include "../clases/conection.php";
    if (empty($_REQUEST['producto'])) {
        header("location:ventas.php?error=3");
    } else {
        $codigoproducto = $_REQUEST['producto'];
        $cantidad = $_REQUEST['cantidad'];
        $producto = $bd->query("SELECT * FROM productos where id_producto = '$codigoproducto'")->fetch(PDO::FETCH_OBJ);

        if (empty($producto)) {
            header("location:ventas.php?error=4");
        } else {
            $producto->cantidadingresada = $cantidad;
            $_SESSION['productos'][] = $producto;
            header("location:ventas.php");
        }
    }
}


function anularventa()
{
    unset($_SESSION['productos']);
    unset($_SESSION['clientes']);
    header("location:ventas.php");
}

function postventa()
{
    unset($_SESSION['productos']);
    unset($_SESSION['clientes']);
    header("location:ventas.php");
}


function eliminarproducto()
{
    unset($_SESSION['productos']);
}

<?php
//error_reporting (0); 
session_start();
$operacion = $_REQUEST['operacion'];
$cliente2 = "";
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

    case 'prueba':
        imprimir();
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

    foreach ($productos as $p) {

        $bd->query("INSERT INTO detalle_ventas(idproducto,venta_nro,precio,iva,cantidad) VALUES
     ($p->id_producto,$venta,$p->precio,$p->iva,$p->cantidadingresada)");
    }

    
    imprimir();
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


function imprimir()
{
    

    include "fpdf/fpdf.php";

    include "../clases/Conexion.php";

    $c = new conectar();
    $conexion = $c->conexion();

    $lastventa = "SELECT max(idventas) from ventas";
            $ret_lastventa = mysqli_query($conexion,$lastventa);
            while ($ret_lastventavista = mysqli_fetch_row( $ret_lastventa)) {
                $lastventaid= $ret_lastventavista[0];
                

            }



    $sql = "SELECT p.id_producto,p.nombre,p.precio,dv.cantidad,dv.iva,v.subtotal,v.total,CONCAT(c.nombre, ' ',c.apellido) from ventas v 
            JOIN detalle_ventas dv ON v.idventas = dv.venta_nro
            join productos p on p.id_producto = dv.idproducto
            JOIN clientes c on c.idclientes = v.idcliente 
            WHERE v.idventas = '$lastventaid' limit 10";
    $result = mysqli_query($conexion, $sql);



    class PDF extends FPDF
    {

        // Cabecera de página
        public function Header()
        {

            $this->Image("fpdf/cabecera.png", 185, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
            $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
            $this->Cell(45); // Movernos a la derecha
            $this->SetTextColor(0, 0, 0); //color
            //creamos una celda o fila
            $this->Cell(110, 15, utf8_decode('tu negocio'), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
            $this->Ln(3); // Salto de línea
            $this->SetTextColor(103); //color


            $this->Cell(80);  // mover a la derecha
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(96, 10, utf8_decode("Ruc: #######-#"), 0, 0, '', 0);
            $this->Ln(5);


            $this->Cell(80);;  // mover a la derecha
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(59, 10, utf8_decode("Teléfono : 0000 000 000 "), 0, 0, '', 0);
            $this->Ln(5);


            $this->Cell(80);;  // mover a la derecha
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(85, 10, utf8_decode("Correo : "), 0, 0, '', 0);
            $this->Ln(5);


            $this->Cell(20);;  // mover a la derecha
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(85, 10, utf8_decode("-------------------------------------------------------------------------------------------------------------------------"), 0, 0, '', 0);
            $this->Ln(7);

            /* TITULO DE LA TABLA */
            //color
            $this->SetTextColor(228, 100, 0);
            $this->Cell(50); // mover a la derecha
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(100, 10, utf8_decode("Liquidacion de Productos"), 0, 1, 'C', 0);
            $this->Ln(5);

            /* CAMPOS DE LA TABLA */

            $this->SetFillColor(228, 100, 0); //colorFondo
            $this->SetTextColor(255, 255, 255); //colorTexto
            $this->SetDrawColor(163, 163, 163); //colorBorde
            $this->SetFont('Arial', 'B', 10);
            $this->SetX(40);
            $this->Cell(15, 10, utf8_decode('Codigo'), 1, 0, 'C', 1);
            $this->Cell(40, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
            $this->Cell(20, 10, utf8_decode('Precio'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('IVA %'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('Monto'), 1, 0, 'C', 1);
            $this->Cell(20, 10, utf8_decode('Cantidad'), 1, 1, 'C', 1);
            
        }

        // Pie de página
        public function Footer()
        {
            $c = new conectar();
            $conexion = $c->conexion();
            $sql = "SELECT subtotal,total from ventas";
//--------------------- obtiene la ultima factura --------------------------------------------------------



//------------------------ obtiene el ultimo cliente al que se le vendio---------------------------------------------------------
            $consult = "SELECT max(idventas) from ventas";
            $retorno = mysqli_query($conexion,$consult);
            while ($ret_vista = mysqli_fetch_row($retorno)) {
                $datom = $ret_vista[0];
                

            }

//-------------------------------- obtiene datos del cliente  y los carga en variables-----------------------------------------------------
            $clientemostrar = "SELECT CONCAT(c.nombre, ' ',c.apellido),c.cedula,c.telefono FROM ventas v join clientes c on c.idclientes = v.idcliente
             WHERE v.idventas = '$datom'";
            $client_result = mysqli_query($conexion, $clientemostrar);

            while ($vista = mysqli_fetch_row($client_result)) {
                $mostrar = $vista[0];
                $ruc = $vista[1];
                $telefono = $vista[2];

            }

            $liquidacion =  mysqli_query($conexion, $sql);
            while ($view_liq = mysqli_fetch_row($liquidacion)){
                $total = $view_liq[1];
                $subtotal = $view_liq[0];
            }



            $this->SetY(-90);
            $this->SetX(20);
            $this->SetFont('Arial', '', 9);
            $this->Cell(50, 10, utf8_decode('Sub Total: Gs. ' . number_format($subtotal, 0, ",", ".")), 0, 0, '', 0);
            $this->Ln(7);
            
            $this->SetY(-100);
            $this->SetX(20);
            $this->SetFont('Arial', '', 9);
            $this->Cell(50, 10, utf8_decode('Total: Gs. ' . number_format($total, 0, ",", ".")), 0, 0, '', 0);
            

            $this->SetY(-25); // Posición: a 1,5 cm del final
            $this->SetFont('Arial', 'I', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
            $this->Cell(0, 10, utf8_decode('*** Gracias por su compra ***'), 0, 0, 'C'); //pie de pagina(numero de pagina)

        

            $this->SetY(-80);
            $this->SetX(20);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(50, 10, utf8_decode('Cliente: ' . $mostrar), 0, 0, '', 0);

            $this->SetY(-70);
            $this->SetX(20);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(20, 10, utf8_decode('RUC: ' . $ruc), 0, 0, '', 0);

            $this->SetY(-60);
            $this->SetX(20);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(30, 10, utf8_decode('Telefono: ' . $telefono), 0, 0, '', 0);
            
            $this->SetY(-25); // Posición: a 1,5 cm del final
            $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
            
            $this->Cell(330, 10, utf8_decode('Powered by: DCHR_SOFT '."©"), 0, 0, 'C'); // pie de pagina(fecha de pagina)
        }
    }


    $pdf = new PDF();
    $pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
    $pdf->AliasNbPages(); //muestra la pagina / y total de paginas

    $i = 0;
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetDrawColor(163, 163, 163); //colorBorde
    



    while ($ver = mysqli_fetch_row($result)) {

        

        $i = $i + 1;
        /* TABLA */
        $pdf->SetX(40);

        if($ver[4] == "5"){
            $mfinal = ($ver[2]*(0.05));
        }else if($ver[4] == "10"){
            $mfinal = ($ver[2]*(0.090909));
        }


        $pdf->Cell(15, 10, utf8_decode($ver[0]), 1, 0, 'C', 0);
        $pdf->Cell(40, 10, utf8_decode($ver[1]), 1, 0, 'C', 0);
        $pdf->Cell(20, 10, utf8_decode('Gs. ' . number_format($ver[2], 0, ",", ".")), 1, 0, 'C', 0);
        $pdf->Cell(15, 10, utf8_decode(round($ver[4])), 1, 0, 'C', 0);
        $pdf->Cell(15, 10, utf8_decode('Gs. ' . number_format($mfinal, 0, ",", ".")), 1, 0, 'C', 0);
        $pdf->Cell(20, 10, utf8_decode($ver[3]), 1, 1, 'C', 0);
        
        
    }

    $pdf->Output('Prueba.pdf', 'I'); //nombreDescarga, Visor(I->visualizar - D->descargar)

}

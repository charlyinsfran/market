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
    $monto = $_REQUEST['monto'];
    //----------------------------------
    $productos = $_SESSION['productos'];




    $bd->query("INSERT INTO ventas(fecha,idcliente,subtotal,total,vuelto,monto,condicion,idusuarioventa,fecha_save) values
     ('$fecha','$idcliente->idclientes','$subtotal','$total','$vuelto','$monto','$condicion','$idusuario','$fecha_guardado')");
    $venta = $bd->lastInsertId();

    foreach ($productos as $p) {

        $bd->query("INSERT INTO detalle_ventas(idproducto,venta_nro,precio,iva,cantidad) VALUES
     ($p->id_producto,$venta,$p->precio,$p->iva,$p->cantidadingresada)");
    }

    imprimir();
    
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
    
}


function eliminarproducto()
{
    unset($_SESSION['productos']);
}


function imprimir(){
    
	# Incluyendo librerias necesarias #
    require "fpdf/code128.php";
    include "../clases/Conexion.php";

    $c = new conectar();
    $conexion = $c->conexion();

    $lastventa = "SELECT max(idventas) from ventas";
            $ret_lastventa = mysqli_query($conexion,$lastventa);
            while ($ret_lastventavista = mysqli_fetch_row( $ret_lastventa)) {
                $lastventaid= $ret_lastventavista[0];
            }

    $sql = "SELECT p.id_producto,p.nombre,p.precio,dv.cantidad,dv.iva,v.subtotal,v.total,v.vuelto,v.monto from ventas v 
            JOIN detalle_ventas dv ON v.idventas = dv.venta_nro
            join productos p on p.id_producto = dv.idproducto
            JOIN clientes c on c.idclientes = v.idcliente 
            WHERE v.idventas = '$lastventaid'";
    $result = mysqli_query($conexion, $sql);


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

#        codigo para obtener cantidad de productos con iva 5%                                                #
    $piva5 = "SELECT count(p.id_producto),sum(p.precio),sum(dv.cantidad) from productos p JOIN detalle_ventas dv 
    on p.id_producto = dv.idproducto where p.iva = 5 and dv.venta_nro = '$lastventaid'";
    $prod_iva5 = mysqli_query($conexion, $piva5);

    while ($vistaiva5 = mysqli_fetch_row($prod_iva5)) {
        $iva5 = $vistaiva5[0];
        $calculoiva5 = $vistaiva5[1];
        $count = $vistaiva5[2];

    }

    $iva5return = ($calculoiva5*(5/100)*$count);


#        codigo para obtener cantidad de productos con iva 10%                                                #
$piva10= "SELECT count(p.id_producto),sum(p.precio),sum(dv.cantidad) from productos p JOIN detalle_ventas dv 
on p.id_producto = dv.idproducto where p.iva = 10 and dv.venta_nro = '$lastventaid'";
$prod_iva10 = mysqli_query($conexion, $piva10);

while ($vistaiva10 = mysqli_fetch_row($prod_iva10)) {
    $iva10 = $vistaiva10[0];
    $calculoiva10 = $vistaiva10[1];
    $count10 = $vistaiva10[2];

}

$iva10return = ($calculoiva10*(0.090909)*$count10);



    $pdf = new PDF_Code128('P','mm',array(80,258));
    $pdf->SetMargins(4,10,4);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("Nombre de empresa")),0,'C',false);
    $pdf->SetFont('Arial','',9);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","RUC: 0000000000"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Direccion San Salvador, El Salvador"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: 00000000"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Email: correo@ejemplo.com"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    date_default_timezone_set('America/Asuncion');
    $fecha = date('d/m/Y H:i:s');

    
    $cajero = $_SESSION['usuario'];

    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Fecha: ".$fecha),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Caja Nro: 1"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cajero: ".strtoupper($cajero)),0,'C',false);
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("Factura Nro: ".$datom)),0,'C',false);
    $pdf->SetFont('Arial','',9);

    $pdf->Ln(1);
    $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cliente: ".$mostrar),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Documento: ".$ruc),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$telefono),0,'C',false);
    

    $pdf->Ln(1);
    $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    # Tabla de productos #
    $pdf->Cell(10,5,iconv("UTF-8", "ISO-8859-1","Cant."),0,0,'C');
    $pdf->Cell(19,5,iconv("UTF-8", "ISO-8859-1","Precio"),0,0,'C');
    $pdf->Cell(15,5,iconv("UTF-8", "ISO-8859-1","IVA"),0,0,'C');
    $pdf->Cell(28,5,iconv("UTF-8", "ISO-8859-1","SubTotal"),0,0,'C');

    $pdf->Ln(3);
    $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    while ($ver = mysqli_fetch_row($result)) {
        $nombreproducto = $ver[1];
        $cantidad = $ver[3];
        $precio = $ver[2];
        $iva = $ver[4];
        $subtotalunit = $precio*$cantidad;
        $totalimp = $ver[6];
        $subtotalimp = $ver[5];
        $vuelto = $ver[7];
        $montopagado = $ver[8];

/* calculo iva por producto
        if($ver[4] == "5"){
            $mfinal = ($ver[2]*(0.05));
        }else if($ver[4] == "10"){
            $mfinal = ($ver[2]*(0.090909));
        }

*/
    /*----------  Detalles de la tabla  ----------*/
    $pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1",$nombreproducto),0,'C',false);
    $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",$cantidad),0,0,'C');
    $pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1","Gs. ".number_format($precio, 0, ",", ".")),0,0,'C');
    $pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1",$iva ." %"),0,0,'C');
    $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1","Gs. ".number_format($subtotalunit, 0, ",", ".")),0,0,'C');
    $pdf->Ln(4);
    $pdf->Ln(7);
    /*----------  Fin Detalles de la tabla  ----------*/
    }


    $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');

        $pdf->Ln(5);

    # Impuestos & totales #
    $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","SUBTOTAL"),0,0,'C');
    $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","Gs. ".number_format($subtotalimp, 0, ",", ".")),0,0,'C');
    $pdf->Ln(7);

    $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","Articulos IVA 5%"),0,0,'C');
    $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",$iva5),0,0,'C');
    $pdf->Ln(5);

    $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","IVA (5%)"),0,0,'C');
    $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","Gs. ".number_format($iva5return, 0, ",", ".")),0,0,'C');
    $pdf->Ln(5);

    $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","Articulos IVA 10%"),0,0,'C');
    $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",$iva10),0,0,'C');
    $pdf->Ln(5);

    $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","IVA (10%)"),0,0,'C');
    $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","Gs. ".number_format($iva10return, 0, ",", ".")),0,0,'C');
    $pdf->Ln(5);

    $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","LIQ. IVA TOTAL"),0,0,'C');
    $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","Gs. ".number_format(($iva10return+$iva5return), 0, ",", ".")),0,0,'C');
    $pdf->Ln(5);

    $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL A PAGAR"),0,0,'C');
    $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","Gs. ".number_format($totalimp, 0, ",", ".")),0,0,'C');

    $pdf->Ln(5);
    
    $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL PAGADO"),0,0,'C');
    $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","Gs. ".number_format($montopagado, 0, ",", ".")),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","VUELTO"),0,0,'C');
    $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","Gs. ".number_format($vuelto, 0, ",", ".")),0,0,'C');

    $pdf->Ln(10);

    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar este ticket ***"),0,'C',false);

    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1","Gracias por su compra"),'',0,'C');

    $pdf->Ln(9);

    # Codigo de barras #
    $pdf->Code128(5,$pdf->GetY(),"COD000001V0001",70,20);
    $pdf->SetXY(0,$pdf->GetY()+21);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","COD000001V0001"),0,'C',false);
    
    # Nombre del archivo PDF #
    $pdf->Output("I","Ticket_Nro_1.pdf",true);

    postventa();
}



function imprimir2()
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

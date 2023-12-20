
<?php 
require_once "../../clases/Conexion.php"; 

	$c = new conectar();
	$conexion=$c->conexion();

	$sql = "SELECT p.nombre, SUM(dv.cantidad)FROM detalle_ventas dv JOIN productos p ON dv.idproducto = p.id_producto
    GROUP BY p.id_producto ORDER BY SUM(dv.cantidad) DESC LIMIT 10";
	$result = mysqli_query($conexion,$sql);

	$valoresx = array(); //ventas
	$valoresy = array(); //fecha
	


	while ($ver=mysqli_fetch_row($result)) {
		$valoresy[] = $ver[0];
		$valoresx[] = $ver[1];
		
}

$datosX = json_encode($valoresx);
$datosY = json_encode($valoresy);



 ?>


<div id="graficacircular"></div>
<script>
	
function crearCadenacircular(json) {

	var parsed = JSON.parse(json);
	var arr = [];

	for(var x in parsed){
		arr.push(parsed[x]);
	}

	return arr;
}
</script>

<script>
	
	datosX = crearCadenacircular('<?php echo $datosX ?>');
	datosY = crearCadenacircular('<?php echo strtoupper($datosY) ?>');
	
    var pieDiv = document.getElementById("pie-chart");

var traceA = {
  type: "pie",
  font: {color: "white",size: 10},
  values: [datosX[0],datosX[1],datosX[2],datosX[3],datosX[4]],
  labels: [datosY[0],datosY[1],datosY[2],datosY[3],datosY[4]]
};

var data = [traceA];

var layout = {
  title: "Productos mas vendidos",
  height: 800,
  width: 900,
  font: {color: "black",size: 15,family: 'sans serif'}
};

Plotly.plot('graficacircular', data, layout);

</script>

<?php 
require_once "../../clases/Conexion.php"; 

	$c = new conectar();
	$conexion=$c->conexion();

	$sql = "SELECT total,fecha FROM compras;";
	$result = mysqli_query($conexion,$sql);

	$valoresx = array(); //compras
	$valoresy = array(); //fecha
	


	while ($ver=mysqli_fetch_row($result)) {
		$valoresy[] = $ver[0];
		$valoresx[] = $ver[1];
		
}

$datosX = json_encode($valoresx);
$datosY = json_encode($valoresy);



 ?>


<div id="graficaBarras"></div>
<script>
	
function crearCadenaBarras(json) {

	var parsed = JSON.parse(json);
	var arr = [];

	for(var x in parsed){
		arr.push(parsed[x]);
	}

	return arr;
}
</script>

<script>
	
	datosX = crearCadenaBarras('<?php echo $datosX ?>');
	datosY = crearCadenaBarras('<?php echo $datosY ?>');
	





var data = [

  {

    x: datosX,

    y: datosY,

    type: 'bar'

  }

];

var layout = {

  title:'Compras',

  xaxis: {
  	
  },

  yaxis: {

    title: 'Total Gs.'

  }
};

Plotly.newPlot('graficaBarras', data,layout);

</script>
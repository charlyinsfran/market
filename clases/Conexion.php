<?php 

class conectar {

private $servidor="localhost";
private $usuario ="root";
private $password = "";
private $bd="devs_market_1";

			public function conexion(){
					$conexion = mysqli_connect($this->servidor,
											$this->usuario,
											$this->password,
											$this->bd);

				return $conexion;
		}
}


?>
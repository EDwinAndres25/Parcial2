<?php
class conexion{
	private $link;
	
	public function conectar(){
		$this->link = new mysqli("localhost","admin","123","cinema");
		if ($this->link->connect_errno) {
			echo "Falló la conexión a MySQL: (" . $this->link->connect_errno . ") " . $this->link->connect_error;
		}
		return $this->link;
        //echo"conexion establecida<br>";
	}

	public function desconectar(){
		mysqli_close($this->link);
        //echo "conexion cerrada<br>";
	}
	
}
?>
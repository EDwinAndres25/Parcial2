<?php
class CRUD{
	private $link;
	function __construct($link){
		$this->link = $link;
	}

    //CREATE
	public function create_admin($nombre,$username,$correo,$password){
		$sql ="INSERT INTO administradores (nombre,username, correo, password)".
            "VALUES ('$nombre','$username', '$correo', '$password')";
		$result = $this->link->query($sql);
	}

	public function create_room($nombre,$codigo,$capacidad){
		$sql ="INSERT INTO salas (nombre,codigo,capacidad)".
            "VALUES ('$nombre', '$codigo', '$capacidad')";
		$result = $this->link->query($sql);
	}

    public function create_movie($nombre,$codigo,$clasificacion){
		$sql ="INSERT INTO peliculas (nombre,codigo,clasificacion)".
            "VALUES ('$nombre', '$codigo', '$clasificacion')";
		$result = $this->link->query($sql);
	}

	public function create_function($codigo, $cod_sala, $cod_pelicula, $fecha_hora) {
        $sala_result = $this->link->query("SELECT id FROM salas WHERE codigo = '$cod_sala'");
        $sala_row = $sala_result->fetch_assoc();
        $sala_id = $sala_row['id'] ?? null;
    
        $pelicula_result = $this->link->query("SELECT id FROM peliculas WHERE codigo = '$cod_pelicula'");
        $pelicula_row = $pelicula_result->fetch_assoc();
        $pelicula_id = $pelicula_row['id'] ?? null; 
    
        if ($sala_id !== null && $pelicula_id !== null) {
            $sql = "INSERT INTO funciones (codigo, fecha_hora, pelicula_id, sala_id) 
                    VALUES ('$codigo', '$fecha_hora', '$pelicula_id', '$sala_id')";
            
            if ($this->link->query($sql) === TRUE) {
                echo "Funcion añadida correctamente.";
            } else {
                echo "Error al añadir la funcion: " . $this->link->error;
            }
        } else {
            echo "Error: Sala o película no encontrada.";
        }
    }
   
    //READER
	public function lis_admin(){
		$sql = 'SELECT * FROM administradores';
		$result = $this->link->query($sql);		
		$arr=array();
		while ($fil = $result->fetch_assoc())$arr[]=$fil;		
		return($arr);
	}
	
    public function lis_room(){
		$sql = 'SELECT * FROM salas';
		$result = $this->link->query($sql);		
		$arr=array();
		while ($fil = $result->fetch_assoc())$arr[]=$fil;		
		return($arr);
	}

    public function lis_movie(){
		$sql = 'SELECT * FROM peliculas';
		$result = $this->link->query($sql);		
		$arr=array();
		while ($fil = $result->fetch_assoc())$arr[]=$fil;		
		return($arr);
	}
	
    public function lis_function_by_room($cod_sala) {
        $sala_result = $this->link->query("SELECT id FROM salas WHERE codigo = '$cod_sala'");
        
        if ($sala_result && $sala_row = $sala_result->fetch_assoc()) {
            $sala_id = $sala_row['id'];
    
            $sql = "SELECT * FROM funciones WHERE sala_id = '$sala_id'";
            $result = $this->link->query($sql);
            
            $arr = array();
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
            return $arr;
        } else {
            echo "Error: no hay funcion en esa sala";
        }
    }

    public function lis_function_by_movie($cod_pelicula) {
        $pelicula_result = $this->link->query("SELECT id FROM peliculas WHERE codigo = '$cod_pelicula'");
        
        if ($pelicula_result && $pelicula_row = $pelicula_result->fetch_assoc()) {
            $pelicula_id = $pelicula_row['id'];
    
            $sql = "SELECT * FROM funciones WHERE pelicula_id = '$pelicula_id'";
            $result = $this->link->query($sql);
            
            $arr = array();
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
            return $arr;
        } else {
            echo "Error: no hay funcion para esa pelicula";
        }
    }

    public function lis_function(){
        $sql = "SELECT * FROM funciones";
        $result = $this->link->query($sql);
        $arr = array();
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }
	
    //UPDATES
	public function update_admin($id, $nombre,$username,$correo, $password) {
		$sql = "UPDATE administradores SET 
				nombre = '$nombre', 
				username = '$username', 
				correo = '$correo',
				Password = '$password' 
				WHERE id = '$id'";
	
		if ($this->link->query($sql) === TRUE) {
			echo "Administrador actualizado exitosamente.";
		} else {
			echo "Error al actualizar el administrador: " . $this->link->error;
		}
	}
	
    public function update_room($id,$nombre,$codigo,$capacidad) {
		$sql = "UPDATE salas SET 
                nombre = '$nombre',
                codigo = '$codigo',
                capacidad = '$capacidad'
				WHERE id = '$id'";
				
        if ($this->link->query($sql) === TRUE) {
			echo "Sala actualizada exitosamente.";
		} else {
            echo "Error al actualizar la sala: ". $this->link->error;
        }
	}

    public function update_movie($id,$nombre,$codigo,$clasificacion) {
		$sql = "UPDATE peliculas SET 
                nombre = '$nombre',
                codigo = '$codigo',
                clasificacion = '$clasificacion'
				WHERE id = '$id'";
				
        if ($this->link->query($sql) === TRUE) {
			echo "Pelicula actualizada exitosamente.";
		} else {
            echo "Error al actualizar la pelicula: ". $this->link->error;
        }
	}
	
    public function update_function($id, $codigo, $fecha_hora, $cod_pelicula,$cod_sala){
        
        $sala_result = $this->link->query("SELECT id FROM salas WHERE codigo = '$cod_sala'");
        $sala_row = $sala_result->fetch_assoc();
        $sala_id = $sala_row['id'] ?? null;
    
        $pelicula_result = $this->link->query("SELECT id FROM peliculas WHERE codigo = '$cod_pelicula'");
        $pelicula_row = $pelicula_result->fetch_assoc();
        $pelicula_id = $pelicula_row['id'] ?? null;

        if ($sala_id !== null && $pelicula_id !== null) {
            $sql = "UPDATE funciones SET 
                codigo = '$codigo', 
                fecha_hora = '$fecha_hora', 
                pelicula_id = '$pelicula_id',
                sala_id='$sala_id'
                WHERE id = '$id'";
                
            if ($this->link->query($sql) === TRUE) {
                echo "funcion  actualizada exitosamente.";
            } else {
                echo "Error al actualizar la funcion: " . $this->link->error;
            }
        }
        else {
            echo "Error: Sala o película no encontrada.";
        }

        
    }
	

    //DELETES
	public function delete_admin( $id){
		$sql = "DELETE FROM administradores WHERE id = '$id'";
		$result = $this->link->query($sql);		
	}

    public function delete_room( $id){
		$check_sql = "SELECT COUNT(*) as total FROM funciones WHERE sala_id = '$id'";
        $check_result = $this->link->query($check_sql);
        $check_row = $check_result->fetch_assoc();
    
        if ($check_row['total'] > 0) {
            echo "No se puede eliminar la sala porque tiene funciones asociadas.";
        }
        else{
            $sql = "DELETE FROM salas WHERE id = '$id'";
            $result = $this->link->query($sql);
        
            if ($result) {
                echo "Sala eliminada exitosamente.";
            } else {
                echo "Error al eliminar la sala.";
            }
        }		
	}

    public function delete_movie( $id){
		$check_sql = "SELECT COUNT(*) as total FROM funciones WHERE pelicula_id = '$id'";
        $check_result = $this->link->query($check_sql);
        $check_row = $check_result->fetch_assoc();
    
        if ($check_row['total'] > 0) {
            echo "No se puede eliminar la pelicula porque tiene funciones asociadas.";
        }
        else{
            $sql = "DELETE FROM peliculas WHERE id = '$id'";
            $result = $this->link->query($sql);
        
            if ($result) {
                echo "pelicula eliminada exitosamente.";
            } else {
                echo "Error al eliminar la pelicula.";
            }
        }		
	}


    public function delete_function( $id){
        $sql = "DELETE FROM funciones WHERE Id = '$id'";
        $result = $this->link->query($sql);        
    }
	
	
}
?>
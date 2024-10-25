<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/log.css">
	<title>login</title>
</head>
<body>
	<form action="" method="post">
		Correo: <input type="text" name="correo"><br>
		Password: <input type="password" name="password"><br>
		<input type="submit" name="login">
	</form>

	<?PHP
	include('conexion.php');
	$conexion=new conexion();
	if(isset($_POST['login'])){
		
		$link=$conexion->conectar();
		
		
		if ($link->connect_errno) {
				echo "Falló la conexión a MySQL: (" . $link->connect_errno . ") " . $link->connect_error;
			}else{
				$correo = $_POST['correo'];
				$password = $_POST['password'];
				$sql ="SELECT Password FROM administradores WHERE correo = '$correo' and password = '$password'";

				$result = $link->query($sql);
				if($result->fetch_assoc()){
					session_start();
					$_SESSION['Reg']='ok';
					header('Location: inicio.php');
				}else{
					$_SESSION['Reg']='fail';
					echo "Usuario o Contraseña Incorrecto";
				}
			}
		mysqli_close($link);
	}
	?>
	
</body>
</html>
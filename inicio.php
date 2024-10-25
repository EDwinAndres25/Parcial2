<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=+, initial-scale=1.0">
	<link rel="stylesheet" href="css/inicio.css">
	<title>INICIO</title>
</head>
<body>
	<?php
	session_start();
	if(isset($_SESSION['Reg'])){
		if($_SESSION['Reg']=='ok'){
	?>
	<h1><h1>
	<form action="" method="post">
		<button type="submit"  name="admin">Gestionar Administradores</button>
		<button type="submit" name="room">Gestionar Salas</button>
		<button type="submit" name="movie">Gestionar Peliculas</button>
		<button type="submit" name="funtion">Gestionar Funciones</button>
		<button type="submit" name="logout">Cerrar Sesion</button>
	</form>
	<?php
		if (isset($_POST['admin'])) {
			header("Location: gestionar_admin.php");
		}
		if (isset($_POST['room'])) {
			header("Location: gestionar_room.php");
		}
		if (isset($_POST['movie'])) {
			header("Location: gestionar_movie.php");
		}
		if (isset($_POST['funtion'])) {
			header("Location: gestionar_function.php");
		}
		if (isset($_POST['logout'])) {
            session_destroy();
            header("Location: logout.php");
        }
	}else{
		header("Location: login.php");
	}
	}		
	?>
</body>
</html>
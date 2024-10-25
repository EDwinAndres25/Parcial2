<?php
session_start();
require_once("conexion.php");
require_once("CRUD.php");
$con = new conexion();
$usu = new CRUD($con->conectar());

if (!isset($_SESSION['Reg']) || $_SESSION['Reg'] != 'ok') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/gestiones.css">
    <title>Gestionar salas</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <h1>Gestión de Salas</h1>

    <form action="" method="post">
        <button type="submit" name="add_movie">Añadir Pelicula</button>
        <button type="submit" name="list_movie">Listar Pelicula</button>
    </form>

    <?php
    if (isset($_POST['add_movie'])) {
        ?>
            <form action="" method="post">
                Nombre: <input type="text" name="nombre" required><br>
                Codigo: <input type="text" name="codigo" required><br>
                Clasificacion: <select name="clasificacion" required>
                    <option value="TP">TP</option>
                    <option value="7">7</option>
                    <option value="12">12</option>
                    <option value="15">15</option>
                    <option value="18">18</option>
                </select><br>
                <input type="submit" name="add_movie_submit" value="Añadir peliculas">
            </form>
        <?php
        }
    if (isset($_POST['add_movie_submit'])) {
        $usu->create_movie($_POST['nombre'],$_POST['codigo'],$_POST['clasificacion']);
    }



    if (isset($_POST['list_movie'])) {
        $arr = $usu->lis_movie($con->conectar());
        ?>
        <h1>Lista de peliculas</h1>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Codigo</th>
                    <th>Clasificacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($arr); $i++) {
                    ?>
                    <tr>
                        <form method="post" action="">
                            <td><input type="text" name="id" value="<?php echo $arr[$i]['id']; ?>" readonly></td>
                            <td><input type="text" name="nombre" value="<?php echo $arr[$i]['nombre']; ?>" required></td>
                            <td><input type="text" name="codigo" value="<?php echo $arr[$i]['codigo']; ?>" required></td>
                            <td><input type="text" name="clasificacion" value="<?php echo $arr[$i]['clasificacion']; ?>"></td>
                            <td>
                                <input type="submit" name="eliminar" value="Eliminar">
                                <input type="submit" name="modificar" value="Modificar">
                            </td>
                        </form>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }
    if(isset($_POST['eliminar'])){
        $usu->delete_movie($_POST["id"]);
    }
    if (isset($_POST['modificar'])) {
        $id = $_POST["id"];
        ?>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            Nombre: <input type="text" name="nombre" required><br>
            Codigo: <input type="text" name="codigo" required><br>
            Clasificacion: <select name="clasificacion" required>
                <option value="TP">TP</option>
                <option value="7">7</option>
                <option value="12">12</option>
                <option value="15">15</option>
                <option value="18">18</option>
            </select><br>
            <input type="submit" name="Aceptar" value="Aceptar">
        </form>
        <?php
    }

    if (isset($_POST['Aceptar'])) {
        $id = $_POST["id"];
        $usu->update_movie($id,$_POST['nombre'],$_POST['codigo'],$_POST['clasificacion']);
    }

        $con->desconectar();
    ?>
</body>
</html>

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
        <button type="submit" name="add_room">Añadir Sala</button>
        <button type="submit" name="list_room">Listar Salas</button>
    </form>

    <?php
    if (isset($_POST['add_room'])) {
        ?>
            <form action="" method="post">
                Nombre: <input type="text" name="nombre" required><br>
                Codigo: <input type="text" name="codigo" required><br>
                Capacidad: <input type="number" name="capacidad" required><br>
                <input type="submit" name="add_room_submit" value="Añadir Salas">
            </form>
        <?php
        }
    if (isset($_POST['add_room_submit'])) {
        $usu->create_room($_POST['nombre'],$_POST['codigo'],$_POST['capacidad']);
    }



    if (isset($_POST['list_room'])) {
        $arr = $usu->lis_room($con->conectar());
        ?>
        <h1>Lista de Usuarios</h1>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Codigo</th>
                    <th>Capacidad</th>
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
                            <td><input type="number" name="capacidad" value="<?php echo $arr[$i]['capacidad']; ?>"></td>
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
        $usu->delete_room($_POST["id"]);
    }
    if (isset($_POST['modificar'])) {
        $id = $_POST["id"];
        ?>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            Nombre: <input type="text" name="nombre" required><br>
            Codigo: <input type="text" name="codigo" required><br>
            Capacidad: <input type="number" name="capacidad" required><br>
            <input type="submit" name="Aceptar" value="Aceptar">
        </form>
        <?php
    }

    if (isset($_POST['Aceptar'])) {
        $id = $_POST["id"];
        $usu->update_room($id,$_POST['nombre'],$_POST['codigo'],$_POST['capacidad']);
    }

        $con->desconectar();
    ?>
</body>
</html>

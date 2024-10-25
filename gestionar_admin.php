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
    <title>usuarios</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <h1>Gestión de Administradores</h1>
    <form action="" method="post">
        <button type="submit" name="add_admin">Añadir Administrador</button>
        <button type="submit" name="list_admin">Listar Administradores</button>
    </form>

    <?php
    if (isset($_POST['add_admin'])) {
        ?>
            <form action="" method="post">
                Nombre: <input type="text" name="nombre" required><br>
                Username: <input type="text" name="username" required><br>
                correo: <input type="email" name="correo" required><br>
                Password: <input type="password" name="password" required><br>
                <input type="submit" name="add_admin_submit" value="Añadir Administrador">
            </form>
        <?php
        }
    if (isset($_POST['add_admin_submit'])) {
        $usu->create_admin($_POST['nombre'],$_POST['username'],$_POST['correo'],$_POST['password']);
    }


    if (isset($_POST['list_admin'])) {
        $arr = $usu->lis_admin($con->conectar());
        ?>
        <h1>Lista de Administradores</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Username</th>
                    <th>Correo</th>
                    <th>Password</th>
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
                            <td><input type="text" name="username" value="<?php echo $arr[$i]['username']; ?>"></td>
                            <td><input type="email" name="correo" value="<?php echo $arr[$i]['correo']; ?>" required></td>
                            <td><input type="password" name="Password" value="<?php echo $arr[$i]['password']; ?>" required></td>
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
        $usu->delete_admin($_POST["id"]);
    }
    if (isset($_POST['modificar'])) {
        $id = $_POST["id"];
        ?>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            Nombre: <input type="text" name="nombre" required><br>
            Username: <input type="text" name="username"><br>
            Correo: <input type="email" name="correo" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" name="Aceptar" value="Aceptar">
        </form>
        <?php
    }

    if (isset($_POST['Aceptar'])) {
        $id = $_POST["id"];
        $usu->update_admin($id, $_POST["nombre"], $_POST["username"], $_POST["correo"], $_POST["password"]);
    }

        $con->desconectar();
    ?>
</body>
</html>
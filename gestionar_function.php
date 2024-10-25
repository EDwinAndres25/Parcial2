<?php
session_start();
require_once("conexion.php");
require_once("CRUD.php");
$con = new conexion();
$usu = new CRUD($con->conectar());

$conexion=$con->conectar();
$movie = "SELECT codigo FROM peliculas";
$room = "SELECT codigo FROM salas";

$resultado1 = $conexion->query($room);
$resultado2 = $conexion->query($movie);

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
</head>
<body>
    <nav>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <form action="" method="post">
        <button type="submit" name="add_function">Añadir Funcion</button>
        <button type="submit" name="list_by_room">Listar Funciones por Sala</button>
        <button type="submit" name="list_by_movie">Listar Funciones por Pelicula</button>
        <button type="submit" name="list_function">Listar Todas las Funcione</button>
    </form>

    <?php
    
    if (isset($_POST['add_function'])) {
    ?>
        <form action="" method="post">
            Codigo: <input type="text" name="codigo" required><br>
            Sala: <select name="sala" id="sala" required>
                <?php
                if ($resultado1->num_rows > 0) {
                    while($fila = $resultado1->fetch_assoc()) {
                        echo "<option value='" . $fila['codigo'] . "'>" . $fila['codigo'] . "</option>";
                    }
                } else {
                    echo "<option>No hay salas disponibles</option>";
                }
                ?>
            </select><br>

            Pelicula: <select name="pelicula" id="pelicula" required>
                <?php
                if ($resultado2->num_rows > 0) {
                    while($fila = $resultado2->fetch_assoc()) {
                        echo "<option value='" . $fila['codigo'] . "'>" . $fila['codigo'] . "</option>";
                    }
                } else {
                    echo "<option>No hay películas disponibles</option>";
                }
                ?>
            </select><br>
            Fecha de Inicio: <input type="datetime-local" id="fecha_hora" name="fecha_hora"><br>
            <input type="submit" name="add_function_submit" value="Añadir Funcion">
        </form>
    <?php
    }
    
    if (isset($_POST['add_function_submit'])) {
        $usu->create_function($_POST['codigo'], $_POST['sala'], $_POST['pelicula'], $_POST['fecha_hora']);
    }
//----------------------------------------------------------------
    if (isset($_POST['list_by_room'])) {
    ?>
        <form action="" method="post">
            Sala: <select name="sala" id="sala" required>
                    <?php
                    if ($resultado1->num_rows > 0) {
                        while($fila = $resultado1->fetch_assoc()) {
                            echo "<option value='" . $fila['codigo'] . "'>" . $fila['codigo'] . "</option>";
                        }
                    } else {
                        echo "<option>No hay salas disponibles</option>";
                    }
                    ?>
                </select><br>
            <input type="submit" name="list_by_room_submit" value="Listar funciones">
        </form>
    <?php
    }



    if (isset($_POST['list_by_room_submit'])) {
        $arr = $usu->lis_function_by_room($_POST['sala']);
        if (count($arr) > 0) {
            echo "<h2>Funciones de la sala" . $_POST['sala'] . ":</h2>";
            ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>Fecha y Hora</th>
                        <th>Sala</th>
                        <th>Pelicula</th>
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
                                <td><input type="text" name="codigo" value="<?php echo $arr[$i]['codigo']; ?>" required></td>
                                <td><input type="text" name="fecha_hora" value="<?php echo $arr[$i]['fecha_hora']; ?>" required></td>
                                <td><input type="text" name="sala_id" value="<?php echo $arr[$i]['sala_id']; ?>" readonly></td>
                                <td><input type="text" name="pelicula_id" value="<?php echo $arr[$i]['pelicula_id']; ?>" readonly></td>
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
        } else {
            echo "No se encontraron mascotas para esta cédula.";
        }
    }
   
//----------------------------------------------------------------

    if (isset($_POST['list_by_movie'])) {
        ?>
            <form action="" method="post">
                Pelicula: <select name="pelicula" id="pelicula" required>
                        <?php
                        if ($resultado2->num_rows > 0) {
                            while($fila = $resultado2->fetch_assoc()) {
                                echo "<option value='" . $fila['codigo'] . "'>" . $fila['codigo'] . "</option>";
                            }
                        } else {
                            echo "<option>No hay salas disponibles</option>";
                        }
                        ?>
                    </select><br>
                <input type="submit" name="list_by_movie_submit" value="Listar funciones">
            </form>
        <?php
    }

    if (isset($_POST['list_by_movie_submit'])) {
        $arr = $usu->lis_function_by_movie($_POST['pelicula']);
        if (count($arr) > 0) {
            echo "<h2>Funciones de la Pelicula" . $_POST['pelicula'] . ":</h2>";
            ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>Fecha y Hora</th>
                        <th>Sala</th>
                        <th>Pelicula</th>
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
                                <td><input type="text" name="codigo" value="<?php echo $arr[$i]['codigo']; ?>" required></td>
                                <td><input type="text" name="fecha_hora" value="<?php echo $arr[$i]['fecha_hora']; ?>" required></td>
                                <td><input type="text" name="sala_id" value="<?php echo $arr[$i]['sala_id']; ?>" readonly></td>
                                <td><input type="text" name="pelicula_id" value="<?php echo $arr[$i]['pelicula_id']; ?>" readonly></td>
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
        } else {
            echo "No se encontraron  funciones para esta pelicula.";
        }
    }

//----------------------------------------------------------------

    if (isset($_POST['list_function'])) {
        $arr = $usu->lis_function();
        if (count($arr) > 0) {
            echo "<h2>Lista de todas las funciones:</h2>";
            ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>Fecha y Hora</th>
                        <th>Sala</th>
                        <th>Pelicula</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($arr); $i++) {
                        ?>
                        <tr>
                        <form method="post" action="">
                                <td><input type="text" name="id" value="<?php echo $arr[$i]['id']; ?>" readonly></td>
                                <td><input type="text" name="codigo" value="<?php echo $arr[$i]['codigo']; ?>" required></td>
                                <td><input type="text" name="fecha_hora" value="<?php echo $arr[$i]['fecha_hora']; ?>" required></td>
                                <td><input type="text" name="sala_id" value="<?php echo $arr[$i]['sala_id']; ?>" readonly></td>
                                <td><input type="text" name="pelicula_id" value="<?php echo $arr[$i]['pelicula_id']; ?>" readonly></td>
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
        } else {
            echo "No hay funciones registradas.";
        }
    }
//----------------------------------------------------------------
    if (isset($_POST['modificar'])) {
    $id = $_POST["id"];
    ?>
    <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            Codigo: <input type="text" name="codigo" required><br>
            Sala: <select name="sala" id="sala" required>
                <?php
                if ($resultado1->num_rows > 0) {
                    while($fila = $resultado1->fetch_assoc()) {
                        echo "<option value='" . $fila['codigo'] . "'>" . $fila['codigo'] . "</option>";
                    }
                } else {
                    echo "<option>No hay salas disponibles</option>";
                }
                ?>
            </select><br>

            Pelicula: <select name="pelicula" id="pelicula" required>
                <?php
                if ($resultado2->num_rows > 0) {
                    while($fila = $resultado2->fetch_assoc()) {
                        echo "<option value='" . $fila['codigo'] . "'>" . $fila['codigo'] . "</option>";
                    }
                } else {
                    echo "<option>No hay películas disponibles</option>";
                }
                ?>
            </select><br>
            Fecha de Inicio: <input type="datetime-local" id="fecha_hora" name="fecha_hora"><br>
            <input type="submit" name="aceptar" value="aceptar">
    </form>
    <?php
}

    if (isset($_POST['aceptar'])) {
        $id = $_POST['id'];
        $usu->update_function($id, $_POST['codigo'],  $_POST['fecha_hora'], $_POST['pelicula'],$_POST['sala']);
    }
//----------------------------------------------------------------
    if (isset($_POST['eliminar'])) {
        $id = $_POST['id'];
        $usu->delete_function($id);
    }
    ?>
</body>
</html>
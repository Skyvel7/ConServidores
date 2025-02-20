<?php
$host = '10.0.0.2';      // IP del Servidor de Base de Datos
$port = 5432;
$dbname = 'mibd';
$dbuser = 'webuser';
$dbpassword = 'contra1234';  // Reemplaza con la contraseña realssssssss

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Conexión fallida: " . pg_last_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregar"])) {
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"];
        $sql = "INSERT INTO productos (nombre, precio, stock) VALUES ('$nombre', $precio, $stock)";
        pg_query($conn, $sql);
    } elseif (isset($_POST["eliminar"])) {
        $id = $_POST["id"];
        $sql = "DELETE FROM productos WHERE id=$id";
        pg_query($conn, $sql);
    }
}

$productos = pg_query($conn, "SELECT * FROM productos");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tienda Skyvel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            text-align: center;
        }
        h1 {
            color: #1877f2;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            margin-bottom: 20px;
        }
        input, button {
            margin: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #1877f2;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #155db2;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: white;
            margin: 10px auto;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 300px;
        }
        form.inline {
            display: inline;
        }
    </style>
</head>
<body>
    <h1>Tienda</h1>
    <form method="POST">
        <input name="nombre" placeholder="Nombre" required>
        <input name="precio" placeholder="Precio" type="number" required>
        <input name="stock" placeholder="Stock" type="number" required>
        <button type="submit" name="agregar">Agregar</button>
    </form>
    <ul>
        <?php while ($row = pg_fetch_assoc($productos)) { ?>
            <li>
                <?php echo $row["nombre"] . " - $" . $row["precio"] . " - Stock: " . $row["stock"]; ?>
                <form method="POST" class="inline">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="eliminar">Eliminar</button>
                </form>
            </li>
        <?php } ?>
    </ul>
    <?php pg_close($conn); ?>
</body>
</html>

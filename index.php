<?php
// Configuración de la base de datos
require_once 'db_connection.php';


// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos agrupados por categoría
$sql = "SELECT * FROM platera ORDER BY FIELD(kategoria, 'Lehenengo platera', 'Bigarren platera', 'Edaria', 'Postrea')";
$result = $conn->query($sql);

$categorias = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categorias[$row['kategoria']][] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta del Restaurante</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="logo">
    <img src="logo.png" alt="Logo del Restaurante">
    <!-- <div class="menu-button">
        <a href="erreserba.php"><button>Erreserba egin</button></a>
    </div> -->
</header>

    <div class="container">
        <?php foreach($categorias as $categoria => $platos): ?>
            <div class="categoria">
                <h2 class="categoria-titulo"><?= $categoria ?></h2>
                <?php foreach($platos as $plato): ?>
                    <div class="plato">
                        <div class="plato-nombre"><?= $plato['izena'] ?></div>
                        <div class="plato-precio"><?= number_format($plato['prezioa'], 2) ?> €</div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
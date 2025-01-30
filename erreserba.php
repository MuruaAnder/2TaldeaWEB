<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "1WMG2023";
$dbname = "2taldea";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Variables para mensajes y valores del formulario
$error = '';
$success = '';
$izena = '';
$pertsonak = '';
$data = '';

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y limpiar datos
    $izena = trim($_POST['izena']);
    $pertsonak = intval($_POST['pertsonaKop']);
    $data = $_POST['data'];
    
    // Validaciones
    if (empty($izena)) {
        $error = "Izena beharrezkoa da";
    } elseif ($pertsonak < 1) {
        $error = "Pertsona kopurua ez da egokia";
    } elseif (strtotime($data) < strtotime('today')) {
        $error = "Data ez da egokia (iraganeko data)";
    } else {
        // Insertar en la base de datos
        $stmt = $conn->prepare("INSERT INTO erreserba (izena, pertsonaKop, data) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $izena, $pertsonak, $data);
        
        if ($stmt->execute()) {
            $success = "Erreserba ondo erregistratu da!";
            // Resetear valores del formulario
            $izena = '';
            $pertsonak = '';
            $data = '';
        } else {
            $error = "Errorea erreserba egiterakoan: " . $conn->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreserbak</title>
    <link rel="stylesheet" href="style.css">
    
        
</head>
<body>
<header class="logo">
    <img src="logo.png" alt="Logo del Restaurante">
    <div class="menu-button">
        <a href="index.php"><button>Menua ikusi</button></a>
    </div>
</header>

    <div class="container">
        <h2>Erreserbak egin</h2> 
        
        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="izena">Izena:</label>
                <input type="text" id="izena" name="izena" required value="<?php echo htmlspecialchars($izena); ?>">
            </div>
            
            <div class="form-group">
                <label for="pertsonaKop">Pertsona kopurua:</label>
                <input type="number" id="pertsonaKop" name="pertsonaKop" min="1" required value="<?php echo $pertsonak; ?>">
            </div>
            
            <div class="form-group">
                <label for="data">Data:</label>
                <input type="date" id="data" name="data" required value="<?php echo $data; ?>">
            </div>
            
            <button type="submit">Bidali erreserba</button>
        </form>
    </div>
</body>
</html>
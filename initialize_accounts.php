<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank_project";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inicializar cuenta con saldo
$sql = "INSERT INTO accounts (balance) VALUES (1000.00)";
if ($conn->query($sql) === TRUE) {
    echo "Account initialized successfully";
} else {
    echo "Error initializing account: " . $conn->error;
}

$conn->close();
?>

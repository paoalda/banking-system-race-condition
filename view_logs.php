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

$sql = "SELECT * FROM logs ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Account ID: " . $row["account_id"]. " - Amount: " . $row["amount"]. " - Type: " . $row["transaction_type"]. " - Date: " . $row["created_at"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>

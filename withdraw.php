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

$account_id = $_POST['account_id'];
$amount = $_POST['amount'];

// Iniciar transacción
$conn->begin_transaction();

try {
    // Obtener saldo actual
    $result = $conn->query("SELECT balance FROM accounts WHERE id = $account_id FOR UPDATE");
    $row = $result->fetch_assoc();
    $current_balance = $row['balance'];

    if ($current_balance >= $amount) {
        // Actualizar saldo
        $new_balance = $current_balance - $amount;
        $conn->query("UPDATE accounts SET balance = $new_balance WHERE id = $account_id");

        // Registrar la transacción
        $conn->query("INSERT INTO logs (account_id, amount, transaction_type) VALUES ($account_id, $amount, 'withdrawal')");

        // Confirmar la transacción
        $conn->commit();

        echo "Withdrawal successful. New balance: $new_balance";
    } else {
        echo "Insufficient funds.";
    }
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    echo "Transaction failed: " . $e->getMessage();
}

$conn->close();
?>

<?php
require_once 'connect.php';

if(isset($_GET['payment_id']) && !empty($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    // Видалення оплати з бази даних
    $sql_delete_payment = "DELETE FROM Payments WHERE id = $payment_id";
    if ($conn->query($sql_delete_payment) === TRUE) {
        echo "Оплата успішно видалена.";
    } else {
        echo "Помилка видалення оплати: " . $conn->error;
    }
} else {
    echo "Недостатньо даних для видалення оплати.";
}

$conn->close();


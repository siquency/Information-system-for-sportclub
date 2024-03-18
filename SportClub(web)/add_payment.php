<?php
require_once 'connect.php';

// Перевірка, чи надійшли необхідні дані через POST-запит
if(isset($_POST['member_id'], $_POST['subscription'], $_POST['date'])) {
    // Отримання даних з форми
    $member_id = $_POST['member_id'];
    $subscription_id = $_POST['subscription'];
    $date = $_POST['date'];

    // Вставка нового запису оплати в базу даних
    $sql_insert_payment = "INSERT INTO Payments (FK_Subscription, Date, FK_Member) VALUES ('$subscription_id', '$date', '$member_id')";
    if ($conn->query($sql_insert_payment) === TRUE) {
        // Перенаправлення на сторінку перегляду оплат
        echo "<script>alert('Оплату успішно додано!')</script>";
        header("Location: view_payments.php?id=$member_id");
        
      
    } else {
        echo "Помилка: " . $conn->error;
    }
} else {
    echo "Недостатньо даних для додавання оплати.";
}

$conn->close();


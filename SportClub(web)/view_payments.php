<!DOCTYPE html>
<html>
<head>
    <title>Перегляд оплат для учасника</title>
    <link rel="stylesheet" type="text/css" href="styles/style(index).css">
</head>
<body>
    <h1>Перегляд оплат для учасника</h1>

    <?php
    require_once 'connect.php';

    // Перевірка, чи переданий ID учасника
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $member_id = $_GET['id'];

        // Отримання даних про учасника з бази даних
        $sql_member = "SELECT * FROM Members WHERE id = $member_id";
        $result_member = $conn->query($sql_member);

        if ($result_member->num_rows > 0) {
            $member = $result_member->fetch_assoc();
            echo "<h2>Ім'я учасника: ".$member['Name']." ".$member['Surname']."</h2>";

            // Отримання оплат для цього учасника разом з інформацією про підписку
            $sql_payments = "SELECT Payments.id, Payments.Date, Subscriptions.Name AS Subscription, Subscriptions.Price 
                            FROM Payments 
                            INNER JOIN Subscriptions ON Payments.FK_Subscription = Subscriptions.id 
                            WHERE Payments.FK_Member = $member_id";
            $result_payments = $conn->query($sql_payments);

            if ($result_payments->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Дата</th><th>Підписка</th><th>Ціна</th><th>Дії</th></tr>";
                while($payment = $result_payments->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$payment['Date']."</td>";
                    echo "<td>".$payment['Subscription']."</td>";
                    echo "<td>".$payment['Price']."</td>";
                    echo "<td><a href='?id=$member_id&action=delete_payment&payment_id=".$payment['id']."'>Видалити</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Цей учасник не має оплат.";
            }
            // Форма для додавання оплати
            echo "<h2>Додати оплату</h2>";
            echo "<form action='add_payment.php' method='post'>";
            echo "<input type='hidden' name='member_id' value='$member_id'>";
            echo "<label for='subscription'>Підписка:</label>";
            echo "<select name='subscription' id='subscription'>";
            // Отримання списку підписок з бази даних
            $sql_subscriptions = "SELECT * FROM Subscriptions";
            $result_subscriptions = $conn->query($sql_subscriptions);
            while ($subscription = $result_subscriptions->fetch_assoc()) {
                echo "<option value='".$subscription['id']."'>".$subscription['Name']."</option>";
            }
            echo "</select><br>";
            echo "<label for='date'>Дата оплати:</label>";
            echo "<input type='date' name='date' id='date' required><br>";
            echo "<input type='submit' value='Додати оплату'>";
            echo "</form>";

            // Видалення оплати
            if (isset($_GET['action']) && $_GET['action'] == 'delete_payment' && isset($_GET['payment_id'])) {
                $payment_id = $_GET['payment_id'];
                $sql_delete_payment = "DELETE FROM Payments WHERE id = $payment_id";
                if ($conn->query($sql_delete_payment) === TRUE) {
                    echo "<p style='color: green;'>Оплата успішно видалена.</p>";
                } else {
                    echo "<p style='color: red;'>Помилка видалення оплати: " . $conn->error . "</p>";
                }
            }
        } else {
            echo "Учасник не знайдений.";
        }

    } else {
        echo "Недостатньо даних для відображення оплат.";
    }
    echo "<a href='index.php' class='btn'>Повернутися на головну</a>";

    $conn->close();
    ?>
</body>
</html>

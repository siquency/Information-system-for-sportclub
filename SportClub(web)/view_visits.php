<!DOCTYPE html>
<html>
<head>
    <title>Список візитів</title>
    <link rel="stylesheet" type="text/css" href="styles/style(index).css">
</head>
<body>
    <h1>Список візитів</h1>
    <?php
        // Підключення до бази даних
        require_once 'connect.php';

        // Перевірка, чи передано ідентифікатор користувача через GET-параметр
        if(isset($_GET['id']) && !empty($_GET['id'])) {
            $member_id = $_GET['id'];

            // SQL-запит для отримання даних про візити для конкретного користувача
            $sql = "SELECT Visit.*, Trainers.Name AS TrainerName, Trainers.Surname AS TrainerSurname, Type_of_visits.Name AS VisitType
                    FROM Visit
                    JOIN Trainers ON Visit.FK_Trainer = Trainers.id
                    JOIN Type_of_visits ON Visit.FK_Type_of_visit = Type_of_visits.id
                    WHERE Visit.FK_Member = $member_id";

            $result = $conn->query($sql);

            // Виведення даних про візити
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>Дата</th>";
                echo "<th>Час</th>";
                echo "<th>Тренер</th>";
                echo "<th>Тип візиту</th>";
                echo "</tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['Date']."</td>";
                    echo "<td>".$row['Time']."</td>";
                    echo "<td>".$row['TrainerName']." ".$row['TrainerSurname']."</td>";
                    echo "<td>".$row['VisitType']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Цей користувач ще не мав візитів.";
            }
        } else {
            echo "Не вказано ідентифікатор користувача.";
        }

        // Закриття підключення до бази даних
        $conn->close();
    ?>
   
    <a href="javascript:history.back()">Назад</a>
</body>
</html>

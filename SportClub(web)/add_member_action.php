<?php
// Перевірка, чи отримано дані від форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних про учасника з форми
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone_number = $_POST['phone_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $parents_contact = $_POST['parents_contact'];
    $street_name = $_POST['street_name'];
    $house_number = $_POST['house_number']; 
    $date_of_entry = $_POST['date_of_entry'];
   

    // Підключення до бази даних
    require_once 'connect.php';

    // Перевірка, чи вже існує така вулиця у базі даних
    $sql = "SELECT id FROM Streets WHERE Name = '$street_name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $street_id = $row['id'];
    } else {
        // Якщо вулиця не знайдена, додати новий запис у таблицю Streets
        $insert_street_sql = "INSERT INTO Streets (Name) VALUES ('$street_name')";
        if ($conn->query($insert_street_sql) === TRUE) {
            $street_id = $conn->insert_id;
        } else {
            echo "Error: " . $insert_street_sql . "<br>" . $conn->error;
            exit(); // Вихід з обробки, якщо сталася помилка
        }
    }
   
  

// Підготовка та виконання SQL-запиту для додавання нової вулиці
$sql = "INSERT INTO Streets (Name, FK_City) VALUES ('$street_name', '1')";



if ($conn->query($sql) === TRUE) {
    // Отримання ідентифікатора нової вулиці
    $street_id = $conn->insert_id;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit(); // Вихід з обробки, якщо сталася помилка
}

    // Підготовка та виконання SQL-запиту для додавання нового учасника
    $sql = "INSERT INTO Members (Name, Surname, Phone_number, Date_of_birth, Age, FK_Sex, Parents_contact, FK_Street, `House_number`, Date_of_entry) 
        VALUES ('$name', '$surname', '$phone_number', '$date_of_birth', '$age', '$sex', '$parents_contact', '$street_id', '$house_number', '$date_of_entry')";

    if ($conn->query($sql) === TRUE) {
        // Відображення сповіщення про успішне додавання
        echo "<script>alert('Інформацію успішно збережено'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request";
}


<?php
// Перевірка, чи отримано дані від форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних про учасника з форми
    $id = $_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone_number = $_POST['phone_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $parents_contact = $_POST['parents_contact'];
    $street_name = $_POST['street_name']; // Оновлено назву поля на street_name
    $date_of_entry = $_POST['date_of_entry'];
    $house_number = $_POST['house_number'];
   

    require_once 'connect.php';
     // Перевірка, чи вже існує така вулиця у базі даних
     $sql = "SELECT id FROM Streets WHERE Name = '$street_name'";
     $result = $conn->query($sql);
 
     if ($result->num_rows > 0) {
         $row = $result->fetch_assoc();
         $street_id = $row['id'];
     } else {
         // Якщо вулиця не знайдена, додати новий запис у таблицю Streets та отримати його ідентифікатор
         $insert_street_sql = "INSERT INTO Streets (Name) VALUES ('$street_name')";
         if ($conn->query($insert_street_sql) === TRUE) {
             $street_id = $conn->insert_id;
         } else {
             echo "Error: " . $insert_street_sql . "<br>" . $conn->error;
             exit(); // Вихід з обробки, якщо сталася помилка
         }
     }
     
    // Підготовка та виконання SQL-запиту для оновлення даних про учасника
        $sql = "UPDATE Members SET 
            Name='$name', 
            Surname='$surname', 
            Phone_number='$phone_number', 
            Date_of_birth='$date_of_birth', 
            Age='$age', 
            FK_Sex='$sex', 
            Parents_contact='$parents_contact', 
            FK_Street='$street_id', 
            Date_of_entry='$date_of_entry', 
            House_number='$house_number'
            
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Інформацію успішно збережено'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request";
}


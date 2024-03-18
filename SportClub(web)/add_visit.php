<?php
// Підключення до бази даних
require_once 'connect.php';

// Отримання ідентифікатора учасника з POST-запиту
$member_id = $_POST['member_id'];

// Перевірка, чи був переданий ідентифікатор учасника
if(!empty($member_id)) {
    // Додавання відвідування до бази даних
    $sql = "INSERT INTO Visit (FK_Member, FK_Trainer, Date, Time, FK_Type_of_visit) VALUES (?, ?, CURDATE(), CURTIME(), ?)";
    $stmt = $conn->prepare($sql);
    
    // У вашому випадку, треба вказати FK_Trainer і FK_Type_of_visit
    $trainer_id = 1; // Замініть це на ідентифікатор тренера
    $visit_type_id = 1; // Замініть це на ідентифікатор типу візиту

    $stmt->bind_param("iii", $member_id, $trainer_id, $visit_type_id);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        // Відвідування успішно додане
        echo "Visit added successfully!";
    } else {
        // Помилка при додаванні відвідування
        echo "Error adding visit!";
    }
    
    $stmt->close();
} else {
    // Якщо ідентифікатор учасника не був переданий
    echo "Member ID not provided!";
}

// Закриття з'єднання з базою даних
$conn->close();
?>

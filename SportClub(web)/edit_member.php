<!DOCTYPE html>
<html>
<head>
    <title>Редагувати учасника</title>
    <link rel="stylesheet" href="styles/style(edit_member).css">
</head>
<body>
    <h1>Редагувати учасника</h1>
    <?php
    $id = $_GET['id'];

   require_once 'connect.php';

    $sql = "SELECT * FROM Members WHERE id=".$id;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    ?>
    <form action="edit_member_action.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label>Ім'я:</label>
        <input type="text" name="name" value="<?php echo $row['Name']; ?>"><br>

        <label>Прізвище:</label>
        <input type="text" name="surname" value="<?php echo $row['Surname']; ?>"><br>

        <label>Номер телефону:</label>
        <input type="text" name="phone_number" value="<?php echo $row['Phone_number']; ?>"><br>

        <label>Дата народження:</label>
        <input type="date" name="date_of_birth" value="<?php echo $row['Date_of_birth']; ?>"><br>

        <label>Вік:</label>
        <input type="number" name="age" value="<?php echo $row['Age']; ?>"><br>

        <label>Стать:</label>
        <input type="text" name="sex" value="<?php echo $row['FK_Sex']; ?>"><br>

        <label>Батьківський номер телефону:</label>
        <input type="text" name="parents_contact" value="<?php echo $row['Parents_contact']; ?>"><br>

       
        

        <label>Номер будинку:</label>
        <input type="text" name="house_number" value="<?php echo $row['House_number']; ?>"><br>

        <label>Дата вступу в клуб:</label>
        <input type="date" name="date_of_entry" value="<?php echo $row['Date_of_entry']; ?>"><br>
        
        <label>Адреса проживання:</label>
        <input type="text" name="street_name"><br>


        <input type="submit" value="Зберегти">
    </form>
    <?php
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
</body>
</html>

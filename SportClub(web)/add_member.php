<!DOCTYPE html>
<html>
<head>
    <title>Додати учасника</title>
    <link rel="stylesheet" href="styles/style(add_member).css">
</head>
<body>
    <h1>Додати учасника</h1>
    <?php

   require_once 'connect.php';

    $sql = "SELECT * FROM Streets";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    

    ?>
    <form action="add_member_action.php" method="post">
        <label>Ім'я:</label>
        <input type="text" name="name"><br>

        <label>Прізвище:</label>
        <input type="text" name="surname"><br>

        <label>Номер телефону:</label>
        <input type="text" name="phone_number"><br>

        <label>Дата народження:</label>
        <input type="date" name="date_of_birth"><br>

        <label>Вік:</label>
        <input type="number" name="age"><br>

        <label>Стать:</label>
        <select  name="sex">
        <?php
           
            $sql = "SELECT * FROM Sex";
            $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    
                        echo "<option value='".$row['id']."'>".$row['Name']."</option>";
                    }
                }
         ?>
        </select>

        <label>Батьківський номер телефону:</label>
        <input type="text" name="parents_contact"><br>

        <label>Дата вступу в клуб:</label>
        <input type="date" name="date_of_entry"><br>

        <label>Номер будинку:</label>
        <input type="text" name="house_number"><br>


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

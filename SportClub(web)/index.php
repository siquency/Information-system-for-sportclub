<!DOCTYPE html>
<html>
<head>
    <title>Список учасників</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Список учасників</h1>
        
        <form action="" method="GET">
            <label for="search_name">Пошук за ім'ям:</label>
            <input type="text" id="search_name" name="search_name">
            <button type="submit" class="btn btn-info">Пошук</button>
        </form>
        
        <!-- Контейнер для сканера QR-кодів -->
        <div id="scanner" style="margin-bottom: 20px;"></div>
        
        <!-- Кнопка для включення/виключення камери -->
        <button id="toggleCamera" class="btn btn-primary">Включити камеру</button>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Ім'я</th>
                    <th scope="col">Прізвище</th>
                    <th scope="col">Номер телефону</th>
                    <th scope="col">Дата народження</th>
                    <th scope="col">Вік</th>
                    <th scope="col">Стать</th>
                    <th scope="col">Батьківський номер телефону</th>
                    <th scope="col">Вулиця проживання</th>
                    <th scope="col">Номер будинку</th>
                    <th scope="col">Дата вступу в клуб</th>
                    <th scope="col">Дії</th>
                </tr>
            </thead>
            <tbody>
            <?php
            require_once 'connect.php';

            // Отримання даних про учасників з бази даних
            $sql = "SELECT Members.*, Sex.Name AS SexName, Streets.Name AS Address
                    FROM Members
                    JOIN Sex ON Members.FK_Sex = Sex.id
                    JOIN Streets ON Members.FK_Street = Streets.id";
                
            // Додавання умови пошуку за ім'ям, якщо введене користувачем
            if(isset($_GET['search_name']) && !empty($_GET['search_name'])) {
                $search_name = $_GET['search_name'];
                $sql .= " WHERE Members.Name LIKE '%$search_name%'";
            }


            $result = $conn->query($sql);

            // Виведення даних про учасників
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['Name']."</td>";
                    echo "<td>".$row['Surname']."</td>";
                    echo "<td>".$row['Phone_number']."</td>";
                    echo "<td>".$row['Date_of_birth']."</td>";
                    echo "<td>".$row['Age']."</td>";
                    echo "<td>".$row['SexName']."</td>"; 
                    echo "<td>".$row['Parents_contact']."</td>";
                    echo "<td>".$row['Address']."</td>"; 
                    echo "<td>".$row['House_number']."</td>"; 
                    echo "<td>".$row['Date_of_entry']."</td>";
                    echo "<td><a  href='view_payments.php?id=".$row['id']."'>Переглянути оплати</a> |<a href='view_visits.php?id=".$row['id']."'>Переглянути візити</a> | <a href='edit_member.php?id=".$row['id']."'>Редагувати</a> | <a  href='delete_member.php?id=".$row['id']."'>Видалити</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "0 results";
            }

            $conn->close();
            ?>
            </tbody>
        </table>
        <a class="btn btn-success" href="add_member.php">Додати учасника</a>
    </div>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <!-- Сканер QR-кодів через камеру -->
    <script src="https://cdn.jsdelivr.net/npm/quagga"></script>
    <script>
        var scannerIsRunning = false;
        var quaggaConfig = {
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#scanner'),
                constraints: {
                    width: 640,
                    height: 480,
                    facingMode: "environment" // "environment" для задньої камери, "user" для передньої
                },
            },
            decoder: {
                readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader", "codabar_reader", "upc_reader", "upc_e_reader", "i2of5_reader", "2of5_reader", "code_93_reader"],
            },
        };

        // Функція для включення/виключення камери
        function toggleCamera() {
            if (scannerIsRunning) {
                Quagga.stop();
                scannerIsRunning = false;
                document.getElementById('toggleCamera').innerText = 'Включити камеру';
            } else {
                Quagga.init(quaggaConfig, function(err) {
                    if (err) {
                        console.log(err);
                        return;
                    }
                    console.log("Initialization finished. Ready to start");
                    Quagga.start();
                    scannerIsRunning = true;
                    document.getElementById('toggleCamera').innerText = 'Виключити камеру';
                });
            }
        }

        document.getElementById('toggleCamera').addEventListener('click', toggleCamera);
        
        // Функція для обробки результату сканування QR-коду
        function onScanSuccess(decodedText) {
            // Відправка AJAX-запиту на сервер з ідентифікатором учасника
            $.ajax({
                url: 'add_visit.php',
                method: 'POST',
                data: { member_id: decodedText },
                success: function(response) {
                    // Обробка відповіді сервера
                    console.log(response);
                    alert('Відвідування додано!');
                },
                error: function(xhr, status, error) {
                    // Обробка помилок
                    console.error(xhr.responseText);
                    alert('Помилка під час додавання відвідування!');
                }
            });
        }

        // Прослуховування події "decoded", коли QR-код зчитаний
        Quagga.onDetected(function(result) {
            var code = result.codeResult.code;
            console.log('Decoded code:', code);
            onScanSuccess(code); // Виклик функції для обробки сканованого коду
        });
    </script>
</body>
</html>

<?php
$servername = "db";
$username = "denis";
$password = "samm";
$dbname = "Denis";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Не удалось подключиться к базе данных: " . $conn->connect_error);
}

// Получение данных из запроса AJAX
$filterDate = $_POST['filter_date'];

$sql = "SELECT regions.name AS region, departure_date, courier_name, arrival_date
        FROM trips
        JOIN regions ON trips.region_id = regions.id
        WHERE DATE(departure_date) = '$filterDate'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>Регион:</strong> " . $row['region'] . "</p>";
        echo "<p><strong>Дата выезда:</strong> " . $row['departure_date'] . "</p>";
        echo "<p><strong>ФИО курьера:</strong> " . $row['courier_name'] . "</p>";
        echo "<p><strong>Дата прибытия:</strong> " . $row['arrival_date'] . "</p>";
        echo "<hr>";
    }
} else {
    echo "Поездки не найдены!";
}

$conn->close();

?>
<?php
$servername = "db";
$username = "denis";
$password = "samm";
$dbname = "Denis";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Не удалось подключиться к базе данных: " . $conn->connect_error);
}


$sql = "SELECT id, travel_time FROM regions";
$result = $conn->query($sql);
$regions = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<pre>'; print_r($row['id']); echo '</pre>';
        $regions[$row['id']] = $row['travel_time'];
    }
}
// Генерация поездок за три месяца
$startDate = date('Y-m-d');
$endDate = date('Y-m-d', strtotime("+3 months"));

$currentDate = $startDate;
while ($currentDate <= $endDate) {
    foreach ($regions as $regionId => $travelTime) {
        $departureDate = $currentDate;
        $arrivalDate = date('Y-m-d', strtotime($departureDate . " + $travelTime days"));
        
        $random = function ($arr) {
            return $arr[array_rand($arr)];
        };
        $arr = array(
            'Иван Иванов',
            'Петр Петров',
            'Алексей Смирнов',
            'Елена Ковалева',
            'Мария Сидорова',
            'Сергей Попов',
            'Анна Михайлова',
            'Дмитрий Федоров',
            'Ольга Лебедева',
            'Артем Николаев');
        $courierName = $random($arr);

        $sql = "SELECT * FROM trips WHERE courier_name = '$courierName' AND departure_date	 = '$currentDate'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "У курьера уже есть поездка в этот день.";
        } else {
           
            $sql = "INSERT INTO trips (region_id, departure_date, courier_name, arrival_date)
            VALUES ('$regionId', '$departureDate', '$courierName', '$arrivalDate')";
            $conn->query($sql);
        }
        $currentDate = date('Y-m-d', strtotime($currentDate . " + 1 day"));
    }
}
$conn->close();
?>
<?php
$servername = "db";
$username = "denis";
$password = "samm";
$dbname = "Denis";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Не удалось подключиться: " . $conn->connect_error);
}


$region = $_POST['region'];
$departureDate = $_POST['departure_date'];
$courierName = $_POST['courier_name'];

$name_courier = "SELECT * FROM couers WHERE name = '$courierName'";
$result = $conn->query($name_courier);
if ($result->num_rows == 0){ echo "Курьера нет в базе данных";}else{

$sql = "SELECT * FROM trips WHERE courier_name = '$courierName' AND departure_date	 = '$departureDate'";
$result = $conn->query($sql);
if ($result->num_rows > 0){ echo "У курьера уже есть поездка в этот день.";}
else
{
    $region = $_POST['region'];
    $departureDate = $_POST['departure_date'];
    $courierName = $_POST['courier_name'];

    $sql = "SELECT travel_time FROM regions WHERE name = '$region'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $travelTime = $row['travel_time'];

        // Расчет даты прибытия в регион
        $arrivalDate = date('Y-m-d', strtotime($departureDate . " + $travelTime days"));

        // Добавление поездки в таблицу
        $sql = "INSERT INTO trips (region_id, departure_date, courier_name, arrival_date)
          VALUES ((SELECT id FROM regions WHERE name = '$region'), '$departureDate', '$courierName', '$arrivalDate')";

        if ($conn->query($sql) === TRUE) {
            echo "Поездка успешно добавлена!";
        } else {
            echo "Ошибка при добавлении поездки: " . $conn->error;
        }
    } else {
        echo "Регион не найден!";
    }
}
}

$conn->close();
echo '<a href="get_trips.html"> Информация о поездках </a>';

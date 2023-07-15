<?php
$servername = "db";
$username = "denis";
$password = "samm";
$dbname = "Denis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Не удалось подключиться: " . $conn->connect_error);
}


$courier_name = $_POST['courier_name_create'];

$sql = "SELECT * FROM couers WHERE name = '$courier_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Этот курьер уже добавлен в базу";
} else {
    $sql = "INSERT INTO couers (name) VALUES ('$courier_name')";
    $sql = "INSERT INTO couers (name) VALUES ('$courier_name')";

    if ($conn->query($sql) === TRUE) {
        echo "курьер успешно добавлена!";
    } else {
        echo "Ошибка при добавлении курьера: " . $conn->error;
    }
}

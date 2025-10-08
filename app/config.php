<?php
$servername = "db";
$username = "root";
$password = "Ftg5g5gjYRT657evTRY6GR4ZDVT";
$dbname = "Website";
$posts_per_page = 6;

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

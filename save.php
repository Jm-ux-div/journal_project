<?php
session_start();
include "db.php";

$title = $_POST['title'];
$content = $_POST['content'];
$date = $_POST['date_created'];
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO journals(title, content, data_created, user_id)
VALUES('$title', '$content', '$date', '$user_id')";

mysqli_query($conn, $sql);

header("Location: index.php");

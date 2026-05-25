<?php

session_start();

include "db.php";

$title = $_POST['title'];
$content = $_POST['content'];
$date = $_POST['date_created'];
$image = $_FILES['image']['name'];
$tmp_name = $_FILES['image']['tmp_name'];
$image_path = "uploads/" . $image;
move_uploaded_file($tmp_name, $image_path);

$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO journals(title, content, image, data_created, user_id)
VALUES('$title', '$content', '$date', '$image_path', '$user_id')";

mysqli_query($conn, $sql);

header("Location: index.php");

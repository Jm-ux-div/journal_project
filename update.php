<?php

include "db.php";

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$date = $_POST['date_created'];

$sql = "UPDATE journals
SET title='$title',
content='$content',
data_created='$date'
WHERE id=$id";

mysqli_query($conn, $sql);

header("Location: index.php");

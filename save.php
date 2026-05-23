<?php

include "db.php";

$title = $_POST['title'];
$content = $_POST['content'];
$date = $_POST['date_created'];

$sql = "INSERT INTO journals(title, content, data_created)
VALUES('$title', '$content', '$date')";

mysqli_query($conn, $sql);

header("Location: index.php");

<?php

include "db.php";

$id = $_GET['id'];
$pinned = $_GET['pinned'];

$newPinned = $pinned == 1 ? 0 : 1;

mysqli_query(
  $conn,
  "UPDATE journals SET pinned='$newPinned' WHERE id='$id'"
);

header("Location: index.php");

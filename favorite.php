<?php
include "db.php";
$id = $_GET['id'];
$current = $_GET['favorite'];

if ($current == 1) {
  $newFavorite = 0;
} else {
  $newFavorite = 1;
}
$sql = "UPDATE journals
SET favorite='$newFavorite'
WHERE id=$id";

mysqli_query($conn, $sql);
header("Location: index.php");

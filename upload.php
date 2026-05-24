<?php

session_start();

include "db.php";

if (isset($_POST['upload'])) {

  $user_id = $_SESSION['user_id'];

  $file_name = $_FILES['profile_pic']['name'];

  $tmp_name = $_FILES['profile_pic']['tmp_name'];

  $folder = "uploads/" . $file_name;

  move_uploaded_file($tmp_name, $folder);

  $sql = "UPDATE users
    SET profile_pic='$folder'
    WHERE id='$user_id'";

  mysqli_query($conn, $sql);

  header("Location: index.php");
}

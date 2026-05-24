<?php

session_start();

include 'db.php';

if (isset($_POST['login'])) {

  $username = $_POST['username'];

  $password = $_POST['password'];

  $sql = "SELECT * FROM users
    WHERE username='$username'";

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {

      $_SESSION['username'] = $username;
      $_SESSION['user_id'] = $row['id'];

      header("Location: index.php");
    } else {

      echo "Wrong Password";
    }
  } else {

    echo "User not found";
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">

    <h1>Login</h1>

    <form method="POST">

      <input type="text"
        name="username"
        placeholder="Username"
        required>

      <input type="password"
        name="password"
        placeholder="Password"
        required>

      <button type="submit" name="login">
        Login
      </button>

    </form>

  </div>

</body>

</html>
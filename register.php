<?php
include 'db.php';

if (isset($_POST['register'])) {

  $username = $_POST['username'];

  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO users(username, password)
    VALUES('$username', '$password')";

  mysqli_query($conn, $sql);

  echo "Registered Successfully!";
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">

    <h1>Register</h1>

    <form method="POST">

      <input type="text" name="username"
        placeholder="Username" required>

      <input type="password" name="password"
        placeholder="Password" required>

      <button type="submit" name="register">
        Register
      </button>

    </form>

  </div>

</body>

</html>
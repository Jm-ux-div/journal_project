<?php
include 'db.php';
?>

<!DOCTYPE html>

<html>

<head>
  <title>Journal App</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>My Daily Journal</h1>
  <form action="save.php" method="POST">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="content" placeholder="Write your journal entry here..." required></textarea>
    <input type="date" name="date_created" required>
    <button type="submit">Save Entry</button>

  </form>
  <hr>

  <h2>Journal Entries</h2>

  <?php

  $query = "SELECT * FROM journals ORDER BY data_created DESC";

  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {

    echo "<div class='card'>";
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<small>" . $row['data_created'] . "</small>";
    echo "<p>" . $row['content'] . "</p>";
    echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a> ";
    echo "<a href='delete.php?id=" . $row['id'] . "'>Delete</a>";
    echo "</div>";
  }

  ?>
</body>

</html>
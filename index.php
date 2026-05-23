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
  <div class="container">
    <h1>My Daily Journal</h1>
    <form action="save.php" method="POST">
      <input type="text" name="title" placeholder="Title" required>
      <textarea name="content" placeholder="Write your journal entry here..." required></textarea>
      <input type="date" name="date_created" required>
      <button type="submit">Save Entry</button>

    </form>
    <hr>
    <form method="GET">

      <input type="text" name="search"
        placeholder="Search journal...">

      <button type="submit">Search</button>

    </form>

    <h2>Journal Entries</h2>

    <?php

    if (isset($_GET['search'])) {

      $search = $_GET['search'];

      $query = "SELECT * FROM journals
  WHERE title LIKE '%$search%'
  OR content LIKE '%$search%'
  ORDER BY data_created DESC";
    } else {

      $query = "SELECT * FROM journals
  ORDER BY data_created DESC";
    }

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {

      echo "<div class='card'>";
      echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
      echo "<small>" . $row['data_created'] . "</small>";
      echo "<p>" . htmlspecialchars($row['content']) . "</p>";
      echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a> ";
      echo "<a href='delete.php?id=" . $row['id'] . "'
    onclick='return confirm(\"Are you sure?\")'>
    Delete</a>";
      echo "</div>";
    }

    ?>
  </div>
</body>

</html>
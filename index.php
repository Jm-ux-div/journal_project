<?php
session_start();

if (!isset($_SESSION['username'])) {

  header("Location: login.php");
  exit();
}
$user_id = $_SESSION['user_id'];
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
    <div class="top-bar">

      <?php

      $getUser = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE id='$user_id'"
      );

      $user = mysqli_fetch_assoc($getUser);

      ?>

      <?php

      if ($user['profile_pic']) {

        echo "<img src='" . $user['profile_pic'] . "'>";
      }

      ?>

      <h1>My Daily Journal</h1>

      <p>
        Welcome,
        <?php echo $_SESSION['username']; ?>!
      </p>

      <form action="upload.php"
        method="POST"
        enctype="multipart/form-data">

        <input type="file"
          name="profile_pic"
          required>

        <button type="submit"
          name="upload">

          Upload Profile

        </button>

      </form>

      <div class="button-group">

        <a href="logout.php">
          <button type="button">
            Logout
          </button>
        </a>

        <button
          onclick="toggleDarkMode()"
          type="button">

          Dark Mode

        </button>

      </div>

    </div>
    <form action="save.php"
      method="POST"
      enctype="multipart/form-data">
      <input type="text" name="title" placeholder="Title" required>
      <textarea name="content" placeholder="Write your journal entry here..." required></textarea>
      <input type="date" name="date_created" required>
      <input type="file" name="image">
      <button type="submit">Save Entry</button>

    </form>

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
WHERE user_id='$user_id'
AND (
title LIKE '%$search%'
OR content LIKE '%$search%'
)
ORDER BY data_created DESC";
    } else {

      $query = "SELECT * FROM journals
WHERE user_id='$user_id'
ORDER BY data_created DESC";
    }

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {

      echo "<div class='card'>";
      echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
      echo "<small>" . $row['data_created'] . "</small>";
      echo "<p>" . htmlspecialchars($row['content']) . "</p>";
      if ($row['image']) {

        echo "<img src='" . $row['image'] . "'
    width='100%'
    style='margin-top:10px;
    border-radius:10px;'>";
      }
      echo "<div class='card-actions'>";

      echo "<a href='edit.php?id=" . $row['id'] . "'>
✏️ Edit
</a>";

      echo "<a href='delete.php?id=" . $row['id'] . "'
onclick='return confirm(\"Are you sure?\")'>
🗑 Delete
</a>";

      echo "</div>";
      echo "</div>";
    }

    ?>
  </div>
  <script>
    function toggleDarkMode() {

      document.body.classList.toggle("dark-mode");

    }
  </script>
</body>

</html>
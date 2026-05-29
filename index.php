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
  <div id="toast"></div>
  <div class="container">
    <div class="top-bar">
      <?php

      $totalQuery = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM journals WHERE user_id='$user_id'"
      );

      $totalJournals = mysqli_fetch_assoc($totalQuery)['total'];

      $favQuery = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM journals 
    WHERE user_id='$user_id' 
    AND favorite=1"
      );

      $totalFavorites = mysqli_fetch_assoc($favQuery)['total'];

      $pinQuery = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM journals 
    WHERE user_id='$user_id' 
    AND pinned=1"
      );

      $totalPinned = mysqli_fetch_assoc($pinQuery)['total'];

      $imageQuery = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM journals 
    WHERE user_id='$user_id' 
    AND image != ''"
      );

      $totalImages = mysqli_fetch_assoc($imageQuery)['total'];

      ?>

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
    <div class="stats">

      <div class="stat-card">
        <h3>📝</h3>
        <p><?php echo $totalJournals; ?></p>
        <small>Journals</small>
      </div>

      <div class="stat-card">
        <h3>⭐</h3>
        <p><?php echo $totalFavorites; ?></p>
        <small>Favorites</small>
      </div>

      <div class="stat-card">
        <h3>📌</h3>
        <p><?php echo $totalPinned; ?></p>
        <small>Pinned</small>
      </div>

      <div class="stat-card">
        <h3>🖼</h3>
        <p><?php echo $totalImages; ?></p>
        <small>Images</small>
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
      if ($row['favorite'] == 1) {
        echo "<p>⭐ Favorite Journal</p>";
      }
      echo "<div class='card-actions'>";

      echo "<a href='edit.php?id=" . $row['id'] . "'>✏️ Edit</a>";

      echo "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>🗑 Delete</a>";

      $favoriteClass = $row['favorite'] == 1 ? "favorite-active" : "";

      echo "<a class='$favoriteClass' href='favorite.php?id="
        . $row['id'] .
        "&favorite="
        . $row['favorite'] .
        "'>";

      if ($row['favorite'] == 1) {

        echo "💔 Remove Favorite";
      } else {

        echo "❤️ Favorite";
      }

      echo "</a>";
      $pinnedClass = $row['pinned'] == 1 ? "pinned-active" : "";

      echo "<a class='$pinnedClass' href='pin.php?id="
        . $row['id'] .
        "&pinned="
        . $row['pinned'] .
        "'>";

      if ($row['pinned'] == 1) {

        echo "📌 Unpin";
      } else {

        echo "📍 Pin";
      }

      echo "</a>";
      echo "</div>";
      echo "</div>";
    }

    ?>
  </div>
  <?php
  ?>
  <script>
    // CHECK DARK MODE WHEN PAGE LOADS
    if (localStorage.getItem("darkMode") === "enabled") {
      document.body.classList.add("dark-mode");
    }

    function toggleDarkMode() {

      document.body.classList.toggle("dark-mode");

      // SAVE MODE
      if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("darkMode", "enabled");
      } else {
        localStorage.setItem("darkMode", "disabled");
      }

    }

    function showToast(message) {

      let toast = document.getElementById("toast");

      toast.innerText = message;

      toast.classList.add("show");

      setTimeout(() => {

        toast.classList.remove("show");

      }, 3000);

    }

    <?php

    if (isset($_GET['success'])) {

      if ($_GET['success'] == "saved") {

        echo "showToast('✅ Journal Saved Successfully!');";
      }
    }

    ?>
  </script>
</body>

</html>
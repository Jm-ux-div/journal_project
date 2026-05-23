<?php

include "db.php";

$id = $_GET['id'];

$query = "SELECT * FROM journals WHERE id=$id";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>
  <title>Edit Journal</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <h1>Edit Journal</h1>

  <form action="update.php" method="POST">

    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <input type="text" name="title"
      value="<?php echo $row['title']; ?>" required>

    <textarea name="content" required><?php echo $row['content']; ?></textarea>

    <input type="date" name="date_created"
      value="<?php echo $row['data_created']; ?>" required>

    <button type="submit">Update Entry</button>

  </form>

</body>

</html>
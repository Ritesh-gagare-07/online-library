<?php
session_start();
require_once "partials/_db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = (int)$_SESSION['user_id'];

$sql = "
    SELECT 
        h.`action` AS action_name,
        h.`action_date` AS action_time,
        COALESCE(b.`title`, '-') AS book_title
    FROM `history` AS h
    LEFT JOIN `books` AS b ON b.`id` = h.`book_id`
    WHERE h.`user_id` = ?
    ORDER BY h.`action_date` DESC
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('SQL Error: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$history = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Activity History</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h3>📜 Your Activity History</h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Action</th>
          <th>Book</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $history->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['action_name']) ?></td>
          <td><?= htmlspecialchars($row['book_title']) ?></td>
          <td><?= htmlspecialchars($row['action_time']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php
include "footer.php";
?>
</body>
</html>

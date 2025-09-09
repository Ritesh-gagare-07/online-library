<?php
session_start();
require_once "partials/_db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'] ?? 0;
    $message = $_POST['message'] ?? '';

   // insert into apologies (use date_submitted instead of created_at)
$stmt = $conn->prepare(
    "INSERT INTO apologies (`user_id`, `book_id`, `message`, `date_submitted`) 
     VALUES (?, ?, ?, CURDATE())"
);
if (!$stmt) {
    die("Apology query failed: " . $conn->error);
}
$stmt->bind_param("iis", $user_id, $book_id, $message);
$stmt->execute();

// insert into history (use action_date instead of created_at)
$log = $conn->prepare(
    "INSERT INTO history (`user_id`, `action`, `book_id`, `action_date`) 
     VALUES (?, 'Apology Submitted', ?, NOW())"
);
if (!$log) {
    die("History query failed: " . $conn->error);
}
$log->bind_param("ii", $user_id, $book_id);
$log->execute();


    // header("Location: dashboard.php?msg=Apology submitted successfully");
    // exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Submit Apology</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h3>🙏 Submit Apology</h3>
    <form method="POST">
      <input type="hidden" name="book_id" value="<?= htmlspecialchars($_POST['book_id'] ?? '') ?>">
      <div class="mb-3">
        <label>Reason / Apology Message</label>
        <textarea class="form-control" name="message" rows="4" required></textarea>
      </div>
      <button class="btn btn-primary">Submit</button>
    </form>
  </div>
</body>
</html>

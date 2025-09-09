<?php
session_start();
require_once "../partials/_db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_POST['book_id'])) {
    header("Location: ../dashboard.php?error=Book+ID+required");
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = intval($_POST['book_id']);

// Fetch borrow record
$stmt = $conn->prepare("
    SELECT borrow_date, fine_paid 
    FROM borrowings 
    WHERE user_id = ? AND book_id = ?
");
$stmt->bind_param("ii", $user_id, $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../dashboard.php?error=No+borrow+record+found");
    exit;
}

$row = $result->fetch_assoc();
$borrowDate = new DateTime($row['borrow_date']);
$today = new DateTime();
$days = $today->diff($borrowDate)->days;

// Fine calculation
if ($days > 3 && !$row['fine_paid']) {
    $fine = ($days - 3) * 10;
    header("Location: ../dashboard.php?error=You+must+pay+₹$fine+fine+before+returning");
    exit;
}

// No fine or fine already paid → delete borrow record
$stmt = $conn->prepare("DELETE FROM borrowings WHERE user_id = ? AND book_id = ?");
$stmt->bind_param("ii", $user_id, $book_id);

if ($stmt->execute()) {
    header("Location: ../dashboard.php?success=Book+returned+successfully");
} else {
    header("Location: ../dashboard.php?error=Failed+to+return+book");
}
exit;

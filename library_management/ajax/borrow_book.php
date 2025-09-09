<?php
session_start();
require_once '../partials/_db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

if (!isset($_POST['book_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Book ID missing"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = intval($_POST['book_id']);
$borrow_date = date('Y-m-d');

// Check if already borrowed
$stmt = $conn->prepare("SELECT id FROM borrowings WHERE user_id = ? AND book_id = ?");
$stmt->bind_param("ii", $user_id, $book_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["message" => "You already borrowed this book"]);
    exit;
}

// Insert borrow record
$stmt = $conn->prepare("INSERT INTO borrowings (user_id, book_id, borrow_date) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $book_id, $borrow_date);

if ($stmt->execute()) {
    header("Location: ../dashboard.php?success=Book+borrowed+successfully");
} else {
    header("Location: ../dashboard.php?error=Failed+to+borrow+book");
}

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
    echo json_encode(["error" => "Book ID required"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = intval($_POST['book_id']);

$stmt = $conn->prepare("
    UPDATE borrowings SET fine_paid = 1 WHERE user_id = ? AND book_id = ?
");
$stmt->bind_param("ii", $user_id, $book_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Fine marked as paid. You can now return the book."]);
} else {
    echo json_encode(["error" => "Failed to update fine status."]);
}
?>

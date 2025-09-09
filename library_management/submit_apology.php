<?php
session_start();
require_once '../partials/_db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

if (!isset($_POST['book_id']) || !isset($_POST['message'])) {
    http_response_code(400);
    echo json_encode(["error" => "Book ID and message required"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = intval($_POST['book_id']);
$message = trim($_POST['message']);

$stmt = $conn->prepare("INSERT INTO apologies (user_id, book_id, message, date_submitted) VALUES (?, ?, ?, CURDATE())");
$stmt->bind_param("iis", $user_id, $book_id, $message);

if ($stmt->execute()) {
    echo json_encode(["message" => "Apology submitted. Admin will review it."]);
} else {
    echo json_encode(["error" => "Failed to submit apology."]);
}
?>

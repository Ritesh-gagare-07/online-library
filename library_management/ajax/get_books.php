<?php
session_start();
require_once '../partials/_db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

if (!isset($_GET['category_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Category ID is required"]);
    exit;
}

$category_id = intval($_GET['category_id']);

$stmt = $conn->prepare("SELECT id, title, author, url FROM books WHERE category_id = ?");
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

header('Content-Type: application/json');
echo json_encode($books);
?>

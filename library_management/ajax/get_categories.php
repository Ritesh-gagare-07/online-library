<?php
session_start();
require_once '../partials/_db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM categories");
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

header('Content-Type: application/json');
echo json_encode($categories);
?>

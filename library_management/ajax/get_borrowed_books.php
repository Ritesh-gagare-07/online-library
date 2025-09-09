<?php
session_start();
require_once '../partials/_db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT b.id, b.title, b.author, b.url, bb.borrow_date
    FROM borrowings bb
    JOIN books b ON bb.book_id = b.id
    WHERE bb.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$borrowed_books = [];
$today = new DateTime();

while ($row = $result->fetch_assoc()) {
    $borrowDate = new DateTime($row['borrow_date']);
    $interval = $today->diff($borrowDate);
    $days = $interval->days;
    $fine = ($days > 3) ? ($days - 3) * 10 : 0;

    $row['fine'] = $fine;
    $row['days_borrowed'] = $days;
    $borrowed_books[] = $row;
}

header('Content-Type: application/json');
echo json_encode($borrowed_books);
?>

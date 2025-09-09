<?php
session_start();
require('../partials/_db.php');
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) exit;

$book_id = intval($_POST['book_id']);
$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
if ($stmt->execute()) {
    echo json_encode(['status'=>'success','message'=>'Book deleted.']);
} else {
    echo json_encode(['status'=>'error','message'=>'Delete failed.']);
}

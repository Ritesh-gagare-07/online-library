<?php
session_start();
require('../partials/_db.php');
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) exit;

$cat_id = intval($_POST['cat_id']);
$title = trim($_POST['title']);
$author = trim($_POST['author']);

if ($cat_id==0 || !$title || !$author) {
    echo json_encode(['status'=>'error','message'=>'All fields are required.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO books (category_id, title, author) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $cat_id, $title, $author);
if ($stmt->execute()) {
    echo json_encode(['status'=>'success','message'=>'Book added.']);
} else {
    echo json_encode(['status'=>'error','message'=>'Add failed.']);
}

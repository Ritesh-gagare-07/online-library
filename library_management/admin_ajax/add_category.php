<?php
session_start();
require('../partials/_db.php');
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) exit;

$name = trim($_POST['name']);
if ($name == '') {
    echo json_encode(['status'=>'error','message'=>'Category name is required.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
$stmt->bind_param("s", $name);
if ($stmt->execute()) {
    echo json_encode(['status'=>'success','message'=>'Category added.']);
} else {
    echo json_encode(['status'=>'error','message'=>'Add failed.']);
}

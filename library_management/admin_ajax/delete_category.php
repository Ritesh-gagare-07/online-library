<?php
session_start();
require('../partials/_db.php');
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) exit;

$cat_id = intval($_POST['cat_id']);

$conn->begin_transaction();

$conn->prepare("DELETE FROM books WHERE category_id = ?")
    ->bind_param("i", $cat_id);
$conn->prepare("DELETE FROM categories WHERE id = ?")
    ->bind_param("i", $cat_id)->execute();

$conn->commit();

echo json_encode(['status'=>'success','message'=>'Category deleted.']);

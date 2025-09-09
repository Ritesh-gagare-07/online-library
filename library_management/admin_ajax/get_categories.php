<?php
session_start();
require('../partials/_db.php');
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) exit;

$sql = "SELECT id, name FROM categories";
$res = $conn->query($sql);
$cats = [];
while ($c = $res->fetch_assoc()) {
    $cat = ['id'=>$c['id'], 'name'=>$c['name'], 'books'=>[]];
    $stmt = $conn->prepare("SELECT id, title, author FROM books WHERE category_id = ?");
    $stmt->bind_param("i", $c['id']);
    $stmt->execute();
    $bRes = $stmt->get_result();
    while ($b = $bRes->fetch_assoc()) $cat['books'][] = $b;
    $cats[] = $cat;
}
echo json_encode($cats);

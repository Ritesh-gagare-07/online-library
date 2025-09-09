<?php
session_start();
require_once 'partials/_db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Borrowed books
$borrowed = $conn->query("SELECT b.title, b.author, br.borrow_date, br.fine_paid
                          FROM borrowings br
                          JOIN books b ON br.book_id = b.id
                          WHERE br.user_id = $user_id AND br.return_date IS NULL");

// Returned books
$returned = $conn->query("SELECT b.title, b.author, br.return_date
                          FROM borrowings br
                          JOIN books b ON br.book_id = b.id
                          WHERE br.user_id = $user_id AND br.return_date IS NOT NULL");

// Fines
$fines = $conn->query("SELECT SUM((DATEDIFF(CURDATE(), borrow_date) - 3) * 10) AS total_fine 
                       FROM borrowings WHERE user_id = $user_id AND fine_paid = 0")->fetch_assoc()['total_fine'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f6fa; margin: 0; padding: 0; }
        .profile-container { max-width: 900px; margin: 30px auto; padding: 20px; background: white; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { color: #004d40; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #1b2a49; color: white; }
        .summary { display: flex; justify-content: space-between; padding: 15px; background: #004d40; color: white; border-radius: 10px; margin-bottom: 20px; }
        .summary div { text-align: center; }
        .btn { background: #1b2a49; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #004d40; }
    </style>
</head>
<body>
    
    <div class="profile-container">
        <h2><i class="fa fa-user"></i> Your Profile</h2>
        
        <div class="summary">
            <div><i class="fa fa-book"></i><br>Borrowed Books: <?= $borrowed->num_rows ?></div>
            <div><i class="fa fa-check"></i><br>Returned Books: <?= $returned->num_rows ?></div>
            <div><i class="fa fa-money-bill"></i><br>Total Fine: ₹<?= $fines ?></div>
        </div>

        <h2>Borrowed Books</h2>
        <table>
            <tr><th>Title</th><th>Author</th><th>Borrow Date</th><th>Status</th></tr>
            <?php while($row = $borrowed->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['author'] ?></td>
                    <td><?= $row['borrow_date'] ?></td>
                    <td><?= $row['fine_paid'] ? "Fine Paid" : "Pending" ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h2>Returned Books</h2>
        <table>
            <tr><th>Title</th><th>Author</th><th>Return Date</th></tr>
            <?php while($row = $returned->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['author'] ?></td>
                    <td><?= $row['return_date'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div> 
   
</body>
</html>

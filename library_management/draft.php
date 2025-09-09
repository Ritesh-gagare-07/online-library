<?php
session_start();
require_once "partials/_db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT name FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$username = $user['name'] ?? "User";

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");

// Fetch borrowed books
$stmt = $conn->prepare("
    SELECT b.id, b.title, b.author, b.url, bb.borrow_date, bb.fine_paid
    FROM borrowings bb
    JOIN books b ON bb.book_id = b.id
    WHERE bb.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$borrowed = $stmt->get_result();

$today = new DateTime();
$borrowed_books = [];
$total_fine = 0;

while ($row = $borrowed->fetch_assoc()) {
    $borrowDate = new DateTime($row['borrow_date']);
    $days = $today->diff($borrowDate)->days;
    $fine = ($days > 3) ? ($days - 3) * 10 : 0;
    if (!$row['fine_paid']) {
        $total_fine += $fine;
    }
    $row['days'] = $days;
    $row['fine'] = $fine;
    $borrowed_books[] = $row;
}
 ?>
<DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f4f8fb; font-family: 'Segoe UI', sans-serif; }
    .sidebar { height: auto; background: #004d40; color: white; padding: 20px; }
    .sidebar h2 { font-size: 1.5rem; margin-bottom: 20px; }
    .nav-link { color: white !important; font-weight: 500; }
    .nav-link:hover { background: #1b2a49; border-radius: 8px; }
    .card { border-radius: 15px; transition: transform 0.2s ease-in-out; }
    .card:hover { transform: scale(1.02); }
    .book-img { height: 180px; object-fit: cover; }
    .fine { color: red; font-weight: bold; }
    .success { color: green; font-weight: bold; }
    .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .profile-dropdown { position: relative; display: inline-block; }
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background: white;
        min-width: 250px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        padding: 15px;
        z-index: 10;
    }
    .dropdown-content p { margin: 0; padding: 5px 0; }
    .profile-dropdown:hover .dropdown-content { display: block; }
  </style>
</head>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).on("click", ".view-books", function(){
    let catId = $(this).data("id");
    $("#books").show();
    $("#book-list").html("<p>Loading books...</p>");

    $.get("fetch_books.php", { cat: catId }, function(data){
        $("#book-list").html(data);
    });
});
</script>

<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar">
      <h2>📚 Library</h2>
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="#categories">📖 Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="#borrowed">📂 Borrowed Books</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">🚪 Logout</a></li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 p-4">
      <?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
<?php elseif (isset($_GET['error'])): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

      <!-- Topbar -->
      <div class="topbar">
        <h3>👋 Welcome, <?= htmlspecialchars($username) ?>!</h3>
        <div class="profile-dropdown">
          <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
               alt="Profile" width="40" style="cursor:pointer;border-radius:50%;">
          <div class="dropdown-content">
            <h5>👤 <?= htmlspecialchars($username) ?></h5>
            <p><strong>Total Borrowed:</strong> <?= count($borrowed_books) ?></p>
            <p><strong>Total Fine:</strong> ₹<?= $total_fine ?></p>
            <a href="history.php" class="btn btn-primary w-100 mt-2">📜 View Activity</a>
          </div>
        </div>
      </div>

    <!-- Categories Section -->
<section id="categories">
  <h3>📖 Categories</h3>
  <div class="row">
    <?php while ($cat = $categories->fetch_assoc()): ?>
      <div class="col-md-3 mb-3">
        <div class="card shadow text-center">
          <div class="card-body">
            <h5><?= htmlspecialchars($cat['name']) ?></h5>
            <button class="btn btn-success mt-2 view-books" data-id="<?= $cat['id'] ?>">View Books</button>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Books Section (dynamic) -->
<section id="books" class="mt-5" style="display:none;">
  <h3>📚 Books</h3>
  <div class="row" id="book-list"></div>
</section>


      <!-- Borrowed Books -->
      <section id="borrowed" class="mt-5">
        <h3>📂 Your Borrowed Books</h3>
        <div class="row">
          <?php if (count($borrowed_books) > 0): ?>
            <?php foreach ($borrowed_books as $book): ?>
              <div class="col-md-4 mb-3">
                <div class="card shadow">
                  <img src="img/poetry-book-cover-idea-7.webp" class="card-img-top book-img" alt="<?= htmlspecialchars($book['title']) ?>">
                  <div class="card-body">
                    <h5><?= htmlspecialchars($book['title']) ?></h5>
                    <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
                    <p>Borrowed for <strong><?= $book['days'] ?> days</strong></p>
                    <?php if ($book['fine'] > 0 && !$book['fine_paid']): ?>
                      <p class="fine">Fine: ₹<?= $book['fine'] ?></p>
                      <form action="actions/pay_fine.php" method="POST" class="d-inline">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                        <button class="btn btn-warning btn-sm">💰 Pay Fine</button>
                      </form>
                      <form action="apology_form.php" method="POST" class="d-inline">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                        <button class="btn btn-secondary btn-sm">🙏 Submit Apology</button>
                      </form>
                    <?php else: ?>
                      <p class="success">No fine</p>
                    <?php endif; ?>
                    <form action="ajax/return_book.php" method="POST" class="mt-2">
                       <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                      <button class="btn btn-danger btn-sm">📤 Return Book</button>
                     </form>

                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No borrowed books yet.</p>
          <?php endif; ?>
        </div>
      </section>
    </div>
  </div>
</div>
</body>
</html>

<?php
require_once "partials/_db.php";

$cat_id = intval($_GET['cat'] ?? 0);

if ($cat_id > 0) {
    $stmt = $conn->prepare("SELECT id, title, author, url FROM books WHERE category_id=?");
    $stmt->bind_param("i", $cat_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($book = $result->fetch_assoc()) {
        ?>
        <div class="col-md-3 mb-3">
          <div class="card shadow">
            <img src="img/poetry-book-cover-idea-7.webp" class="card-img-top book-img" alt="<?= htmlspecialchars($book['title']) ?>">
            <div class="card-body">
              <h5><?= htmlspecialchars($book['title']) ?></h5>
              <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
              <form action="ajax/borrow_book.php" method="POST">
                <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                <button class="btn btn-primary btn-sm">📚 Borrow</button>
              </form>
            </div>
          </div>
        </div>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .footer {
  background: #004d40;
}
.footer-link {
  color: #ffffff;
  text-decoration: none;
}
.footer-link:hover {
  color: #fdd835; /* yellow highlight on hover */
  text-decoration: underline;
}
.social-link {
  font-size: 1.2rem;
  color: white;
  text-decoration: none;
}
.social-link:hover {
  color: #fdd835;
}

    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Footer -->
<footer class="footer mt-auto py-3 text-white">
  <div class="container text-center">
    <div class="row">
      <!-- Left -->
      <div class="col-md-4 mb-3 mb-md-0">
        <h5 class="fw-bold">📚 My Library</h5>
        <p class="small">Your gateway to knowledge, anytime, anywhere.</p>
      </div>
      
      <!-- Middle -->
      <div class="col-md-4 mb-3 mb-md-0">
        <h6 class="fw-bold">Quick Links</h6>
        <ul class="list-unstyled small">
          <li><a href="dashboard.php" class="footer-link">Dashboard</a></li>
          <li><a href="history.php" class="footer-link">History</a></li>
          <li><a href="index.php" class="footer-link">Logout</a></li>
        </ul>
      </div>
      
      <!-- Right -->
      <div class="col-md-4">
        <h6 class="fw-bold">Connect</h6>
        <a href="#" class="social-link me-3">🌐</a>
        <a href="#" class="social-link me-3">📧</a>
        <a href="#" class="social-link">📞</a>
      </div>
    </div>
    <hr class="bg-light my-3">
    <p class="small mb-0">&copy; <?= date("Y") ?> My Library. All rights reserved.</p>
  </div>
</footer>

</body>
</html>
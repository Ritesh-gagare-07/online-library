<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Our Online Library</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9f9f9;
    }
    .hero {
      background: linear-gradient(rgba(0,77,64,0.85), rgba(0,77,64,0.85)), url('https://source.unsplash.com/1600x600/?library,books') center/cover no-repeat;
      color: white;
      text-align: center;
      padding: 100px 20px;
      animation: fadeIn 2s ease-in;
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
      animation: slideInDown 1.5s ease-out;
    }
    .hero p {
      font-size: 1.25rem;
      margin-top: 15px;
      animation: slideInUp 2s ease-out;
    }
    .btn-custom {
      background-color: #fbc02d;
      color: #004d40;
      font-weight: bold;
      border-radius: 25px;
      padding: 12px 30px;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background-color: #e53935;
      color: #fff;
      transform: scale(1.05);
    }
    .feature-card {
      transition: transform 0.4s, box-shadow 0.4s;
    }
    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0px 8px 20px rgba(0,0,0,0.2);
    }
    .goals-section {
      background-color: #004d40;
      color: white;
      padding: 60px 20px;
      border-radius: 15px;
      margin-top: 40px;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes slideInDown {
      from { transform: translateY(-50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
    @keyframes slideInUp {
      from { transform: translateY(50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  </style>
</head>
<body>

  <!-- Hero Section -->
  <section class="hero">
    <h1>📚 Welcome to My Library</h1>
    <p>Your free online library — borrow books, read, return, or apologize, all made easy!</p>
    <a href="register.php" class="btn btn-custom mt-3">Get Started</a>
  </section>

  <!-- Features Section -->
  <section class="container my-5">
    <h2 class="text-center mb-4" style="color:#004d40;">✨ Our Features</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card feature-card h-100 text-center p-3">
          <i class="bi bi-book-half fs-1 text-success"></i>
          <h5 class="mt-3">Borrow Books</h5>
          <p>Borrow any book for <b>3 days free</b>. Explore knowledge with ease.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card feature-card h-100 text-center p-3">
          <i class="bi bi-cash-coin fs-1 text-danger"></i>
          <h5 class="mt-3">Late Fine</h5>
          <p>After 3 days, pay a fine of <b>₹10 per day</b> for overdue books.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card feature-card h-100 text-center p-3">
          <i class="bi bi-emoji-smile fs-1 text-warning"></i>
          <h5 class="mt-3">Apologize Option</h5>
          <p>Don’t want to pay fine? Submit an apology and continue learning.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card feature-card h-100 text-center p-3">
          <i class="bi bi-arrow-return-left fs-1 text-primary"></i>
          <h5 class="mt-3">Return Books</h5>
          <p>Once done, return books easily with a single click.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card feature-card h-100 text-center p-3">
          <i class="bi bi-grid-1x2 fs-1 text-secondary"></i>
          <h5 class="mt-3">Book Categories</h5>
          <p>Find books across <b>multiple categories</b> — fiction, education, health, poetry, and more!</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Goals Section -->
  <section class="goals-section container text-center">
    <h2>🎯 Our Goals</h2>
    <p class="mt-3">Our mission is to make reading accessible and engaging for everyone.  
    By offering free borrowing, flexible return options, and a wide range of categories,  
    we aim to foster a culture of knowledge, creativity, and lifelong learning.</p>
  </section>

  <footer class="text-center mt-5 mb-3">
    <p>&copy; 2025 My Library | Made with ❤️ for readers</p>
  </footer>

</body>
</html>

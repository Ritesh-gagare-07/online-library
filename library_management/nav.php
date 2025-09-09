<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 <style>
        .site-navbar {
    background: linear-gradient(45deg, #007bff, #fc5c65, #28a745);
    background-size: 300% 300%;
    animation: gradientBG 8s ease infinite;
    padding: 15px 30px;
    color: white;
    font-family: Arial, sans-serif;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    position: relative;
    top: 0;
    z-index: 999;
      border-radius:10px;
    margin-left:20px;
    margin-right:20px;
    margin-top:20px;
}

.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
  
}

.logo a {
    color: white;
    font-size: 1.8em;
    font-weight: bold;
    text-decoration: none;
    transition: transform 0.3s;
}

.logo a:hover {
    transform: scale(1.1);
}

.nav-links {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.nav-links li {
    margin: 0 15px;
}

.nav-links a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s, transform 0.3s;
}

.nav-links a:hover {
    transform: scale(1.1);
    text-shadow: 0 0 5px rgba(255,255,255,0.8);
}

.menu-toggle {
    display: none;
    font-size: 1.8em;
    cursor: pointer;
}

/* Responsive Navbar */
@media (max-width: 768px) {
    .nav-links {
        display: none;
        flex-direction: column;
        width: 100%;
        background: rgba(0,0,0,0.8);
        position: absolute;
        top: 60px;
        left: 0;
    }

    .nav-links li {
        margin: 10px 0;
        text-align: center;
    }

    .menu-toggle {
        display: block;
    }

    .nav-links.active {
        display: flex;
    }
}

    </style>
</head>
<body>
    <?php require_once 'partials/_db.php'; ?>
    <nav class="site-navbar">
    <div class="navbar-container">
        <div class="logo">
            <a href="#">📚 MyLibrary</a>
        </div>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a class="categories-section h2" href="#">Categories</a></li>
            <li><a href="#">My Books</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
        <div class="menu-toggle" id="mobile-menu">
            ☰
        </div>
    </div>
</nav>

<script src="js/main.js"></script>
</body>
</html>
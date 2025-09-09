<?php
include 'partials/_db.php';
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $name, $hashed);
    if ($stmt->fetch() && password_verify($password, $hashed)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Library</title>
    <link rel="stylesheet" href="css/auth.css">
    <style>
        body{
            background-color: #004d40;
        }
         p a{
            color:#f6f8fc;
        }
    </style>
</head>
<body>
    <div class="auth-container fade-in">
        <h2>🔐 Login</h2>
        <?php if ($error): ?>
            <div class="alert"><?= $error ?></div>
        <?php elseif (isset($_GET['registered'])): ?>
            <div class="alert success">Registered successfully! Please login.</div>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>
</body>
</html>

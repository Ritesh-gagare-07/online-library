<?php
require_once 'partials/_db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Email is already registered.";
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $name, $email, $hashed);
            $insert->execute();

            header("Location: login.php?registered=true");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Library</title>
    <link rel="stylesheet" href="css/auth.css">
    <style>
        body{
            background:#004d40;
        }
        p a {
            color:#f6f8fc;
        }
    </style>
</head>
<body>
    <div class="auth-container fade-in">
        <h2>📖 Register</h2>
        <?php if ($errors): ?>
            <div class="alert">
                <?= implode('<br>', $errors) ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required />
            <input type="email" name="email" placeholder="Email Address" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Register</button>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>

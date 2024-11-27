<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '1234', 'grievance_portal');
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: post_grievance.php');
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with this email!";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST">
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
        <div class="already-account">
                Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</body>
</html>

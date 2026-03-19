<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; 
    
    // Create Bcrypt Hash (Lab Requirement)
    $hash = password_hash($password, PASSWORD_BCRYPT); 
    
    $sql = "INSERT INTO employee_logins (username, password_hash, department) VALUES ('$username', '$hash', 'IT Dept')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Account created! You can now log in.'); window.location.href='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Developer Portal - Register</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #218838; }
        a { color: #0056b3; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Create Account</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Choose a Username" required>
            <input type="password" name="password" placeholder="Choose a Password" required>
            <button type="submit" name="register">Register (Bcrypt)</button>
        </form>
        <br>
        <a href="index.php">Back to Login</a>
    </div>
</body>
</html>
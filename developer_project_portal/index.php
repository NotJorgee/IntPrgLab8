<?php
session_start();
require 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Find the user in the database
    $sql = "SELECT * FROM employee_logins WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the Bcrypt password
        if (password_verify($password, $user['password_hash'])) {
            // 1. Set Session Variables
            $_SESSION['emp_id'] = $user['emp_id'];
            $_SESSION['username'] = $user['username'];

            // 2. Automatically generate the MD5 Log Session (Lab Requirement)
            $emp_id = $user['emp_id'];
            $time = date('Y-m-d H:i:s');
            $raw_string = "LOGIN-EMP" . $emp_id . "-" . $time;
            $hash = md5($raw_string);
            
            $log_sql = "INSERT INTO work_session_logs (emp_id, login_time, raw_token_string, session_token_md5) VALUES ('$emp_id', '$time', '$raw_string', '$hash')";
            $conn->query($log_sql);

            // 3. Redirect to Dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Developer Portal - Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #0056b3; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #004494; }
        .error { color: red; margin-bottom: 10px; }
        a { color: #28a745; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Developer Login</h2>
        <?php if($error) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Sign In</button>
        </form>
        <br>
        <p>No account? <a href="register.php">Create Account</a></p>
        <hr>
        <a href="view_encrypted.php" style="color: #666;">View Lab Hashes</a>
    </div>
</body>
</html>
<?php
require 'db.php';

// Process Form Submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Add Employee (Bcrypt)
    if (isset($_POST['add_employee'])) {
        $user = $_POST['username'];
        $pass = $_POST['password']; // Unencrypted
        $hash = password_hash($pass, PASSWORD_BCRYPT); // Bcrypt Encryption
        
        $sql = "INSERT INTO employee_logins (username, password_hash, department) VALUES ('$user', '$hash', 'IT Support')";
        $conn->query($sql);
    }
    
    // 2. Add System Update (SHA1)
    if (isset($_POST['add_system'])) {
        $emp_id = $_POST['emp_id'];
        $sys_name = $_POST['system_name'];
        $note = $_POST['update_note']; // Unencrypted
        $hash = sha1($note); // SHA1 Encryption
        
        $sql = "INSERT INTO active_systems (emp_id, system_name, update_note, latest_update_hash) VALUES ('$emp_id', '$sys_name', '$note', '$hash')";
        $conn->query($sql);
    }
    
    // 3. Log Session (MD5)
    if (isset($_POST['log_session'])) {
        $emp_id = $_POST['emp_id'];
        $sys_id = $_POST['system_id'];
        $time = date('Y-m-d H:i:s');
        
        $raw_string = "EMP" . $emp_id . "-" . $time; // Unencrypted string
        $hash = md5($raw_string); // MD5 Encryption
        
        $sql = "INSERT INTO work_session_logs (emp_id, system_id, login_time, raw_token_string, session_token_md5) VALUES ('$emp_id', '$sys_id', '$time', '$raw_string', '$hash')";
        $conn->query($sql);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Developer Portal - Data Entry</title>
    <style> 
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f7f6; } 
        
        /* New Flexbox container to hold the forms horizontally */
        .forms-wrapper {
            display: flex;
            gap: 25px; /* Adds space between the forms */
            align-items: flex-start; /* Keeps them aligned at the top */
            flex-wrap: wrap; /* Allows them to stack on smaller screens */
            margin-top: 20px;
        }

        .form-box { 
            background: white; 
            border: 1px solid #ccc; 
            padding: 20px; 
            width: 320px; /* Adjusted width for horizontal layout */
            border-radius: 5px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            box-sizing: border-box;
        } 
        
        .nav-links a { margin-right: 15px; text-decoration: none; color: #0056b3; font-weight: bold; }
        .nav-links a:hover { text-decoration: underline; }
        
        input[type="text"], input[type="password"], input[type="number"] { width: 100%; padding: 10px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;}
        
        button { padding: 10px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold; margin-top: 10px;}
        button:hover { background-color: #218838; }
        
        h3 { margin-top: 0; color: #333; }
    </style>
</head>
<body>
    <h2>Developer Project Portal - Management</h2>
    
    <div class="nav-links">
        <a href="view_decrypted.php">🔓 View Decrypted Data (Raw)</a>
        <a href="view_encrypted.php">🔒 View Encrypted Data (Hashes)</a>
    </div>
    <hr>

    <div class="forms-wrapper">
        
        <div class="form-box">
            <h3>1. Create Account (Bcrypt)</h3>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required><br><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit" name="add_employee">Save Employee</button>
            </form>
        </div>

        <div class="form-box">
            <h3>2. System Update (SHA1)</h3>
            <form method="POST">
                <input type="number" name="emp_id" placeholder="Employee ID" required><br><br>
                <input type="text" name="system_name" placeholder="System Name" required><br><br>
                <input type="text" name="update_note" placeholder="Update Note (e.g., Fixed bug)" required><br>
                <button type="submit" name="add_system">Save Update</button>
            </form>
        </div>

        <div class="form-box">
            <h3>3. Log Session (MD5)</h3>
            <form method="POST">
                <input type="number" name="emp_id" placeholder="Employee ID" required><br><br>
                <input type="number" name="system_id" placeholder="System ID" required><br><br>
                <button type="submit" name="log_session">Generate MD5 Session</button>
            </form>
        </div>

    </div> 
    </body>
</html>
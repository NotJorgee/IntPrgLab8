<?php
session_start();
require 'db.php';

// Protect the page: If not logged in, redirect to login page
if (!isset($_SESSION['emp_id'])) {
    header("Location: index.php");
    exit();
}

$current_user_id = $_SESSION['emp_id'];
$current_username = $_SESSION['username'];

// Process SHA1 System Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_system'])) {
    $sys_name = $_POST['system_name'];
    $note = $_POST['update_note']; 
    
    // Create SHA1 Hash (Lab Requirement)
    $hash = sha1($note); 
    
    $sql = "INSERT INTO active_systems (emp_id, system_name, update_note, latest_update_hash) VALUES ('$current_user_id', '$sys_name', '$note', '$hash')";
    $conn->query($sql);
    $success_msg = "Update successfully saved and hashed!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style> 
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f7f6; } 
        .header { display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 15px 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 5px; margin-bottom: 20px;}
        .form-box { background: white; border: 1px solid #ccc; padding: 20px; width: 400px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); } 
        input[type="text"] { width: 100%; padding: 10px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px;}
        button { padding: 10px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold; }
        .logout-btn { background-color: #d9534f; width: auto; }
        .nav-links a { margin-right: 15px; text-decoration: none; color: #0056b3; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($current_username); ?>!</h2>
        <a href="logout.php"><button class="logout-btn">Log Out</button></a>
    </div>

    <div class="nav-links">
        <a href="view_decrypted.php">🔓 View Decrypted Data</a>
        <a href="view_encrypted.php">🔒 View Encrypted Data</a>
    </div>
    <hr>

    <?php if(isset($success_msg)) echo "<p style='color: green;'><b>$success_msg</b></p>"; ?>

    <div class="form-box">
        <h3>Submit System Update (SHA1)</h3>
        <form method="POST">
            <label>System Name</label>
            <input type="text" name="system_name" placeholder="e.g., EVSU Portal" required>
            
            <label>Update Note</label>
            <input type="text" name="update_note" placeholder="e.g., Fixed CSS bug" required>
            
            <button type="submit" name="add_system">Save Update</button>
        </form>
    </div>

</body>
</html>
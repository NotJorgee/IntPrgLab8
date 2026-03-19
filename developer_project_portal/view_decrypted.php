<?php require 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Decrypted Data View</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f7f6; }
        .nav-links a { margin-right: 15px; text-decoration: none; color: #0056b3; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; max-width: 800px; margin-bottom: 30px; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #5cb85c; color: white; } /* Green theme for unencrypted */
        .data-cell { font-family: Arial, sans-serif; font-weight: bold; color: #333; }
    </style>
</head>
<body>
    <h2>🔓 Decrypted Data View (Raw Strings)</h2>
    <div class="nav-links">
        <a href="index.php">⬅ Back to Data Entry</a>
        <a href="view_encrypted.php">Switch to Encrypted View ➡</a>
    </div>
    <hr>

    <h3>Table 1: Work Sessions (Source of MD5)</h3>
    <table>
        <tr><th style="width: 20%;">Session ID</th><th>Unencrypted Data (Raw Token)</th></tr>
        <?php
        $res = $conn->query("SELECT session_id, raw_token_string FROM work_session_logs");
        while($row = $res->fetch_assoc()) echo "<tr><td>{$row['session_id']}</td><td class='data-cell'>{$row['raw_token_string']}</td></tr>";
        ?>
    </table>

    <h3>Table 2: Employee Logins (Source of Bcrypt)</h3>
    <table>
        <tr><th style="width: 20%;">Emp ID</th><th>Unencrypted Data (Username)</th></tr>
        <?php
        $res = $conn->query("SELECT emp_id, username FROM employee_logins");
        while($row = $res->fetch_assoc()) echo "<tr><td>{$row['emp_id']}</td><td class='data-cell'>{$row['username']}</td></tr>";
        ?>
    </table>

    <h3>Table 3: Active Systems (Source of SHA1)</h3>
    <table>
        <tr><th style="width: 20%;">System ID</th><th>Unencrypted Data (Update Note)</th></tr>
        <?php
        $res = $conn->query("SELECT system_id, update_note FROM active_systems");
        while($row = $res->fetch_assoc()) echo "<tr><td>{$row['system_id']}</td><td class='data-cell'>{$row['update_note']}</td></tr>";
        ?>
    </table>
</body>
</html>
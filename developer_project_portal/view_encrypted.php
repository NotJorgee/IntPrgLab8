<?php require 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Encrypted Data View</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f7f6; }
        .nav-links a { margin-right: 15px; text-decoration: none; color: #0056b3; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; max-width: 800px; margin-bottom: 30px; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #d9534f; color: white; } /* Red theme for encrypted */
        .data-cell { font-family: monospace; color: #d9534f; font-size: 14px; }
    </style>
</head>
<body>
    <h2>🔒 Encrypted Data View (Hashes)</h2>
    <div class="nav-links">
        <a href="index.php">⬅ Back to Data Entry</a>
        <a href="view_decrypted.php">Switch to Decrypted View ➡</a>
    </div>
    <hr>

    <h3>Table 1: Work Sessions (MD5)</h3>
    <table>
        <tr><th style="width: 20%;">Session ID</th><th>Encrypted Data (MD5 Token)</th></tr>
        <?php
        $res = $conn->query("SELECT session_id, session_token_md5 FROM work_session_logs");
        while($row = $res->fetch_assoc()) echo "<tr><td>{$row['session_id']}</td><td class='data-cell'>{$row['session_token_md5']}</td></tr>";
        ?>
    </table>

    <h3>Table 2: Employee Logins (Bcrypt)</h3>
    <table>
        <tr><th style="width: 20%;">Emp ID</th><th>Encrypted Data (Bcrypt Hash)</th></tr>
        <?php
        $res = $conn->query("SELECT emp_id, password_hash FROM employee_logins");
        while($row = $res->fetch_assoc()) echo "<tr><td>{$row['emp_id']}</td><td class='data-cell'>{$row['password_hash']}</td></tr>";
        ?>
    </table>

    <h3>Table 3: Active Systems (SHA1)</h3>
    <table>
        <tr><th style="width: 20%;">System ID</th><th>Encrypted Data (SHA1 Signature)</th></tr>
        <?php
        $res = $conn->query("SELECT system_id, latest_update_hash FROM active_systems");
        while($row = $res->fetch_assoc()) echo "<tr><td>{$row['system_id']}</td><td class='data-cell'>{$row['latest_update_hash']}</td></tr>";
        ?>
    </table>
</body>
</html>
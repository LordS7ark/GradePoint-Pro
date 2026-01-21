<?php
// 1. Always start session and include config at the VERY top
require_once('../secure_pass/db_config.php');
session_start();

// 2. Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../secure_pass/login.php");
    exit();
}

// 3. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $reg = mysqli_real_escape_string($conn, $_POST['reg_number']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);

    $sql = "INSERT INTO students (full_name, reg_number, class) VALUES ('$name', '$reg', '$class')";
    
    if ($conn->query($sql)) {
        // LOG THIS ACTION in our new system log!
        logActivity($conn, $_SESSION['username'], "Registered new student: $name", "GRADING");
        
        header("Location: index.php");
        exit();
    } else {
        $error_msg = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Student | GradePoint Pro</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; margin: 0; }
        .navbar { background: #1a1d2b; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #a855f7; }
        .form-container { display: flex; justify-content: center; align-items: center; height: 80vh; }
        .form-card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { color: #6f42c1; margin-top: 0; text-align: center; }
        input, select { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #6f42c1; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 16px; transition: 0.3s; }
        button:hover { background: #5a32a3; transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="navbar">
    <div style="color: white; font-weight: bold; font-size: 1.2rem;">
        🎓 GradePoint <span style="color: #a855f7;">Pro</span>
    </div>
    
    <div style="color: #888; display: flex; align-items: center; gap: 20px;">
        <span>User: <strong style="color: #fff;"><?php echo $_SESSION['username']; ?></strong></span>
        <a href="../secure_pass/logout.php" style="background: #ff4d4d; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; font-weight: bold;">Logout</a>
    </div>
</div>

<div class="form-container">
    <div class="form-card">
        <h2>Add New Student</h2>
        
        <?php if(isset($error_msg)) echo "<p style='color:red;'>$error_msg</p>"; ?>

        <form method="POST">
            <input type="text" name="full_name" placeholder="Full Name (e.g. Tunde Balogun)" required>
            <input type="text" name="reg_number" placeholder="Registration Number" required>
            <select name="class">
                <option value="JSS1">JSS 1</option>
                <option value="JSS2">JSS 2</option>
                <option value="JSS3">JSS 3</option>
                <option value="SS1">SS 1</option>
                <option value="SS2">SS 2</option>
                <option value="SS3">SS 3</option>
            </select>
            <button type="submit">Register Student</button>
            <a href="index.php" style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none; font-size:14px;">← Back to Dashboard</a>
        </form>
    </div>
</div>

</body>
</html>
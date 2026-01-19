<?php
$conn = new mysqli("localhost", "root", "", "grading_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['full_name'];
    $reg = $_POST['reg_number'];
    $class = $_POST['class'];

    $sql = "INSERT INTO students (full_name, reg_number, class) VALUES ('$name', '$reg', '$class')";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Student</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { color: #6f42c1; margin-bottom: 20px; text-align: center; }
        input, select { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #6f42c1; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 16px; transition: 0.3s; }
        button:hover { background: #5a32a3; }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Add New Student</h2>
    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name (e.g. Tunde Balogun)" required>
        <input type="text" name="reg_number" placeholder="Registration Number (e.g. 2024/001)" required>
        <select name="class">
            <option value="JSS1">JSS 1</option>
            <option value="JSS2">JSS 2</option>
            <option value="JSS3">JSS 3</option>
            <option value="SS1">SS 1</option>
            <option value="SS2">SS 2</option>
            <option value="SS3">SS 3</option>
        </select>
        <button type="submit">Register Student</button>
        <a href="index.php" style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none; font-size:14px;">Back to Dashboard</a>
    </form>
</div>

</body>
</html>
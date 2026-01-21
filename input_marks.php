<?php
session_start();

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../secure_pass/login.php");
    exit();
}

// 2. Connect to the NEW unified database
$conn = new mysqli("localhost", "root", "", "secure_db");
?>



<?php
$conn = new mysqli("localhost", "root", "", "secure_db");
$student_id = $_GET['id'];

// Get student name for the title
$student = $conn->query("SELECT full_name FROM students WHERE id = $student_id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $ca = (int)$_POST['ca_score'];
    $exam = (int)$_POST['exam_score'];
    
    $total = $ca + $exam;

    // The Grading Logic
    if ($total >= 70) { $grade = 'A'; }
    elseif ($total >= 60) { $grade = 'B'; }
    elseif ($total >= 50) { $grade = 'C'; }
    elseif ($total >= 45) { $grade = 'D'; }
    else { $grade = 'F'; }

    $sql = "INSERT INTO marks (student_id, subject, ca_score, exam_score, total_score, grade) 
            VALUES ($student_id, '$subject', $ca, $exam, $total, '$grade')";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
        exit();
    }
}
?>

<?php
// Redirect to login if the session doesn't exist
if (!isset($_SESSION['user_id'])) {
    header("Location: ../secure_pass/login.php");
    exit();
}

// Connect to the new unified database
$conn = new mysqli("localhost", "root", "", "secure_db");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Scores</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 40px; }
        .box { background: white; padding: 25px; max-width: 500px; margin: auto; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;}
        button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div style="background: #1a1d2b; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #a855f7; margin-bottom: 30px;">
    <div style="color: white; font-weight: bold; font-size: 1.2rem;">
        🎓 GradePoint <span style="color: #a855f7;">Pro</span>
    </div>
    
    <div style="color: #888; display: flex; align-items: center; gap: 20px;">
        <span>Logged in as: <strong style="color: #fff;"><?php echo $_SESSION['username']; ?></strong> 
              (<span style="color: #a855f7;"><?php echo ucfirst($_SESSION['role']); ?></span>)
        </span>
        
        <a href="../secure_pass/logout.php" 
           style="background: #ff4d4d; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; font-weight: bold;">
           Logout
        </a>
    </div>
</div>
    <div class="box">
        <h3>Add Scores for: <?php echo $student['full_name']; ?></h3>
        <form method="POST">
            <input type="text" name="subject" placeholder="Subject (e.g. Mathematics)" required>
            <input type="number" name="ca_score" placeholder="CA Score (Max 40)" max="40" required>
            <input type="number" name="exam_score" placeholder="Exam Score (Max 60)" max="60" required>
            <button type="submit">Save Record</button>
        </form>
    </div>
</body>
</html>
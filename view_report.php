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

// 1. Get Student Info
$student_query = $conn->query("SELECT * FROM students WHERE id = $student_id");
$student = $student_query->fetch_assoc();

// 2. Get All Marks for this Student
$marks_query = $conn->query("SELECT * FROM marks WHERE student_id = $student_id");

// 3. Get Averages for the Summary
$stats_query = $conn->query("SELECT AVG(total_score) as average, SUM(total_score) as grand_total FROM marks WHERE student_id = $student_id");
$stats = $stats_query->fetch_assoc();
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Card | <?php echo $student['full_name']; ?></title>
    <style>
        body { font-family: 'Arial', sans-serif; padding: 30px; background: #f9f9f9; }
        .report-card { max-width: 800px; margin: auto; background: white; padding: 40px; border: 2px solid #333; position: relative; }
        .school-header { text-align: center; border-bottom: 4px double #333; margin-bottom: 20px; padding-bottom: 10px; }
        .student-info { display: flex; justify-content: space-between; margin-bottom: 30px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 10px; text-align: center; }
        th { background: #f2f2f2; }
        .summary-box { margin-top: 30px; padding: 15px; border: 1px dashed #333; display: inline-block; min-width: 250px; }
        .grade-a { color: green; font-weight: bold; }
        .grade-f { color: red; font-weight: bold; }
        
        @media print {
            .no-print { display: none; }
            body { padding: 0; background: white; }
            .report-card { border: none; }
        }
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

<div class="no-print" style="text-align: center; margin-bottom: 20px;">
    <button onclick="window.print()" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">🖨️ Print Report Card</button>
    <a href="index.php" style="margin-left: 10px; color: #666;">Back to Dashboard</a>
</div>

<div class="report-card">
    <div class="school-header">
        <h1 style="margin: 0;">EXCELLENCE INTERNATIONAL ACADEMY</h1>
        <p style="margin: 5px 0;">Official Student Progress Report</p>
    </div>

    <div class="student-info">
        <div>
            NAME: <?php echo strtoupper($student['full_name']); ?><br>
            REG NO: <?php echo $student['reg_number']; ?>
        </div>
        <div style="text-align: right;">
            CLASS: <?php echo $student['class']; ?><br>
            TERM: First Term 2025/2026
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>SUBJECT</th>
                <th>C.A. (40)</th>
                <th>EXAM (60)</th>
                <th>TOTAL (100)</th>
                <th>GRADE</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $marks_query->fetch_assoc()): ?>
            <tr>
                <td style="text-align: left;"><?php echo $row['subject']; ?></td>
                <td><?php echo $row['ca_score']; ?></td>
                <td><?php echo $row['exam_score']; ?></td>
                <td><strong><?php echo $row['total_score']; ?></strong></td>
                <td class="<?php echo ($row['grade'] == 'A') ? 'grade-a' : (($row['grade'] == 'F') ? 'grade-f' : ''); ?>">
                    <?php echo $row['grade']; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="summary-box">
        <strong>PERFORMANCE SUMMARY:</strong><br>
        Grand Total: <?php echo $stats['grand_total']; ?><br>
        Average Score: <?php echo number_format($stats['average'], 2); ?>%<br>
        Final Remark: 
        <?php 
            if($stats['average'] >= 50) echo "PASS";
            else echo "FAIL";
        ?>
    </div>

    <div style="margin-top: 50px; display: flex; justify-content: space-between;">
        <div style="border-top: 1px solid #333; width: 200px; text-align: center;">Class Teacher's Signature</div>
        <div style="border-top: 1px solid #333; width: 200px; text-align: center;">Principal's Stamp</div>
    </div>
</div>

</body>
</html>
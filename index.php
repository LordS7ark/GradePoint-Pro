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

// If not logged in, kick them out to the login page
if (!isset($_SESSION['user_id'])) {
    // Note: You may need to adjust this path depending on where your login file is
    header("Location: ../secure_pass/login.php"); 
    exit();
}
?>
<?php
$conn = new mysqli("localhost", "root", "", "grading_db");

// Check if a search query exists
$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
    // Search by Name OR Registration Number
    $query = "SELECT * FROM students WHERE full_name LIKE '%$search%' OR reg_number LIKE '%$search%'";
} else {
    $query = "SELECT * FROM students";
}

$students = $conn->query($query);
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
    <title>GradePoint Pro | Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 20px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .btn { padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px; color: white; }
        .btn-add { background: #6f42c1; }
        .btn-view { background: #007bff; }
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

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>🎓 GradePoint Pro</h2>
        <a href="add_student.php" class="btn btn-add">+ Register Student</a>
    </div>

    <div style="margin: 20px 0;">
    <form method="GET" style="display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="Search by name or Reg No..." 
               value="<?php echo htmlspecialchars($search); ?>" 
               style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
        <button type="submit" style="padding: 10px 20px; background: #6f42c1; color: white; border: none; border-radius: 8px; cursor: pointer;">
            🔍 Search
        </button>
        <?php if(!empty($search)): ?>
            <a href="index.php" style="padding: 10px; color: #666; text-decoration: none;">Clear</a>
        <?php endif; ?>
    </form>
</div>

    <table>
        <thead>
            <tr>
                <th>Reg No</th>
                <th>Full Name</th>
                <th>Class</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $students->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['reg_number']; ?></td>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['class']; ?></td>
                <td>
    <a href="input_marks.php?id=<?php echo $row['id']; ?>" class="btn btn-view">Add Scores</a>
    <a href="view_report.php?id=<?php echo $row['id']; ?>" class="btn" style="background:#28a745;">Report Card</a>
    
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <a href="delete_student.php?id=<?php echo $row['id']; ?>" 
           class="btn" 
           style="background:#dc3545;" 
           onclick="return confirm('Are you sure you want to delete this student?')">
           Delete
        </a>
    <?php endif; ?>
</td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
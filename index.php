<?php
require_once('../secure_pass/db_config.php'); // This handles the $conn to secure_db
session_start();

// 1. Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../secure_pass/login.php");
    exit();
}

// 2. Handle Search Logic
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if (!empty($search)) {
    // Search in the unified secure_db
    $query = "SELECT * FROM students WHERE full_name LIKE '%$search%' OR reg_number LIKE '%$search%' ORDER BY id DESC";
} else {
    $query = "SELECT * FROM students ORDER BY id DESC";
}

$students = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>GradePoint Pro | Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; margin: 0; padding-bottom: 50px; }
        .navbar { background: #1a1d2b; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #a855f7; margin-bottom: 30px; }
        .container { max-width: 1100px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #666; text-transform: uppercase; font-size: 12px; }
        .btn { padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px; color: white; display: inline-block; font-weight: bold; }
        .btn-add { background: #6f42c1; }
        .btn-view { background: #007bff; }
        .search-input { flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; }
        .search-btn { padding: 12px 25px; background: #6f42c1; color: white; border: none; border-radius: 8px; cursor: pointer; }
    </style>
</head>
<body>

<div class="navbar">
    <div style="color: white; font-weight: bold; font-size: 1.2rem;">
        🎓 GradePoint <span style="color: #a855f7;">Pro</span>
    </div>
    <div style="color: #888; display: flex; align-items: center; gap: 20px;">
        <a href="../secure_pass/portal.php" style="color: #a855f7; text-decoration: none; font-size: 0.9rem;">← Portal Hub</a>
        <span>User: <strong style="color: #fff;"><?php echo $_SESSION['username']; ?></strong></span>
        <a href="../secure_pass/logout.php" style="background: #ff4d4d; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; font-weight: bold;">Logout</a>
    </div>
</div>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin:0; color: #333;">Student Records</h2>
        <a href="register_student.php" class="btn btn-add">+ Register New Student</a>
    </div>

    <form method="GET" style="display: flex; gap: 10px; margin-bottom: 30px;">
        <input type="text" name="search" class="search-input" placeholder="Search by name or Reg No..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="search-btn">🔍 Search</button>
        <?php if(!empty($search)): ?>
            <a href="index.php" style="padding: 12px; color: #666; text-decoration: none; align-self: center;">Clear</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>Reg No</th>
                <th>Full Name</th>
                <th>Class</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if($students->num_rows > 0): ?>
                <?php while($row = $students->fetch_assoc()): ?>
                <tr>
                    <td style="font-weight: bold; color: #6f42c1;"><?php echo $row['reg_number']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><span style="background: #eee; padding: 4px 8px; border-radius: 4px; font-size: 12px;"><?php echo $row['class']; ?></span></td>
                    <td style="text-align: right; gap: 5px; display: flex; justify-content: flex-end;">
                        <a href="input_marks.php?id=<?php echo $row['id']; ?>" class="btn btn-view">Add Scores</a>
                        <a href="view_report.php?id=<?php echo $row['id']; ?>" class="btn" style="background:#28a745;">Report Card</a>
                        <?php if ($_SESSION['role'] == 'admin'): ?>
                            <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn" style="background:#dc3545;" onclick="return confirm('Are you sure?')">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #999;">
                        No student records found.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
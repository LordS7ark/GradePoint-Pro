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
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php
session_start();
include('../secure_pass/db_config.php');

// Security Layer 1: Must be logged in
// Security Layer 2: Must be an ADMIN
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Unauthorized Access!");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM students WHERE id = $id");
}

header("Location: index.php");
exit();

<?php
// Redirect to login if the session doesn't exist
if (!isset($_SESSION['user_id'])) {
    header("Location: ../secure_pass/login.php");
    exit();
}

// Connect to the new unified database
$conn = new mysqli("localhost", "root", "", "secure_db");
?>
<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $item_name = trim($_POST['item_name']);
    $description = trim($_POST['description']);
    $quantity = (int)$_POST['quantity'];
    $unit_price = (float)$_POST['unit_price'];
    $department_id = (int)$_POST['department_id'];
    if ($item_name == "" || $quantity < 1 || $unit_price <= 0) {
        header("Location: purchase_request.php?error=Please fill the form correctly");
        exit();
    }
    $stmt = mysqli_prepare($conn, "INSERT INTO purchase_requests (user_id, department_id, item_name, description, quantity, unit_price) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iissid", $user_id, $department_id, $item_name, $description, $quantity, $unit_price);
    mysqli_stmt_execute($stmt);
    header("Location: my_requests.php?msg=Request submitted");
    exit();
}
header("Location: purchase_request.php");
exit();
?>
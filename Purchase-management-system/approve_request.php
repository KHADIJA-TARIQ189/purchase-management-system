<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['role'] != 'admin') {
    die("Access denied");
}
if (isset($_POST['action'])) {
    $id = (int)$_POST['id'];
    $action = $_POST['action'];
    $remarks = "";
    if (isset($_POST['remarks'])) {
        $remarks = trim($_POST['remarks']);
    }
    if ($action == 'approved' || $action == 'rejected') {
        $stmt = mysqli_prepare($conn, "UPDATE purchase_requests SET status = ?, remarks = ? WHERE id = ? AND status = 'pending'");
        mysqli_stmt_bind_param($stmt, "ssi", $action, $remarks, $id);
        mysqli_stmt_execute($stmt);
    }
}
header("Location: approve_requests.php?msg=Request updated");
exit();
?>
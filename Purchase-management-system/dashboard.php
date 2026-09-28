<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$pending = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM purchase_requests WHERE user_id = $user_id AND status = 'pending'"));
$approved = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM purchase_requests WHERE user_id = $user_id AND status = 'approved'"));
$rejected = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM purchase_requests WHERE user_id = $user_id AND status = 'rejected'"));
$waiting = 0;
if ($_SESSION['role'] == 'admin') {
    $waiting = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM purchase_requests WHERE status = 'pending'"));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Purchase_management-system</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="navbar">
    <b>Purchase System</b>
    <a href="dashboard.php">Dashboard</a>
    <a href="purchase_request.php">New Request</a>
    <a href="my_requests.php">My Requests</a>
    <?php if ($_SESSION['role'] == 'admin') { ?>
        <a href="approve_requests.php">Approve Requests</a>
        <a href="departments.php">Departments</a>
        <a href="users.php">Users</a>
    <?php } ?>
    <a href="logout.php">Logout (<?php echo $_SESSION['name']; ?>)</a>
</div>
<div class="container">
    <h2>Welcome, <?php echo $_SESSION['name']; ?></h2>
    <div class="cards">
        <div class="card-box">
            <h3><?php echo $pending; ?></h3>
            <p>My Pending</p>
        </div>
        <div class="card-box">
            <h3><?php echo $approved; ?></h3>
            <p>My Approved</p>
        </div>
        <div class="card-box">
            <h3><?php echo $rejected; ?></h3>
            <p>My Rejected</p>
        </div>
        <?php if ($_SESSION['role'] == 'admin') { ?>
        <div class="card-box">
            <h3><?php echo $waiting; ?></h3>
            <p>Waiting for approval</p>
        </div>
        <?php } ?>
    </div>
    <a class="btn" href="purchase_request.php">New Purchase Request</a>
</div>
</body>
</html>
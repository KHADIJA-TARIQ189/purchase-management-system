<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$id = (int)$_GET['id'];
$sql = "SELECT purchase_requests.*, departments.name AS dept_name, users.name AS user_name
        FROM purchase_requests
        JOIN departments ON purchase_requests.department_id = departments.id
        JOIN users ON purchase_requests.user_id = users.id
        WHERE purchase_requests.id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (!$row) {
    die("Request not found");
}
if ($row['user_id'] != $_SESSION['user_id'] && $_SESSION['role'] != 'admin') {
    die("Access denied");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Request Details</title>
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
    <div class="box">
        <h2>Request #<?php echo $row['id']; ?></h2>
        <p><b>Item:</b> <?php echo htmlspecialchars($row['item_name']); ?></p>
        <p><b>Description:</b> <?php echo htmlspecialchars($row['description']); ?></p>
        <p><b>Requested by:</b> <?php echo htmlspecialchars($row['user_name']); ?></p>
        <p><b>Department:</b> <?php echo htmlspecialchars($row['dept_name']); ?></p>
        <p><b>Quantity:</b> <?php echo $row['quantity']; ?></p>
        <p><b>Unit price:</b> <?php echo number_format($row['unit_price'], 2); ?></p>
        <p><b>Total:</b> <?php echo number_format($row['quantity'] * $row['unit_price'], 2); ?></p>
        <p><b>Date:</b> <?php echo $row['created_at']; ?></p>
        <p><b>Status:</b> <span class="status <?php echo $row['status']; ?>"><?php echo $row['status']; ?></span></p>
        <?php if ($row['remarks'] != "") { ?>
            <p><b>Remarks:</b> <?php echo htmlspecialchars($row['remarks']); ?></p>
        <?php } ?>
        <?php if ($_SESSION['role'] == 'admin' && $row['status'] == 'pending') { ?>
            <hr>
            <form method="post" action="approve_request.php">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <label>Remarks</label>
                <textarea name="remarks" rows="2"></textarea>
                <button type="submit" name="action" value="approved" class="green">Approve</button>
                <button type="submit" name="action" value="rejected" class="red">Reject</button>
            </form>
        <?php } ?>
        <br>
        <a href="my_requests.php">Back</a>
    </div>
</div>
</body>
</html>
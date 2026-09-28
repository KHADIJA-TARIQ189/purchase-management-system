<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT purchase_requests.*, departments.name AS dept_name FROM purchase_requests JOIN departments ON purchase_requests.department_id = departments.id WHERE purchase_requests.user_id = $user_id ORDER BY purchase_requests.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Requests</title>
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
    <h2>My Requests</h2>
    <?php if (isset($_GET['msg'])) { echo "<p class='success'>" . htmlspecialchars($_GET['msg']) . "</p>"; } ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Item</th>
            <th>Department</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
            <td><?php echo htmlspecialchars($row['dept_name']); ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo number_format($row['quantity'] * $row['unit_price'], 2); ?></td>
            <td><span class="status <?php echo $row['status']; ?>"><?php echo $row['status']; ?></span></td>
            <td><?php echo substr($row['created_at'], 0, 10); ?></td>
            <td><a href="request_details.php?id=<?php echo $row['id']; ?>">View</a></td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>

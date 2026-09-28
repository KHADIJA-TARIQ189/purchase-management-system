<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['role'] != 'admin') {
    die("Access denied");
}
$result = mysqli_query($conn, "SELECT * FROM departments ORDER BY name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Departments</title>
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
    <h2>Departments</h2>
    <?php if (isset($_GET['msg'])) { echo "<p class='success'>" . htmlspecialchars($_GET['msg']) . "</p>"; } ?>
    <a class="btn" href="add_department.php">Add Department</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
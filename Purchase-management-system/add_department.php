<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['role'] != 'admin') {
    die("Access denied");
}
$error = "";
if (isset($_POST['save'])) {
    $name = trim($_POST['name']);
    if ($name == "") {
        $error = "Please enter the department name";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO departments (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        header("Location: departments.php?msg=Department added");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Department</title>
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
    <div class="box small">
        <h2>Add Department</h2>
        <?php if ($error != "") { echo "<p class='error'>$error</p>"; } ?>
        <form method="post">
            <label>Department Name</label>
            <input type="text" name="name" required>
            <button type="submit" name="save">Save</button>
        </form>
    </div>
</div>
</body>
</html>

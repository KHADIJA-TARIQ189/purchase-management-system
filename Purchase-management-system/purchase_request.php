<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$departments = mysqli_query($conn, "SELECT * FROM departments ORDER BY name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>New Purchase Request</title>
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
        <h2>New Purchase Request</h2>
        <?php if (isset($_GET['error'])) { echo "<p class='error'>" . htmlspecialchars($_GET['error']) . "</p>"; } ?>
        <form method="post" action="submit_request.php">
            <label>Item Name</label>
            <input type="text" name="item_name" required>
            <label>Description</label>
            <textarea name="description" rows="3"></textarea>
            <label>Quantity</label>
            <input type="number" name="quantity" id="quantity" min="1" value="1" required>
            <label>Unit Price</label>
            <input type="number" name="unit_price" id="unit_price" min="0.01" step="0.01" required>
            <label>Total</label>
            <input type="text" id="total" value="0.00" readonly>
            <label>Department</label>
            <select name="department_id" required>
                <?php while ($d = mysqli_fetch_assoc($departments)) { ?>
                    <option value="<?php echo $d['id']; ?>" <?php if ($d['id'] == $_SESSION['department_id']) { echo "selected"; } ?>>
                        <?php echo htmlspecialchars($d['name']); ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit" name="submit">Submit Request</button>
        </form>
    </div>
</div>
<script src="js/script.js"></script>
</body>
</html>
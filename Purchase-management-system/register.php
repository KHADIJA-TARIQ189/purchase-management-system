<?php
include 'config.php';
$error = "";
$departments = mysqli_query($conn, "SELECT * FROM departments ORDER BY name");
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $department_id = (int)$_POST['department_id'];
    if ($name == "" || $email == "" || $password == "") {
        $error = "Please fill all fields";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } elseif ($password != $confirm) {
        $error = "Passwords do not match";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Email is already registered";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = mysqli_prepare($conn, "INSERT INTO users (name, email, password, role, department_id) VALUES (?, ?, ?, 'employee', ?)");
            mysqli_stmt_bind_param($stmt2, "sssi", $name, $email, $hashed, $department_id);
            mysqli_stmt_execute($stmt2);
            header("Location: login.php?registered=1");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="box small">
    <h2>Register</h2>
    <?php if ($error != "") { echo "<p class='error'>$error</p>"; } ?>
    <form method="post">
        <label>Full Name</label>
        <input type="text" name="name" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Department</label>
        <select name="department_id" required>
            <option value="">-- Select --</option>
            <?php while ($d = mysqli_fetch_assoc($departments)) { ?>
                <option value="<?php echo $d['id']; ?>"><?php echo htmlspecialchars($d['name']); ?></option>
            <?php } ?>
        </select>
        <label>Password</label>
        <input type="password" name="password" required>
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
<?php
include 'config.php';
$error = "";
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['department_id'] = $user['department_id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Wrong email or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="box small">
    <h2>Login</h2>
    <?php if ($error != "") { echo "<p class='error'>$error</p>"; } ?>
    <?php if (isset($_GET['registered'])) 
        { echo "<p class='success'>Registered! You can login now.</p>"; } ?>
    <form method="post">
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p>No account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
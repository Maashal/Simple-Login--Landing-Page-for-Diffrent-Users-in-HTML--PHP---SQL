<?php
include("inc/connection.inc.php");

ob_start();
session_start();

$user = "";
$utype_db = "";

if (isset($_SESSION['user_login'])) {
    $user = $_SESSION['user_login'];
    $result = $con->query("SELECT * FROM user WHERE id='$user'");
    $get_user_name = $result->fetch_assoc();
    $uname_db = $get_user_name['fullname'];
    $utype_db = $get_user_name['type'];
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();

// Admin Login Logic
$admin_errors = [];
if (isset($_POST['admin_login'])) {
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];

    // Validate inputs
    if (empty($admin_email)) {
        $admin_errors[] = "Email is required";
    }
    if (empty($admin_password)) {
        $admin_errors[] = "Password is required";
    }

    if (empty($admin_errors)) {
        // Check if admin credentials are valid
        if ($admin_email === 'admin@tutor.com' && $admin_password === 'admin123') {
            // Admin login successful, redirect to admin dashboard
            $_SESSION['admin_login'] = true;
            header("Location: dashboard.php");
            exit();
        } else {
            $admin_errors[] = "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Weblogr</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="css/footer.css" rel="stylesheet" type="text/css" media="all" />
    <!-- menu tab link -->
    <link rel="stylesheet" type="text/css" href="css/homemenu.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style>
        /* Add your additional styles here */
        .admin-login-container {
            margin: 20px auto;
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .admin-login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .admin-login-container form {
            width: 100%;
        }

        .admin-login-container input[type="text"],
        .admin-login-container input[type="password"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .admin-login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 3px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .admin-login-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .admin-login-container .error {
            color: red;
        }
    </style>
</head>

<body class="body1">
    <div>
        <div>
            <header class="header">
                <div class="header-cont">
                    <?php include 'inc/banner.inc.php'; ?>
                </div>
            </header>
        </div>
        <div class="topnav">
            <div class="parent2">
                <div class="mask2"><i class="fa fa-home fa-3x"></i></div>
            </div>
            <a class="navlink" href="#"></a>
            <a class="navlink" href="#"></a>
            <a class="navlink" href="admin/index.php">Admin Login</a>
            <div style="float: right;">
                <table>
                    <tr>
                        <?php if (empty($user)) : ?>
                            <td>
                                <a class="navlink" href="../index.php">Login</a>
                            </td>
                            <td>
                                <a class="navlink" href="../registration.php">Register</a>
                            </td>
                        <?php else : ?>
                            <td>
                                <span>Welcome, <?php echo $uname_db; ?></span>
                            </td>
                            <td>
                                <a class="navlink" href="logout.php">Logout</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Admin Login Form -->
    <div class="admin-login-container">
        <h2>Admin Login</h2>
        <?php if (!empty($admin_errors)) : ?>
            <div class="error">
                <?php foreach ($admin_errors as $error) : ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <input type="text" name="admin_email" placeholder="Email" required><br>
            <input type="password" name="admin_password" placeholder="Password" required><br>
            <input type="submit" name="admin_login" value="Login">
        </form>
    </div>

    <!-- main jquery script -->
    <script src="js/jquery-3.2.1.min.js"></script>

    <!-- homemenu tab script -->
    <script src="js/homemenu.js"></script>

    <!-- topnavfixed script -->
    <script src="js/topnavfixed.js"></script>
</body>

</html>

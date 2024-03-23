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

// Login Logic
$errors = [];
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs (you can add more validation as per your requirements)
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        // Check if user exists in the database
        $query = "SELECT * FROM user WHERE email='$email' AND pass='$password'";
        $result = $con->query($query);

        if ($result && $result->num_rows > 0) {
            // User found, set session and redirect
            $user_data = $result->fetch_assoc();
            $_SESSION['user_login'] = $user_data['id'];
            header("Location: user_home.php");
            exit();
        } else {
            $errors[] = "Invalid email or password";
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
        .login-container {
            margin: 20px auto;
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-container form {
            width: 100%;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 3px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .login-container .register-link {
            text-align: center;
            margin-top: 10px;
        }

        .login-container .register-link a {
            text-decoration: none;
            font-weight: bold;
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
                                <a class="navlink" href="login.php">Login</a>
                            </td>
                            <td>
                                <a class="navlink" href="registration.php">Register</a>
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

    <!-- Login Form -->
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($errors)) : ?>
            <div class="error">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
        <div class="register-link">
            Not registered yet? <a href="registration.php">Register here</a>.
        </div>
    </div>

    <!-- main jquery script -->
    <script src="js/jquery-3.2.1.min.js"></script>

    <!-- homemenu tab script -->
    <script src="js/homemenu.js"></script>

    <!-- topnavfixed script -->
    <script src="js/topnavfixed.js"></script>
</body>

</html>

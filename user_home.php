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

?>

<!DOCTYPE html>
<html>

<head>
    <title>User Home - Weblogr</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="css/footer.css" rel="stylesheet" type="text/css" media="all" />
    <!-- menu tab link -->
    <link rel="stylesheet" type="text/css" href="css/homemenu.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style>
        /* Add your additional styles here */
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
            <?php if (isset($_SESSION['user_login'])) : ?>
                <a class="navlink" href="profile.php">Profile</a>
            <?php endif; ?>
            <div style="float: right;">
                <table>
                    <tr>
                        <?php if (isset($_SESSION['user_login'])) : ?>
                            <td>
                                <span>Welcome, <?php echo $uname_db; ?></span>
                            </td>
                            <td>
                                <a class="navlink" href="logout.php">Logout</a>
                            </td>
                        <?php else : ?>
                            <td>
                                <a class="navlink" href="login.php">Login</a>
                            </td>
                            <td>
                                <a class="navlink" href="register.php">Register</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- User Home Content -->
    <div class="user-home-content">
        <!-- Add your content here -->
        <h2>Welcome to your User Home Page, <?php echo $uname_db; ?>!</h2>
        <p>This is your personalized user home page. You can add your content, features, and functionalities here.</p>
    </div>

    <!-- main jquery script -->
    <script src="js/jquery-3.2.1.min.js"></script>

    <!-- homemenu tab script -->
    <script src="js/homemenu.js"></script>

    <!-- topnavfixed script -->
    <script src="js/topnavfixed.js"></script>
</body>

</html>

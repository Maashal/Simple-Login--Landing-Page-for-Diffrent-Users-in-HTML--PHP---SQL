<?php
include("inc/connection.inc.php");

ob_start();
session_start();

$user = "";
$utype_db = "";

if (isset($_SESSION['user_login'])) {
    $user = $_SESSION['user_login'];
    $result = $con->query("SELECT * FROM user WHERE id='$user'");
    $get_user_data = $result->fetch_assoc();
    $fullname_db = $get_user_data['fullname'];
    $gender_db = $get_user_data['gender'];
    $email_db = $get_user_data['email'];
    $phone_db = $get_user_data['phone'];
    $address_db = $get_user_data['address'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    // Update user information in the database
    $update_query = "UPDATE user SET fullname='$fullname', gender='$gender', email='$email', phone='$phone', address='$address' WHERE id='$user'";
    $con->query($update_query);
    
    // Redirect or display success message as per your requirement
    header("Location: profile.php");
    exit();
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();

?>

<!DOCTYPE html>
<html>

<head>
    <title>User Profile - Weblogr</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="css/footer.css" rel="stylesheet" type="text/css" media="all" />
    <!-- menu tab link -->
    <link rel="stylesheet" type="text/css" href="css/homemenu.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style>
        /* Add your additional styles here */
        .profile-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile-content label {
            display: block;
            margin-bottom: 10px;
        }

        .profile-content input[type="text"],
        .profile-content input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        .profile-content input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        @media screen and (max-width: 600px) {
            .profile-content input[type="text"],
            .profile-content input[type="email"],
            .profile-content input[type="submit"] {
                width: 100%;
            }
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
            <?php if (isset($_SESSION['user_login'])) : ?>
                <a class="navlink" href="profile.php">Profile</a>
            <?php endif; ?>
            <div style="float: right;">
                <table>
                    <tr>
                        <?php if (isset($_SESSION['user_login'])) : ?>
                            <td>
                                <span>Welcome, <?php echo $fullname_db; ?></span>
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

    <!-- Profile Content -->
    <div class="profile-content">
        <!-- Add your profile content here -->
        <h2>User Profile</h2>
        <!-- Display user data in a form for updating -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo $fullname_db; ?>">
            
            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" value="<?php echo $gender_db; ?>">
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email_db; ?>">
            
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $phone_db; ?>">
            
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $address_db; ?>">
            
            <input type="submit" value="Update">
        </form>
    </div>

    <!-- Include your scripts if needed -->

</body>

</html>

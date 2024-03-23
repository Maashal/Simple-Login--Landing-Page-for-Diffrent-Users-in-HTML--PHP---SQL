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

$errors = [];
if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    if (empty($fullname)) {
        $errors[] = "Full Name is required";
    }
    if (empty($gender)) {
        $errors[] = "Gender is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }
    if (empty($address)) {
        $errors[] = "Address is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    if (empty($errors)) {
        // Check if the email is already registered
        $check_email_query = "SELECT * FROM user WHERE email='$email'";
        $check_email_result = $con->query($check_email_query);

        if ($check_email_result && $check_email_result->num_rows > 0) {
            $errors[] = "Email is already registered";
        } else {
            // Insert user data into the database with 'pending' verification
            $insert_query = "INSERT INTO user (fullname, gender, email, phone, address, pass, verification) VALUES ('$fullname', '$gender', '$email', '$phone', '$address', '$password', 'pending')";
            $insert_result = $con->query($insert_query);

            if ($insert_result) {
                // Registration successful, redirect to login page
                header("Location: index.php");
                exit();
            } else {
                $errors[] = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Registration - Weblogr</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="css/footer.css" rel="stylesheet" type="text/css" media="all" />
    <!-- menu tab link -->
    <link rel="stylesheet" type="text/css" href="css/homemenu.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style>
        /* Add your additional styles here */
        .registration-container {
            margin: 20px auto;
            max-width: 600px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .registration-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .registration-container form {
            width: 100%;
        }

        .registration-container table {
            margin: 0 auto; /* Center the table */
        }

        .registration-container input[type="text"],
        .registration-container input[type="email"],
        .registration-container input[type="password"],
        .registration-container select,
        .registration-container textarea {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .registration-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 3px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .registration-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .registration-container .error {
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
                                <a class="navlink" href="index.php">Login</a>
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

    <!-- Registration Form -->
    <div class="registration-container">
        <h2>Register</h2>
        <?php if (!empty($errors)) : ?>
            <div class="error">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <table>
                <tr>
                    <td><input type="text" name="fullname" placeholder="Full Name" required></td>
                    <td>
                        <select name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="email" name="email" placeholder="Email" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="phone" placeholder="Phone" required></td>
                </tr>
                <tr>
                    <td colspan="2"><textarea name="address" placeholder="Address" required></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="password" name="password" placeholder="Password" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="password" name="confirm_password" placeholder="Confirm Password" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="register" value="Register"></td>
                </tr>
            </table>
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

<?php
// Start session
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header("Location: index.php");
    exit();
}

// Include database connection
include("inc/connection.inc.php");

// Check if form is submitted to approve a user
if (isset($_POST['approve_user'])) {
    $user_id = $_POST['user_id'];

    // Update the user's verification status to 'approved'
    $query = "UPDATE user SET verification = 'approved' WHERE id = '$user_id'";
    $result = $con->query($query);

    if ($result) {
        // Redirect to the same page after approval
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: Unable to approve user.";
    }
}

// Retrieve all users (both approved and not approved)
$query = "SELECT * FROM user";
$result = $con->query($query);

// Initialize an array to store user data
$users = [];

// Fetch user data and store it in the array
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard - Weblogr</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="css/footer.css" rel="stylesheet" type="text/css" media="all" />
    <!-- menu tab link -->
    <link rel="stylesheet" type="text/css" href="css/homemenu.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style>
        /* Add your additional styles here */
        .admin-dashboard-container {
            margin: 20px auto;
            max-width: 800px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .admin-dashboard-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .admin-dashboard-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-dashboard-container th,
        .admin-dashboard-container td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .admin-dashboard-container th {
            background-color: #f2f2f2;
        }

        .admin-dashboard-container form {
            margin-bottom: 10px;
        }

        .admin-dashboard-container .approve-btn {
            background-color: #4CAF50;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .admin-dashboard-container .approve-btn:hover {
            background-color: #45a049;
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
                        <td>
                            <span>Welcome, Admin</span>
                        </td>
                        <td>
                            <a class="navlink" href="logout.php">Logout</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Admin Dashboard Content -->
    <div class="admin-dashboard-container">
        <h2>Admin Dashboard</h2><br>
        <h2> Registered Users </h2><br>
        <table>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['fullname']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo ucfirst($user['verification']); ?></td>
                    <td>
                        <?php if ($user['verification'] === 'pending') : ?>
                            <form action="" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <input type="submit" class="approve-btn" name="approve_user" value="Approve">
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- main jquery script -->
    <script src="js/jquery-3.2.1.min.js"></script>

    <!-- homemenu tab script -->
    <script src="js/homemenu.js"></script>

    <!-- topnavfixed script -->
    <script src="js/topnavfixed.js"></script>
</body>

</html>

<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<!-- <link href="style.css" rel="stylesheet" type="text/css"> -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <style>
            body {
            background-image: url("bg.jpg") ;
            margin-top: 10px;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
            }
            
            .navtop {
                background-color: #131313;
                height: 60px;
                width: 100%;
                border: 0;
            }
            .navtop div {
                display: flex;
                margin: 0 auto;
                width: 1000px;
                height: 100%;
            }
            .navtop div h1, .navtop div a {
                display: inline-flex;
                align-items: center;
            }
            .navtop div h1 {
                flex: 1;
                font-size: 24px;
                padding: 0;
                margin: 0;
                color: #eaebed;
                font-weight: normal;
            }
            .navtop div a {
                padding: 0 20px;
                text-decoration: none;
                color: #c1c4c8;
                font-weight: bold;
            }
            .navtop div a i {
                padding: 2px 8px 0 0;
            }
            .navtop div a:hover {
                color: #eaebed;
            }
            body.loggedin {
                background-color: #f3f4f7;
            }
            .content {
                width: 1000px;
                margin: 0 auto;
            }
            .content h2 {
                margin: 0;
                padding: 25px 0;
                font-size: 22px;
                border-bottom: 1px solid #e0e0e3;
                color: #fff;
            }
            .content > p, .content > div {
                box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);
                margin: 25px 0;
                padding: 25px;
                background-color: #fff;
            }
            .content > p table td, .content > div table td {
                padding: 5px;
            }
            .content > p table td:first-child, .content > div table td:first-child {
                font-weight: bold;
                color: #131313;
                padding-right: 15px;
            }
            .content > div p {
                padding: 5px;
                margin: 0 0 10px 0;
            }
        </style>
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>SecureMe</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=$password?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>
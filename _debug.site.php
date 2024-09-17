<?php include('_system.site/_header.php'); ?>
<?php include('_system.site/_connect.php'); ?>
<?php // Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else {
	echo "Connected: successfully";
}
?>

|<?= $web_record['web_name']; ?>

<?php
if(!isset($_COOKIE[$cookie_name])) {
  echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
  echo "Cookie '" . $cookie_name . "' is set!<br>";
  echo "Value is: " . $_COOKIE[$cookie_name];
}
?>

<?php
session_start();
if(!isset($_SESSION['id'])) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['u_name']; ?><?php echo $_SESSION['level'];?></h2>
    <a href="logout.php">Logout</a>
</body>
</html>

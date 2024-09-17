<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "web.setting";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbName);

// import sql web setting
$strSQLweb = "SELECT * FROM web_setting WHERE id =  1 ";
$web_query = mysqli_query($conn,$strSQLweb);
$web_record = mysqli_fetch_array($web_query);

?>

<?php 
// Cookies web date
$cookie_name = "DATE"; 
$cookie_value = date("Y/m/d"); 
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 
?>

<?php 
// Cookies web user id
$cookie_name2 = "USERID"; 
$cookie_value2 = $web_record['id']; 
setcookie($cookie_name2, $cookie_value2, time() + (86400 * 30), "/"); 
?>
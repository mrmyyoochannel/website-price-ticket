<?php
session_start();
if(!isset($_SESSION['id'])) {
    header("location: ../login.php");
    exit;
}
?>



<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web.setting";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $web_name = $_POST["web_name"];
    $web_domain = $_POST["web_domain"];
    $web_version = $_POST["web_version"];
    $web_status = $_POST["web_status"];
    $web_logo = $_POST["web_logo"];
    $sell_status = $_POST["sell_status"];

    $sql = "UPDATE web_setting SET web_name='$web_name', web_domain='$web_domain', web_version='$web_version', web_status='$web_status', web_logo='$web_logo', Sell_Status='$sell_status' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$id = 1; // Example ID to edit
$sql = "SELECT * FROM web_setting WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    $row = null;
    echo "0 results";
}
$conn->close();
?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Web Setting</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Edit Web Setting</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="web_name">Web Name:</label>
                <input type="text" class="form-control" id="web_name" name="web_name" value="<?php echo $row['web_name']; ?>">
            </div>
            <div class="form-group">
                <label for="web_domain">Web Domain:</label>
                <input type="text" class="form-control" id="web_domain" name="web_domain" value="<?php echo $row['web_domain']; ?>">
            </div>
            <div class="form-group">
                <label for="web_version">Web Version:</label>
                <input type="text" class="form-control" id="web_version" name="web_version" value="<?php echo $row['web_version']; ?>">
            </div>
            <div class="form-group">
                <label for="web_status">Web Status:</label>
                <input type="text" class="form-control" id="web_status" name="web_status" value="<?php echo $row['web_status']; ?>">
            </div>
            <div class="form-group">
                <label for="web_logo">Web Logo:</label>
                <input type="text" class="form-control" id="web_logo" name="web_logo" value="<?php echo $row['web_logo']; ?>">
            </div>
            <div class="form-group">
                <label for="sell_status">Sell Status:</label>
                <input type="text" class="form-control" id="sell_status" name="sell_status" value="<?php echo $row['Sell_Status']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <div class="card-footer text-muted">
  ™ 2024 : Service 24 Hour Support <a href="https://myyoomi.carrd.co/">Create By MYYOOMI</a>
  </div>
</body>
</html>

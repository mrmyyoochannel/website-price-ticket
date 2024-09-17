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
    $u_name = $_POST["u_name"];
    $e_mail = $_POST["e_mail"];
    $user_img = $_POST["user_img"];

    $sql = "UPDATE user_profile SET u_name='$u_name', e_mail='$e_mail', user_img='$user_img' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Record updated successfully'
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating record: " . $conn->error . "'
                });
              </script>";
    }
}

$id = 1; // Example ID to edit
$sql = "SELECT * FROM user_profile WHERE id=$id";
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
    <title>Edit User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>Edit User Profile</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="u_name">User Name:</label>
                <input type="text" class="form-control" id="u_name" name="u_name" value="<?php echo $row['u_name']; ?>">
            </div>
            <div class="form-group">
                <label for="e_mail">Email:</label>
                <input type="email" class="form-control" id="e_mail" name="e_mail" value="<?php echo $row['e_mail']; ?>">
            </div>
            <div class="form-group">
                <label for="user_img">User Image:</label>
                <input type="text" class="form-control" id="user_img" name="user_img" value="<?php echo $row['user_img']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

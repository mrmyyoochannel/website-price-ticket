<?php
include('_system.site/_connect.php'); 
include_once('_system.site/_nav.php');

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u_name = $_POST["u_name"];
    $e_mail = $_POST["e_mail"];
    $user_img = $_POST["user_img"];

    $sql = "UPDATE user_profile SET u_name=?, e_mail=?, user_img=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $u_name, $e_mail, $user_img, $user_id);

    if ($stmt->execute()) {
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
                    text: 'Error updating record: " . $stmt->error . "'
                });
              </script>";
    }
    $stmt->close();
}

$sql = "SELECT * FROM user_profile WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    $row = null;
    echo "0 results";
}
$stmt->close();
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
    <div class="card-header"></div>
    <div class="text-center">
  <img src="<?php echo $row['user_img']; ?>" class="rounded" alt="<?= $_SESSION['u_name']; ?>">
	</div>
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
  <div class="card-footer text-muted">
  © 2024 <?= $web_record['web_name']; ?> : Service 24 Hour Support <a href="https://myyoomi.carrd.co/">Create By MYYOOMI</a>
  </div>
</body>
</html>

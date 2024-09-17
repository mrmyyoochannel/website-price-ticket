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
    if (isset($_POST["update"])) {
        $id = $_POST["id"];
        $u_name = $_POST["u_name"];
        $e_mail = $_POST["e_mail"];
        $user_img = $_POST["user_img"];
        $level = $_POST["level"];

        $sql = "UPDATE user_profile SET u_name='$u_name', e_mail='$e_mail', user_img='$user_img', level='$level' WHERE id=$id";

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
    } elseif (isset($_POST["delete"])) {
        $id = $_POST["id"];

        $sql = "DELETE FROM user_profile WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Record deleted successfully'
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error deleting record: " . $conn->error . "'
                    });
                  </script>";
        }
    }
}

$sql = "SELECT * FROM user_profile";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>Manage Users</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>User Image</th>
                    <th>Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
                                    <td><input type='hidden' name='id' value='" . $row['id'] . "'>" . $row['id'] . "</td>
                                    <td><input type='text' class='form-control' name='u_name' value='" . $row['u_name'] . "'></td>
                                    <td><input type='email' class='form-control' name='e_mail' value='" . $row['e_mail'] . "'></td>
                                    <td><input type='text' class='form-control' name='user_img' value='" . $row['user_img'] . "'></td>
                                    <td><input type='text' class='form-control' name='level' value='" . $row['level'] . "'></td>
                                    <td>
                                        <button type='submit' name='update' class='btn btn-primary'>Update</button>
                                        <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                                    </td>
                                </form>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

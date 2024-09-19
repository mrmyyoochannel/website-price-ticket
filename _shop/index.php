<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location: ../login.php");
    exit;
}
include '../_system.site/_connect.php';

$user_email = '';
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_email'])) {
        $user_email = $_POST['user_email'];

        if (!empty($user_email)) {
            $stmt = $conn->prepare("SELECT events.name, tickets.purchase_date, tickets.payment_proof FROM tickets 
                                    JOIN events ON tickets.event_id = events.id 
                                    WHERE tickets.user_email = ?");
            $stmt->bind_param("s", $user_email);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                echo "<script>
                        Toast.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error: " . $stmt->error . "'
                        });
                      </script>";
            }
            $stmt->close();
        } else {
            echo "<script>
                    Toast.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'User email is empty.'
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Toast.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'User email is not set.'
                });
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการบัตรที่ซื้อ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            margin-top: 40px;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #0d6efd;
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 1.5rem;
            text-align: center;
        }

        .card-header h1 {
            font-size: 2rem;
        }

        .table thead {
            background-color: #0d6efd;
            color: white;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-radius: 8px;
            padding: 10px 15px;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .alert-warning {
            background-color: #ffeeba;
            color: #856404;
        }

        .navbar {
            background-color: #0d6efd;
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar-nav .nav-link:hover {
            color: #ffcc00 !important;
        }

        .table-responsive {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .card-header h1 {
                font-size: 1.5rem;
            }

            .table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">Ticket System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="buy_ticket.php?event_id=1">Buy Ticket</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>ตรวจสอบรายการบัตรที่ซื้อ</h1>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="mb-3">
                    <label for="user_email" class="form-label">Gmail:</label>
                    <input value="<?php echo $_SESSION['e_mail']; ?>" type="email" id="user_email" name="user_email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">ตรวจสอบ</button>
            </form>
        </div>
    </div>

    <?php if ($result && $result->num_rows > 0) { ?>
        <div class="card mt-4">
            <div class="card-header">
                <h2>รายการบัตรที่ซื้อ</h2>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ชื่อกิจกรรม</th>
                            <th>วันที่ซื้อ</th>
                            <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 4) { ?>
                                <th>หลักฐานการชำระเงิน</th>
                            <?php } ?>
							<th>Image Profile</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['purchase_date']; ?></td>
                                <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 4) { ?>
                                    <td><img src="<?php echo $row['payment_proof']; ?>" alt="Payment Proof"
                                            style="width:200px;height:auto;"></td>
                                <?php } ?>
								<td><img src="<?php echo $_SESSION['user_img']; ?>" alt="<?php echo $_SESSION['u_name']; ?>"
                                            style="width:200px;height:200px;"></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } elseif ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
        <div class="alert alert-warning mt-4" role="alert">
            ไม่มีข้อมูลการซื้อบัตร
        </div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>

<footer class="text-center mt-4">
    <div class="text-muted">© 2024 <?= $web_record['web_name']; ?> : Service 24 Hour Support <a class="nav-link" href="https://myyoomi.carrd.co/">Create By MYYOOMI</a></div>
</footer>

</body>

</html>

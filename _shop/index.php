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
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error: " . $stmt->error . "'
                        });
                      </script>";
            }
            $stmt->close();
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'User email is empty.'
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        .card {
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .navbar-custom {
            background-color: #007bff;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white;
        }

        .navbar-custom .nav-link:hover {
            color: #ffcc00;
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 20px;
                padding: 10px;
            }

            .card-header h1 {
                font-size: 1.5rem;
            }

            .table {
                font-size: 0.9rem;
            }
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
    <!-- Custom CSS for styling -->
<style>
    .navbar-brand {
        font-weight: bold;
        font-size: 1.5rem;
        color: #007bff;
    }
    .navbar-nav .nav-link {
        font-size: 1.1rem;
        padding: 10px 20px;
        color: #343a40;
        transition: color 0.3s ease-in-out;
    }
    .navbar-nav .nav-link:hover {
        color: #007bff;
    }
    .navbar-light .navbar-toggler {
        border-color: #007bff;
    }
    .navbar-light .navbar-toggler-icon {
        background-color: #007bff;
    }
    .shadow-sm {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
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
                        <input type="text" id="user_email" name="user_email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">ตรวจสอบ</button>
                </form>
            </div>
        </div>

        <?php if ($result && $result->num_rows > 0) { ?>
            <div class="card">
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
      <div class="card-footer text-muted">
  © 2024 <?= $web_record['web_name']; ?> : Service 24 Hour Support
  </div>
</body>

</html>

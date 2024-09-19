<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location: ../login.php");
    exit;
}
include '../_system.site/_connect.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    if (!empty($event_id)) {
        $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $event = $result->fetch_assoc();
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Event ID is empty.";
    }
} else {
    echo "Event ID is not set.";
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ซื้อบัตรเข้าร่วมงาน</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 40px;
        }
        .card {
            margin-top: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #17a2b8;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 15px 15px 0 0;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da;
        }
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        @media (max-width: 768px) {
            .container {
                margin-top: 20px;
                padding: 10px;
            }
            .card-header h1 {
                font-size: 1.4rem;
            }
            .form-label {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>ซื้อบัตรเข้าร่วมงาน: <?php echo isset($event['name']) ? $event['name'] : 'ไม่พบกิจกรรม'; ?></h1>
            </div>
            <div class="card-body">
                <?php if (isset($event)) { ?>
                <form action="process_ticket.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                    <div class="mb-3">
                        <label for="user_email" class="form-label"><i class="fas fa-envelope"></i> Gmail:</label>
                        <input value="<?php echo $_SESSION['e_mail']; ?>" type="email" id="user_email" name="user_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label"><i class="fas fa-file-upload"></i> แนบรูปแสดงการโอนเงิน(อัปโหลดไฟล์ได้ไม่เกิน 4MB):</label>
                        <input type="file" id="payment_proof" name="payment_proof" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-ticket-alt"></i> ซื้อบัตร</button> | <a href="../_shop/" class="btn btn-secondary mt-3 w-100"><i class="fas fa-arrow-left"></i> กลับหน้าหลัก</a>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap 5 JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
  <div class="card-footer text-muted">
  © 2024 <?= $web_record['web_name']; ?> : Service 24 Hour Support <a href="https://myyoomi.carrd.co/">Create By MYYOOMI</a>
  </div>
</body>
</html>

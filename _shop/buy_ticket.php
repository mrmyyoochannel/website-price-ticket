<?php
session_start();
if(!isset($_SESSION['id'])) {
    header("location: ../login.php");
    exit;
}
include '../_system.site/_connect.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าคีย์ event_id มีอยู่ในอาร์เรย์ $_GET
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // ตรวจสอบว่าค่าของ event_id ไม่เป็นค่าว่าง
    if (!empty($event_id)) {
        // ใช้ prepared statement
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
        /* ทำให้ responsive */
        @media (max-width: 768px) {
            .container {
                margin-top: 20px;
                padding: 10px;
            }
            .card-header h1 {
                font-size: 1.5rem;
            }
            .card-body form label {
                font-size: 1rem;
            }
            .btn {
                width: 100%;
                margin-top: 10px;
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
                        <label for="user_email" class="form-label">Gmail:</label>
                        <input type="email" id="user_email" name="user_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">แนบรูปแสดงการโอนเงิน:</label>
                        <input type="file" id="payment_proof" name="payment_proof" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">ซื้อบัตร</button>
                </form>
                <?php } ?>
            </div>
            <a href="../_shop/" class="btn btn-secondary">กลับหน้าหลัก</a>
        </div>
    </div>
    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap 5 JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
      <div class="card-footer text-muted">
  © 2024 <?= $web_record['web_name']; ?> : Service 24 Hour Support
  </div>
</body>
</html>

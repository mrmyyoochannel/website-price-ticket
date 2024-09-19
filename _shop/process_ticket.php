<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit;
}
include '../_system.site/_connect.php';

$user_email = '';
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_email']) && isset($_FILES['payment_proof'])) {
        $user_email = $_POST['user_email'];
        $payment_proof = $_FILES['payment_proof'];

        if (!empty($user_email) && !empty($payment_proof['name'])) {
            // ตรวจสอบและอัปโหลดไฟล์รูปภาพ
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($payment_proof["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // ตรวจสอบว่าเป็นไฟล์รูปภาพจริงหรือไม่
            $check = getimagesize($payment_proof["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo 'File is not an image. <a href="buy_ticket.php?event_id=1">Buy Ticket</a>';
                $uploadOk = 0;
            }

            // ตรวจสอบขนาดไฟล์
            if ($payment_proof["size"] > 4000000) {
                echo 'Sorry, your file is too large. <a class="nav-link" href="buy_ticket.php?event_id=1">Buy Ticket</a>';
                $uploadOk = 0;
            }

            // อนุญาตเฉพาะไฟล์บางประเภท
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed. <a class="nav-link" href="buy_ticket.php?event_id=1">Buy Ticket</a>';
                $uploadOk = 0;
            }

            // ตรวจสอบว่า $uploadOk เป็น 0 หรือไม่
            if ($uploadOk == 0) {
                echo 'Sorry, your file was not uploaded. <a class="nav-link" href="buy_ticket.php?event_id=1">Buy Ticket</a>';
            // ถ้าทุกอย่างถูกต้อง, อัปโหลดไฟล์
            } else {
                if (move_uploaded_file($payment_proof["tmp_name"], $target_file)) {
                    // ใช้ prepared statement เพื่อป้องกัน SQL injection
                    $stmt = $conn->prepare("INSERT INTO tickets (user_email, event_id, payment_proof) VALUES (?, ?, ?)");
                    $stmt->bind_param("sis", $user_email, $_POST['event_id'], $target_file);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        echo 'The file ' . htmlspecialchars(basename($payment_proof["name"])) . ' has been uploaded. <a class="nav-link" href="buy_ticket.php?event_id=1">Buy Ticket</a>';
                        header('Location: '.$uri.'/php_home_page/_shop');
                    } else {
                        echo 'Error: ' . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo 'Sorry, there was an error uploading your file. <a class="nav-link" href="buy_ticket.php?event_id=1">Buy Ticket</a>';
                }
            }
        } else {
            echo 'User email or payment proof is empty. <a class="nav-link" href="buy_ticket.php?event_id=1">Buy Ticket</a>';
        }
    } else {
        echo 'User email or payment proof is not set. <a class="nav-link" href="buy_ticket.php?event_id=1">Buy Ticket</a>';
    }
}
?>

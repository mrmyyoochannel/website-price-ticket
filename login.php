<?php
include('_system.site/_connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // ป้องกัน SQL Injection
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT id, u_name, level, e_mail, user_img, p_word FROM user_profile WHERE e_mail = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $row['p_word'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['u_name'] = $row['u_name'];
            $_SESSION['level'] = $row['level'];
            $_SESSION['e_mail'] = $row['e_mail'];
            $_SESSION['user_img'] = $row["user_img"];

            header("location: ../php_home_page/");
            exit();
        } else {
            $error = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ | สโมสรนักศึกษา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        /* พื้นหลังไล่ระดับสี */
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* กล่องล็อกอิน */
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* ปุ่ม */
        .btn-custom {
            background-color: #007bff;
            color: white;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        /* ช่องใส่ข้อมูล */
        .form-control {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-container text-center">
                    <h2 class="mb-4">🔐 เข้าสู่ระบบ</h2>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">📧 อีเมล</label>
                            <input type="text" name="email" class="form-control" placeholder="กรอกอีเมล" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">🔑 รหัสผ่าน</label>
                            <input type="password" name="password" class="form-control" placeholder="กรอกรหัสผ่าน" required>
                        </div>
                        <button type="submit" class="btn btn-custom btn-block w-100">เข้าสู่ระบบ</button>
                    </form>
                    <hr>
                    <a href="register.php" class="text-decoration-none">📌 สมัครสมาชิก</a>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if(isset($error)) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: '<?php echo $error; ?>',
                confirmButtonColor: '#d33'
            });
        </script>
    <?php } ?>
</body>
</html>

<?php
$currentDirectory = getcwd();
$uploadDirectory = "/music/";

$errors = []; // จะเก็บข้อผิดพลาดที่นี่

$fileExtensionsAllowed = ['mp3']; // นามสกุลไฟล์ที่อนุญาตเท่านั้น

if (isset($_POST['submit'])) {
    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtensionArray = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtensionArray));

    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);

    // ตรวจสอบว่าโฟลเดอร์ปลายทางมีหรือไม่ และสร้างถ้าไม่มี
    if (!file_exists($currentDirectory . $uploadDirectory)) {
        mkdir($currentDirectory . $uploadDirectory, 0777, true);
    }

    if (!in_array($fileExtension, $fileExtensionsAllowed)) {
        $errors[] = "นามสกุลไฟล์นี้ไม่ได้รับอนุญาต โปรดอัปโหลดไฟล์ .mp3 เท่านั้น";
        echo "<script>alert('นามสกุลไฟล์ไม่ได้รับอนุญาต');</script>";
    }

    if ($fileSize > 1000000000) {  // 1 GB ในหน่วยไบต์
        $errors[] = "ไฟล์มีขนาดเกินขีดจำกัดสูงสุด (1 GB)";
        echo "<script>alert('ขนาดไฟล์เกินขีดจำกัดสูงสุด');</script>";
    }

    if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
            echo "<script>alert('อัปโหลดไฟล์เรียบร้อย!');</script>";
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์');</script>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<script>alert('ข้อผิดพลาด: $error');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Music Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        form {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 18px 32px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            margin: 5px 0;
        }

        a {
            text-decoration: none;
            color: #0066cc;
        }

        div {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .progress-container {
            width: 99%;
            background-color: #ddd;
            border-radius: 4px;
            margin-top: 10px;
        }

        .progress-bar {
            width: 0;
            height: 20px;
            background-color: #4caf50;
            text-align: center;
            line-height: 20px;
            color: #fff;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data" onsubmit="move()">
        <h2>Music Upload (MAX 1GB)</h2>
        <label for="fileToUpload">Choose a file:</label>
        <input type="file" name="the_file" id="fileToUpload">
        <input type="submit" name="submit" value="Upload">

        <div class="progress-container">
            <div class="progress-bar" id="myBar">0%</div>
        </div>
    </form>

    <script>
        // Simulate progress bar update (0-100%)
        function move() {
            var elem = document.getElementById("myBar");
            var width = 0;
            var id = setInterval(frame, 10);
            function frame() {
                if (width >= 100) {
                    clearInterval(id);
                } else {
                    width++;
                    elem.style.width = width + "%";
                    elem.innerHTML = width + "%";
                }
            }
        }
    </script>
</body>

</html>

<?php
    session_start();
    if(session_destroy()) {
        echo "Session destroyed successfully.";
    } else {
        echo "Failed to destroy session.";
    }
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
        session_start();
        session_destroy();
    ?>
    <script>
        let timerInterval;
        Swal.fire({
            icon: "success",
            title: "Logout successfully.",
            html: " <b></b> milliseconds.",
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                    timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                window.location.href = "../php_home_page/"; 
            }
        });
    </script>
</body>
</html>

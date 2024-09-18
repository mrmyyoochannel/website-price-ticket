<!DOCTYPE html>
<html lang="th">
<html>
<head>
<?php include_once('_system.site/_header.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

document.addEventListener('DOMContentLoaded', (event) => {
    if (!getCookie('acceptedTerms')) {
        (async () => {
            const { value: accept } = await Swal.fire({
                title: "กฎและกติกา",
                input: "checkbox",
                inputValue: 1,
                inputPlaceholder: "ยอมรับ <a href=\"#\">กฎและกติกา</a> ของการเข้าร่วมงาน !!!",
                confirmButtonText: "Continue <i class=\"fa fa-arrow-right\"></i>",
                inputValidator: (result) => {
                    return !result && "คุณต้องยอมรับกฎและกติกาการเข้าร่วมงาน !!!";
                }
            });
            if (accept) {
                setCookie('acceptedTerms', 'true', 1);
                Swal.fire("คุณได้ยอมรับกฎและกติกาของการเข้าร่วมงานแล้ว !!!");
            }
        })();
    }
});
</script>
<?php include_once('_system.site/_nav.php'); ?>
</head>
<body style="background-color:#F8F9FA;">
<?php
include_once("_system.site/_body.php");

if (isset($web_record) && $web_record['web_status'] != 1) {
    echo '<script>
    Swal.fire({
        icon: "warning",
        title: "เว็บยังไม่เปิด/กำลังปรับปรุง...",
        text: "ข้อมูลที่ท่านบันทึกข้อมูล อาจไม่ได้รับการบันทึกข้อมูล",
        footer: \'<a href="#">Why do I have this issue?</a>\'
    });
    </script>';
}
?>
  <div class="card-footer text-muted">
  © 2024 <?= $web_record['web_name']; ?> : Service 24 Hour Support
  </div>
</body>
</html>

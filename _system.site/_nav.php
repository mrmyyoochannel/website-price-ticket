<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']); 
?>

<nav class="navbar fixed-top navbar-dark bg-dark">
  <a class="navbar-brand" href="../php_home_page/">
    <img src="_img/<?= $web_record['web_logo']; ?>" width="30" height="30" class="d-inline-block align-top" alt="logo">
    <?= $web_record['web_name']; ?>
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../php_home_page/">หน้าหลัก</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?p=about">เกี่ยวกับ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?p=map">การเดินทาง</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?p=sponsor">เบื้องหลังและผู้สนับสนุน</a>
      </li>
      <?php
        if (isset($_SESSION['level']) && $_SESSION['level'] == 4) {
            echo'<li class="nav-item">
        <a class="nav-link" href="_admin.site/_admin.website.php">แก้ไขเซิฟเวอร์</a>
      </li>';
            echo'<li class="nav-item">
        <a class="nav-link" href="_admin.site/_admin.user.php">แก้ไขผู้ใช้งาน</a>
      </li>';
        }?>
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
          Login
        </a>
        <ul class="dropdown-menu bg-dark" aria-labelledby="navbarScrollingDropdown">
          <li><a style="color: #ffffff;" class="dropdown-item bg-dark" href="login.php">เข้าสู่ระบบ</a></li>
          <li><a style="color: #ffffff;" class="dropdown-item bg-dark" href="logout.php">ออกจากระบบ</a></li>
      <?php
        if (isset($_SESSION['level']) && $_SESSION['level'] == 4) {
            echo' <li><a style="color: #ffffff;" class="dropdown-item bg-dark" href="#">ลงทะเบียนผู้ขาย</a></li>';
        }?>
        </ul>
      </li>
    </ul>
    <form class="container-fluid justify-content-start">
      <button id="buyTicketButton" class="btn btn-outline-success me-2" type="button">ซื้อบัตร/ตรวจสอบบัตร</button>
    </form>
  </div>
</nav>

<?php 
if ($web_record['Sell_Status'] != 1) {
    echo '<script>
  document.getElementById("buyTicketButton").addEventListener("click", function() {
    let timerInterval;
    Swal.fire({
      icon: "warning",
      title: "ระบบยังไม่เปิดขายบัตร",
      html: "ตอนนี้ยังไม่ถึงเวลาเปิดขายบัตรใน <b></b> milliseconds.",
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
        console.log("ระบบยังไม่เปิดขายบัตร");
      }
    });
  });
</script>';
}
else { 
    echo '<script>
  document.getElementById("buyTicketButton").addEventListener("click", function() {
    let timerInterval;
    Swal.fire({
      icon: "success",
      title: "ขอบคุณที่ให้ความสนใจ",
      html: "ระบบกำลังพาคุณไปหน้าซื้อบัตรใน <b></b> milliseconds.",
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
        window.location.href = "_shop/"; // Replace with your next page URL
      }
    });
  });
</script>';
}
?>
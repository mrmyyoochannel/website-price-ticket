    <div class="card-header"></div>
  <div
    id="intro-example"
    class="p-5 text-center bg-image"
    style="background-image: url('_img/VRChat_2024-09-06_01-29-50.435_2560x1440.png');">
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.7);">
      <div class="d-flex justify-content-center align-items-center h-100">
        <div class="text-white">
          <h1 class="mb-3"><?= $web_record['web_name']; ?> </h1>
          <h5 class="mb-4">Welcome To <?= $web_record['web_name']; ?></h5>
        </div>
      </div>
    </div>
  </div>
      <div class="card-header"></div>
  <div class="card-group">
  <div class="card">
    <img class="card-img-top" src="_img/VRChat_2024-09-15_19-25-05.251_2560x1440.png" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">กิจกรรมภายในงาน</h5>
      <p class="card-text">กิจกรรมภายในงาน จะมีดังนี้ (Soon...)</p>
    </div>
  </div>
  <div class="card">
    <img class="card-img-top" src="_img/VRChat_2024-09-15_22-10-43.989_2560x1440.png" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">สถานที่จัดงาน</h5>
      <p class="card-text">ท่านสามารถ ดูวิธีการเดินทาง ได้ที่ <a href="?p=map">>วิธีการเดินทาง<</a></p>
    </div>
  </div>
  <div class="card">
    <img class="card-img-top" src="_img/VRChat_2024-09-06_01-29-50.435_2560x1440.png" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">ติดต่อสอบถาม</h5>
      <p class="card-text">ท่านสามารถ ติดต่อสอบถามได้ทาง Gmail: watikorn.tha@rmutp.ac.th</p>
    </div>
  </div>
</div>
<?php
if (isset($_SESSION['id'])) {
    echo '<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Loading Success ...",
        html: "Welcome ' . $_SESSION['u_name'] . '",
        showConfirmButton: false,
        timer: 1500
    });
    </script>';
}
?>
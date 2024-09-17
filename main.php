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
    <img class="card-img-top" src="_img/VRChat_2024-09-06_01-29-50.435_2560x1440.png" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
    </div>
  </div>
  <div class="card">
    <img class="card-img-top" src="_img/VRChat_2024-09-06_01-29-50.435_2560x1440.png" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
    </div>
  </div>
  <div class="card">
    <img class="card-img-top" src="_img/VRChat_2024-09-06_01-29-50.435_2560x1440.png" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
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
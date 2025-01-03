<?php
// Memulai sesi
session_start();
// Menyertakan script untuk fungsi database
include "module/Koneksi.php";
// Koneksi ke database restoran
$db = new Koneksi("localhost", "root", "", "restoran");
// Menyertakan script untuk mengatur sesi
include "module/session/session-login_register.php";

// Ketika tombol daftar ditekan
if (isset($_POST['signup'])) {
  // Mengambil data input dan koneksi ke database
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $namaLengkap = $_POST['nama'];
  $result = $db->fetchRow("SELECT username FROM users WHERE username = '$username'");

  // Validasi
  // Cek apakah username tersedia
  if ($result) {
    // Jika tidak tersedia, set variabel untuk memunculkan peringatan
    $signupError = true;
  } else {
    // Jika username tersedia, buat akun sesuai dengan yang telah diinputkan dan atur jenis akun menjadi pelanggan
    $db->query("INSERT INTO users VALUES ('', '$username', '$password', '$namaLengkap', 'pelanggan')");
    // Jika akun berhasil dibuat
    if ($db->affectedRows() > 0) {
      // Set variabel untuk memunculkan permberitahuan bahwa akun berhasil dibuat
      $signupSuccess = true;
    }
  }
}
?>

<!DOCTYPE html>
<!-- Atribut data-bs-theme digunakan untuk mengatur night/light mode -->
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <!-- Bootstrap -->
  <link
    rel="stylesheet"
    href="src/bootstrap-5.3.3-dist/css/bootstrap.min.css" />
  <!-- Icon -->
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <!-- Styling untuk mengubah checkbox menjadi switch mode dark & light -->
  <link rel="stylesheet" href="src/css/dark-light-mode.css" />
</head>

<body class="position-relative">
  <div class="container vh-100">
    <!-- Toggle Dark & Light Mode -->
    <div class="dark-light-toggle-wrapper">
      <input type="checkbox" class="dark-light-checkbox" id="darkLightcheckbox" />
      <label for="darkLightcheckbox" class="dark-light-checkbox-label bg-body-secondary">
        <i class="ph ph-moon me-2 text-body"></i>
        <i class="ph ph-sun text-body"></i>
        <span class="ball bg-body"></span>
      </label>
    </div>

    <!-- Login Form -->
    <div class="row h-100">
      <div class="col-9 col-sm-8 col-md-6 col-lg-5 col-xl-4 m-auto">

        <!-- Peringatan ketika input kosong atau username tidak tersedia -->
        <?php if (isset($signupError)): ?>
          <div class="alert alert-danger alert-dismissible fade show mt-3">
            <span>Username tidak tersedia</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif ?>

        <!-- Pemberitahuan jika akun berhasil dibuat -->
        <?php if (isset($signupSuccess)): ?>
          <div class="alert alert-success alert-dismissible fade show mt-3 text-center">
            <?= 'Akun telah berhasil dibuat!' ?> <br />
            <a href="login.php" class="alert-link">Balik ke halaman login</a>
          </div>
        <?php endif ?>

        <div class="bg-body-tertiary shadow p-4 rounded-4 text">
          <div class="fs-1 fw-bold text-center mb-4">SIGNUP</div>

          <form action="" method="post" id="userFormValidation" novalidate>
            <!-- Username field -->
            <div class="d-flex flex-column gap-3">
              <div>
                <label for="username" class="form-label">Username</label>
                <input
                  type="text"
                  id="username"
                  name="username"
                  class="form-control rounded-3 shadow"
                  placeholder="Username"
                  required />
                <div class="invalid-feedback">Username tidak boleh kosong!</div>
              </div>

              <!-- Nama lengkap field -->
              <div>
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input
                  type="text"
                  id="nama"
                  name="nama"
                  class="form-control rounded-3 shadow"
                  placeholder="Nama lengkap"
                  required />
                <div class="invalid-feedback">Nama tidak boleh kosong!</div>
              </div>

              <!-- Password field -->
              <div>
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control rounded-start-3 shadow pw"
                    placeholder="Password"
                    required />
                  <i class="ph ph-eye-slash input-group-text rounded-end-3 shadow show-pw"></i>
                  <div class="invalid-feedback">Password tidak boleh kosong!</div>
                </div>
              </div>

              <span>Sudah punya akun? <a href="login.php">Login</a></span>

              <!-- Tombol daftar -->
              <button type="submit" class="btn btn-primary align-self-center shadow" name="signup">
                Daftar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstsrap -->
  <script src="src/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
  <!-- Script untuk mode dark & light -->
  <script src="src/js/dark_light-mode.js"></script>
  <!-- Script untuk tombol sembunyikan & tampilkan password -->
  <script src="src/js/show-hide-pw.js"></script>
  <!-- Script untuk validasi form user -->
  <script src="src/js/validation-kelola_akun.js"></script>
</body>

</html>
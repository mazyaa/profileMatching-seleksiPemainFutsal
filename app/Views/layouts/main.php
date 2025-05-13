<?php
// File: app/Views/layouts/main.php
use CodeIgniter\I18n\Time;
$loggedIn = session()->get('logged_in');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? $title : 'SPK Futsal' ?></title>

  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .sidebar {
      height: 100vh;
      background: #343a40;
      color: white;
      padding: 1rem;
      position: fixed;
      width: 200px;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 0.5rem 0;
      text-decoration: none;
    }
    .sidebar a:hover {
      background: #495057;
      border-radius: 5px;
    }
    .content-area {
      margin-left: 200px;
      padding: 2rem;
    }
    .footer {
      text-align: center;
      padding: 1rem;
      background: #f8f9fa;
      color: #6c757d;
      font-size: 14px;
      margin-top: auto;
    }
    @media(max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
      }
      .content-area {
        margin-left: 0;
      }
    }
  </style>
</head>
<body data-aos="fade-in">

<?php if ($loggedIn): ?>
  <div class="sidebar">
    <h5>SPK Futsal</h5>
    <a href="<?= site_url('dashboard') ?>">Dashboard</a>
    <a href="<?= site_url('pemain') ?>">Data Pemain</a>
    <a href="<?= site_url('kriteria') ?>">Kriteria</a>
    <a href="<?= site_url('penilaian') ?>">Penilaian</a>
    <a href="#" id="logout">Logout</a>
  </div>
  <div class="content-area">
    <?= $this->renderSection('content') ?>
  </div>
<?php else: ?>
  <div class="container mt-5">
    <?= $this->renderSection('content') ?>
  </div>
<?php endif; ?>

<!-- Footer -->
<footer class="footer">
  &copy; <?= Time::now()->getYear() ?> SPK Futsal. Developed with ❤️ by <a href="https://github.com/mazyaa" target="_blank">Mazyaa</a>.
</footer>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>

<script>
$(document).ready(function() {
  $('#logout').on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: '/logout',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        Swal.fire({
          icon: 'success',
          title: 'Logout Berhasil',
          text: response.message || 'Anda telah keluar.'
        }).then(() => {
          window.location.href = '/login';
        });
      },
      error: function(xhr) {
        Swal.fire({
          icon: 'error',
          title: 'Logout Gagal',
          text: xhr.responseJSON?.message || 'Terjadi kesalahan pada server.'
        });
      }
    });
  });
});
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
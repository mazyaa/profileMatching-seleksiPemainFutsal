<?php
// File: app/Views/layouts/main.php
use CodeIgniter\I18n\Time;

$loggedIn = session()->get('isLoggedIn') ?? false;
$userRole = session()->get('role');
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? $title : 'SPK Futsal' ?></title>

  <!-- Fonts & CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    .sidebar {
      background: #343a40;
      color: white;
      padding: 1rem;
      display: flex;
      flex-direction: column;
      width: 300px;
      transition: transform 0.3s ease;
      transform: translateX(0);
    }

    .sidebar a {
      color: white;
      display: block;
      padding: 0.5rem 0;
      text-decoration: none;
    }

    .sidebar a i {
      width: 20px;
    }

    .sidebar a:hover {
      background: #495057;
      border-radius: 5px;
      padding-left: 12px;
    }

    .sidebar.hide {
      transform: translateX(-100%);
    }

    .content-area {
      padding: 1rem;
      width: 100%;
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .content-area {
        margin-left: 0;
      }

      .navbar-toggler {
        z-index: 1100;
      }
    }

    .footer {
      text-align: center;
      padding: 1rem;
      background: #f8f9fa;
      color: #6c757d;
      font-size: 14px;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  </style>
</head>

<body data-aos="fade-in" class="d-flex flex-column min-vh-100">

  <?php if ($loggedIn): ?>
    <!-- Toggle button for mobile -->
    <nav class="navbar bg-dark d-md-none p-2">
      <button class="btn btn-outline-light" id="sidebarToggle">
        <i class="bi bi-list"></i>
      </button>
    </nav>

    <div class="d-flex flex-grow-1">
      <!-- Sidebar -->
      <div class="sidebar" id="sidebar">
        <?php if ($userRole == 'admin'): ?>
          <h5><i class="bi bi-controller"></i> SPK Futsal</h5>
          <a href="<?= site_url('dashboard') ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
          <a href="<?= site_url('pelatih') ?>"><i class="bi bi-person-badge me-2"></i>Data Pelatih</a>
          <a href="<?= site_url('pelatih/create') ?>"><i class="bi bi-person-plus me-2"></i>Tambah Pelatih</a>
          <a id="logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
        <?php endif; ?>

        <!-- Sidebar untuk Pelatih -->
        <?php if ($userRole == 'pelatih'): ?>
          <a href="<?= base_url('/pelatih/dashboard') ?>">
            <h5><i class="bi bi-controller"></i> SPK Futsal</h5>
          </a>
          <a href="<?= base_url('pelatih/kriteria') ?>"><i class="bi bi-list-check me-2"></i>Kriteria</a>
          <a href="<?= base_url('pelatih/pemain') ?>"><i class="bi bi-person-plus me-2"></i>Input Data Pemain</a>
          <a href="<?= base_url('pelatih/getPemain') ?>"><i class="bi bi-people me-2"></i>Data Pemain</a>
          <a href="<?= base_url('pelatih/pagePenilaian') ?>"><i class="bi bi-star me-2"></i>Penilaian</a>
          <a href="<?= base_url('pelatih/hasilSeleksi') ?>"><i class="bi bi-clipboard-data me-2"></i>Hasil Penilaian</a>
          <a href="<?= base_url('pemain/lolos') ?>"><i class="bi bi-check-circle me-2"></i>Pemain Lolos</a>
          <a href="<?= base_url('pemain/tidaklolos') ?>"><i class="bi bi-x-circle me-2"></i>Pemain Tidak Lolos</a>
          <a id="logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
        <?php endif; ?>
      </div>

      <!-- Main Content -->
      <div class="content-area flex-grow-1">
        <?= $this->renderSection('content') ?>
      </div>
    </div>
  <?php else: ?>
    <div class="container mt-5 flex-grow-1">
      <?= $this->renderSection('content') ?>
    </div>
  <?php endif; ?>

  <!-- Footer -->
  <footer class="footer mt-auto">
    &copy; <?= Time::now()->getYear() ?> SPK Futsal. Developed with ❤️ by <a href="https://github.com/mazyaa" target="_blank">Mazyaa</a>.
  </footer>

  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    AOS.init();

    $(document).ready(function() {
      $('#logout').on('click', function(e) {
        e.preventDefault();
        $.ajax({
          url: '/auth/logout',
          type: 'POST',
          dataType: 'json',
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'Logout Berhasil',
              text: response.message || 'Anda telah keluar.'
            }).then(() => {
              window.location.href = '/';
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

      // Sidebar toggle
      const toggleBtn = document.getElementById('sidebarToggle');
      const sidebar = document.getElementById('sidebar');

      // Add close button to sidebar for mobile
      if (sidebar && window.innerWidth <= 768) {
        const closeBtn = document.createElement('button');
        closeBtn.className = 'btn btn-outline-light mb-3 d-md-none';
        closeBtn.id = 'sidebarClose';
        closeBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
        sidebar.insertBefore(closeBtn, sidebar.firstChild);

        closeBtn.addEventListener('click', function() {
          sidebar.classList.remove('show');
        });
      }

      if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
          sidebar.classList.toggle('show');
        });
      }
    });
  </script>

  <?= $this->renderSection('scripts') ?>
</body>

</html>
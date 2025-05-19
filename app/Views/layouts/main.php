<?php
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
      background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%);
    }

    .sidebar {
      background: linear-gradient(135deg, #212529 60%, #0d6efd 100%);
      color: white;
      padding: 1.5rem 1rem 1rem 1rem;
      display: flex;
      flex-direction: column;
      width: 270px;
      min-height: 100vh;
      box-shadow: 2px 0 16px rgba(0,0,0,0.08);
      transition: transform 0.3s cubic-bezier(.4,2,.6,1), box-shadow 0.2s;
      z-index: 1050;
      position: relative;
    }

    .sidebar .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 2rem;
      font-size: 1.5rem;
      font-weight: 600;
      letter-spacing: 1px;
      color: #fff;
      text-shadow: 0 2px 8px #0d6efd55;
    }

    .sidebar a {
      color: #f8fafc;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0.65rem 0.75rem;
      margin-bottom: 0.3rem;
      cursor: pointer;
      border-radius: 8px;
      font-size: 1.08rem;
      font-weight: 500;
      text-decoration: none;
      position: relative;
      transition: background 0.18s, color 0.18s, transform 0.12s;
      overflow: hidden;
    }

    .sidebar a:hover, .sidebar a.active {
      background: rgba(13,110,253,0.18);
      color: #ffd700;
      transform: translateX(4px) scale(1.03);
      box-shadow: 0 2px 8px #0d6efd22;
    }

    .sidebar a .bi {
      font-size: 1.3rem;
      transition: color 0.2s;
    }

    .sidebar a .badge {
      margin-left: auto;
      font-size: 0.8rem;
      background: #ffc107;
      color: #212529;
    }

    .sidebar.hide {
      transform: translateX(-100%);
    }

    .content-area {
      padding: 2rem 2.5rem 1rem 2.5rem;
      width: 100%;
      background: transparent;
      min-height: 100vh;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        transform: translateX(-100%);
        box-shadow: 2px 0 16px rgba(0,0,0,0.18);
      }
      .sidebar.show {
        transform: translateX(0);
      }
      .content-area {
        margin-left: 0;
        padding: 1rem 0.5rem;
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
      font-size: 15px;
      letter-spacing: 0.5px;
      box-shadow: 0 -2px 12px #0d6efd11;
    }

    .footer .bi {
      color: #0d6efd;
      margin-right: 6px;
    }

    /* Ripple effect for buttons */
    .btn-ripple {
      position: relative;
      overflow: hidden;
    }
    .btn-ripple:after {
      content: "";
      display: block;
      position: absolute;
      border-radius: 50%;
      pointer-events: none;
      width: 100px;
      height: 100px;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) scale(0);
      background: rgba(13,110,253,0.18);
      transition: transform 0.4s, opacity 0.6s;
      opacity: 0;
    }
    .btn-ripple:active:after {
      transform: translate(-50%, -50%) scale(1.5);
      opacity: 1;
      transition: 0s;
    }
  </style>
</head>

<body data-aos="fade-in" class="d-flex flex-column min-vh-100">

  <?php if ($loggedIn): ?>
    <!-- Toggle button for mobile -->
    <nav class="navbar bg-dark d-md-none p-2 shadow-sm">
      <button class="btn btn-outline-light btn-ripple" id="sidebarToggle">
        <i class="bi bi-list fs-3"></i>
      </button>
      <span class="ms-3 text-light fw-semibold"><i class="bi bi-controller"></i> SPK Futsal</span>
    </nav>

    <?php
      $segment = service('request')->getUri()->getSegment(2);
    ?>
    <div class="d-flex flex-grow-1">
      <!-- Sidebar -->
      <div class="sidebar" id="sidebar">
      <div class="sidebar-logo">
        <i class="bi bi-joystick fs-2 text-warning"></i>
        <span>SPK Futsal</span>
      </div>
      <?php if ($userRole == 'pelatih'): ?>
        <a href="<?= base_url('/pelatih/dashboard') ?>" class="<?= $segment == 'dashboard' ? 'active' : '' ?>">
        <i class="bi bi-house-door-fill text-info"></i> Dashboard
        </a>
        <a href="<?= base_url('pelatih/kriteria') ?>" class="<?= $segment == 'kriteria' ? 'active' : '' ?>">
        <i class="bi bi-list-check text-success"></i> Kriteria
        </a>
        <a href="<?= base_url('pelatih/pemain') ?>" class="<?= $segment == 'pemain' ? 'active' : '' ?>">
        <i class="bi bi-person-plus-fill text-primary"></i> Input Data Pemain
        </a>
        <a href="<?= base_url('pelatih/getPemain') ?>" class="<?= $segment == 'getPemain' ? 'active' : '' ?>">
        <i class="bi bi-people-fill text-warning"></i> Data Pemain
        </a>
        <a href="<?= base_url('pelatih/pagePenilaian') ?>" class="<?= $segment == 'pagePenilaian' ? 'active' : '' ?>">
        <i class="bi bi-star-fill text-danger"></i> Penilaian
        </a>
        <a href="<?= base_url('pelatih/hasilSeleksi') ?>" class="<?= $segment == 'hasilSeleksi' ? 'active' : '' ?>">
        <i class="bi bi-clipboard-data-fill text-secondary"></i> Hasil Penilaian
        </a>
        <a href="<?= base_url('pelatih/pemainLolos') ?>" class="<?= $segment == 'pemainLolos' ? 'active' : '' ?>">
        <i class="bi bi-check-circle-fill text-success"></i> Pemain Lolos
        </a>
        <a href="<?= base_url('pelatih/pemainTidakLolos') ?>" class="<?= $segment == 'pemainTidakLolos' ? 'active' : '' ?>">
        <i class="bi bi-x-circle-fill text-danger"></i> Pemain Tidak Lolos
        </a>
        <a id="logout" class="mt-3">
        <i class="bi bi-box-arrow-right text-light"></i> Logout
        </a>
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
    <i class="bi bi-cup-hot-fill"></i>
    &copy; <?= Time::now()->getYear() ?> SPK Futsal. Developed with <i class="bi bi-heart-fill text-danger"></i> by
    <a href="https://github.com/mazyaa" target="_blank" class="text-decoration-none fw-semibold">Mazyaa</a>.
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
        closeBtn.className = 'btn btn-outline-light mb-3 d-md-none btn-ripple';
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
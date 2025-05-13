<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-center align-items-center vh-100" data-aos="zoom-in">
  <div class="card shadow-lg p-4" style="min-width: 350px;">
    <h3 class="text-center mb-4">Login</h3>
    <form id="formLogin">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
        </div>
        <div class="d-grid">
            <button type="submit" id="btnSubmit" class="btn btn-primary">Login</button>
        </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#formLogin').submit(function(e) {
        e.preventDefault();
        let username = $('#username').val();
        let password = $('#password').val();

        let data = {
            username: String(username ?? ''),
            password: String(password ?? '')
        };

        $.ajax({
            url: '/auth/login', // pastikan route ini benar
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(response) {
                if (response.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        if (response.role === 'admin') {
                            window.location.href = '/admin/dashboard';
                        } else if (response.role === 'pelatih') {
                            window.location.href = '/pelatih/dashboard';
                        } else {
                            window.location.href = '/';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan.'
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>

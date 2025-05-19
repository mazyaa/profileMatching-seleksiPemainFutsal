<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-center align-items-center vh-100 bg-light" data-aos="zoom-in">
    <div class="card shadow-lg p-4 border-0" style="min-width: 370px; border-radius: 18px;">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger text-center">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <div class="text-center mb-4">
            <h3 class="fw-bold">Login</h3>
            <p class="text-muted small">Masuk ke akun Anda untuk melanjutkan</p>
        </div>
        <form id="formLogin" autocomplete="off">
            <div class="mb-3 position-relative">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username" required autofocus>
                </div>
                <div class="invalid-feedback" id="usernameError"></div>
            </div>
            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="bi bi-eye"></i></button>
                </div>
                <div class="invalid-feedback" id="passwordError"></div>
            </div>
            <div class="d-grid mb-2">
                <button type="submit" id="btnSubmit" class="btn btn-primary fw-bold">
                    <span id="btnText">Login</span>
                    <span id="btnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Toggle password visibility
        $('#togglePassword').on('click', function() {
            const passwordInput = $('#password');
            const icon = $(this).find('i');
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });

        // Real-time validation
        $('#username, #password').on('input', function() {
            $(this).removeClass('is-invalid');
            $('#' + this.id + 'Error').text('');
        });

        $('#formLogin').submit(function(e) {
            e.preventDefault();
            let username = $('#username').val().trim();
            let password = $('#password').val().trim();
            let valid = true;

            if (!username) {
                $('#username').addClass('is-invalid');
                $('#usernameError').text('Username wajib diisi.');
                valid = false;
            }
            if (!password) {
                $('#password').addClass('is-invalid');
                $('#passwordError').text('Password wajib diisi.');
                valid = false;
            }
            if (!valid) return;

            $('#btnSubmit').attr('disabled', true);
            $('#btnText').addClass('d-none');
            $('#btnSpinner').removeClass('d-none');

            let data = {
                username: String(username ?? ''),
                password: String(password ?? '')
            };

            $.ajax({
                url: '/auth/login',
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function(response) {
                    $('#btnSubmit').attr('disabled', false);
                    $('#btnText').removeClass('d-none');
                    $('#btnSpinner').addClass('d-none');
                    if (response.status == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 1000,
                            showConfirmButton: false
                        }).then(() => {
                            if (response.role === 'pelatih') {
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
                    $('#btnSubmit').attr('disabled', false);
                    $('#btnText').removeClass('d-none');
                    $('#btnSpinner').addClass('d-none');
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
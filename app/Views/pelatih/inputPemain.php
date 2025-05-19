<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient bg-primary text-white text-center position-relative">
                    <i class="bi bi-person-plus-fill fs-2 position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                    <h4 class="fw-bold mb-0">Input Data Pemain</h4>
                </div>
                <div class="card-body p-4">
                    <form id="formPemain" autocomplete="off">
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">
                                <i class="bi bi-person-fill me-2 text-primary"></i>Nama
                            </label>
                            <input type="text" class="form-control" id="nama" name="nama" maxlength="100" required placeholder="Masukkan nama pemain">
                        </div>
                        <div class="mb-3">
                            <label for="tinggi_badan" class="form-label fw-semibold">
                                <i class="bi bi-arrows-vertical me-2 text-success"></i>Tinggi Badan (cm)
                            </label>
                            <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" maxlength="50" required min="100" max="250" placeholder="Contoh: 170">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt-fill me-2 text-danger"></i>Alamat
                            </label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required placeholder="Masukkan alamat lengkap"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label fw-semibold">
                                <i class="bi bi-telephone-fill me-2 text-warning"></i>No HP
                            </label>
                            <input type="tel" class="form-control" id="no_hp" name="no_hp" maxlength="20" required pattern="^08[0-9]{8,}$" placeholder="Contoh: 081234567890">
                        </div>
                        <button type="submit" id="kirimData" class="btn btn-primary w-100 fw-bold d-flex align-items-center justify-content-center gap-2">
                            <span id="btnText"><i class="bi bi-save2-fill me-1"></i>Simpan</span>
                            <span id="btnLoading" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>


<script>
    $(document).ready(function() {
        // Real-time validation
        $('#formPemain input, #formPemain textarea').on('input', function() {
            if (this.checkValidity()) {
                $(this).removeClass('is-invalid');
            }
        });

        $('#formPemain').on('submit', function(e) {
            e.preventDefault();

            let valid = true;
            $('#formPemain input, #formPemain textarea').each(function() {
                if (!this.checkValidity()) {
                    $(this).addClass('is-invalid');
                    valid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            if (!valid) return;

            $('#btnText').addClass('d-none');
            $('#btnLoading').removeClass('d-none');
            $('#kirimData').prop('disabled', true);

            let data = {
                nama: String($('#nama').val() ?? ''),
                tinggi_badan: String($('#tinggi_badan').val() ?? ''),
                alamat: String($('#alamat').val() ?? ''),
                no_hp: String($('#no_hp').val() ?? '')
            };

            $.ajax({
                url: '/pelatih/inputPemain',
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function(response) {
                    $('#btnText').removeClass('d-none');
                    $('#btnLoading').addClass('d-none');
                    $('#kirimData').prop('disabled', false);

                    if (response.status == 201) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 1200,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '/pelatih/getPemain';
                        });
                        $('#formPemain')[0].reset();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    $('#btnText').removeClass('d-none');
                    $('#btnLoading').addClass('d-none');
                    $('#kirimData').prop('disabled', false);

                    if (xhr.status == 422) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Semua field harus diisi'
                        });
                    } else if (xhr.status == 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan pada server.'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan pada server.'
                        });
                    }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
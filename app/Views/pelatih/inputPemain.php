<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h4 class="text-center my-4 fw-bold">Input Data Pemain</h4>
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" maxlength="100" required>
    </div>
    <div class="mb-3">
        <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
        <input type="text" class="form-control" id="tinggi_badan" name="tinggi_badan" maxlength="50" required>
    </div>
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label for="no_hp" class="form-label">No HP</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" maxlength="20" required>
    </div>
    <button type="submit" id="kirimData" class="btn btn-primary">Simpan</button>
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {


        $('#kirimData').on('click', function(e) {
            e.preventDefault();

            let nama = $('#nama').val();
            let tinggi_badan = $('#tinggi_badan').val();
            let alamat = $('#alamat').val();
            let no_hp = $('#no_hp').val();

            let data = {
                nama: String(nama ?? ''),
                tinggi_badan: String(tinggi_badan ?? ''),
                alamat: String(alamat ?? ''),
                no_hp: String(no_hp ?? '')
            };

            $.ajax({
                url: '/pelatih/inputPemain',
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function(response) {
                    if (response.status == 201) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 1000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '/pelatih/getPemain';
                        });
                        $('#nama').val('');
                        $('#tinggi_badan').val('');
                        $('#alamat').val('');
                        $('#no_hp').val('');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
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
                            text: xhr.responseJSON.message || 'Terjadi kesalahan pada server.'
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
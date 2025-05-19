<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-clipboard2-check text-primary"></i> Penilaian Pemain</h2>
    </div>
    <div class="card shadow-lg border-0 rounded-4 p-4 mx-auto" style="max-width: 600px;">
        <div class="mb-4">
            <label for="pemain" class="form-label fw-bold">
                <i class="bi bi-person-badge-fill text-success"></i> Pemain
            </label>
            <select id="pemain" name="pemain" class="form-select">
                <option value="">Pilih Pemain</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="stamina" class="form-label fw-bold">
                <i class="bi bi-battery-full text-warning"></i> Stamina - Core (C1)
            </label>
            <select id="stamina" name="stamina" class="form-select">
                <option value="">Pilih Stamina</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</i></option>
            </select>
        </div>
        <div class="mb-4">
            <label for="kecepatan" class="form-label fw-bold">
                <i class="bi bi-lightning-charge-fill text-danger"></i> Kecepatan - Core (C2)
            </label>
            <select id="kecepatan" name="kecepatan" class="form-select">
                <option value="">Pilih Kecepatan</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</i></option>
            </select>
        </div>
        <div class="mb-4">
            <label for="kekuatan" class="form-label fw-bold">
                <i class="bi bi-bar-chart-fill text-info"></i> Kekuatan - Secondary (C3)
            </label>
            <select id="kekuatan" name="kekuatan" class="form-select">
                <option value="">Pilih Kekuatan</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</i></option>
            </select>
        </div>
        <div class="mb-4">
            <label for="kerja_sama" class="form-label fw-bold">
                <i class="bi bi-people-fill text-secondary"></i> Kerjasama - Secondary (C4)
            </label>
            <select id="kerja_sama" name="kerja_sama" class="form-select">
                <option value="">Pilih Kerjasama</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</i></option>
            </select>
        </div>
        <div class="mb-4">
            <label for="pengalaman" class="form-label fw-bold">
                <i class="bi bi-award-fill text-warning"></i> Pengalaman - Secondary (C5)
            </label>
            <select id="pengalaman" name="pengalaman" class="form-select">
                <option value="">Pilih Pengalaman</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</i></option>
            </select>
        </div>
        <div class="d-grid">
            <button type="button" class="btn btn-primary btn-lg fw-bold" id="btnHitung">
                <i class="bi bi-save2"></i> Simpan Data
            </button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {

        function getPemainAfterInput(pemain) {
            return `<option value="${pemain.id}"><i class="bi bi-person-circle"></i> ${pemain.nama}</option>`;
        }

        function pemainNotFound() {
            return `<option value="">Pemain tidak ditemukan</option>`;
        }

        $.ajax({
            url: '/pelatih/fetchPemain',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status == 200) {
                    let pemain = res.data;
                    pemain.forEach(function(item){
                        $('#pemain').append(getPemainAfterInput(item));
                    });
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status == 404) {
                    $('#pemain').append(pemainNotFound());
                } else {
                    console.error('Error fetching data:', error);
                }
            }
        });

        $('#btnHitung').on('click', function() {
            let id_pemain = $('#pemain').val();
            let stamina = $('#stamina').val();
            let kecepatan = $('#kecepatan').val();
            let kekuatan = $('#kekuatan').val();
            let kerja_sama = $('#kerja_sama').val();
            let pengalaman = $('#pengalaman').val();

            // Validasi sederhana
            if (!id_pemain || !stamina || !kecepatan || !kekuatan || !kerja_sama || !pengalaman) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Semua kolom harus diisi!',
                });
                return;
            }

            $.ajax({
                url: '/pelatih/penilaian',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    id_pemain: id_pemain,
                    stamina: stamina,
                    kecepatan: kecepatan,
                    kekuatan: kekuatan,
                    kerja_sama: kerja_sama,
                    pengalaman: pengalaman
                }),
                success: function(res) {
                    if (res.status == 201) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = '/pelatih/hasilSeleksi';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status == 422) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server',
                        });
                    }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
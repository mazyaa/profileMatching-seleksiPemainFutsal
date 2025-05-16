<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Data Pemain</h2>
    <div class="table-responsive">
        <table class="text-center table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tinggi Badan</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="pemainTableBody">
                <!-- Data Pemain akan dimuat di sini -->
            </tbody>
        </table>
    </div>
    <div class="container mt-4">
        <button class="btn btn-primary"><a class="text-white text-decoration-none" href="<?= base_url('/pelatih/pagePenilaian') ?>">Nilai Pemain</a></button>
    </div>
</div>

    <?= $this->endSection() ?>


    <?= $this->section('scripts') ?>


    <script>
        $(document).ready(function() {
            function getPemain(pemain) {
                return `
                <tr>
                    <td>${pemain.id}</td>
                    <td>${pemain.nama}</td>
                    <td>${pemain.tinggi_badan}</td>
                    <td>${pemain.alamat}</td>
                    <td>${pemain.no_hp}</td>
                    <td>
                        <a href="/pelatih/pemain/edit/${pemain.id}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="deletePemain(${pemain.id})">Delete</button>
                    </td>
                </tr>
                `;
            }

            function pemainNotFound() {
                return `
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data pemain ditemukan</td>
                </tr>
                `;
            }

            $.ajax({
                url: '/pelatih/fetchPemain',
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        let pemainRows = '';
                        res.data.forEach(pemain => {
                            pemainRows += getPemain(pemain);
                        });
                        $('#pemainTableBody').html(pemainRows);
                    }
                },
                error: function(xhr, status, error) {
                   if (xhr.status == 404) {
                        let notFoundRow = pemainNotFound();
                        $('#pemainTableBody').html(notFoundRow);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server'
                        });
                    }
                }
            });
        });
    </script>

    <?= $this->endSection() ?>
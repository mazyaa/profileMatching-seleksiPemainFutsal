<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex align-items-center mb-3">
        <i class="bi bi-bar-chart-steps display-5 text-primary me-2"></i>
        <h2 class="mb-0 fw-bold">Hasil Penilaian</h2>
    </div>
    <h4 class="text-center my-4 fw-bold">
        <i class="bi bi-table"></i> Tabel Hasil Input Kriteria
    </h4>
    <div class="table-responsive shadow rounded-4 mb-4">
        <table class="text-center table table-striped table-hover align-middle">
            <thead class="table-primary" id="fetchKriteria">
            </thead>
            <tbody id="hasilTableBody">
            </tbody>
        </table>
        <hr class="mt-4 mb-4 border border-2 opacity-50">
    </div>
    <div class="container mt-4 text-center">
        <button id="btn-hitung" class="btn btn-lg btn-gradient-primary mb-4 shadow">
            <i class="bi bi-calculator-fill me-2"></i>Hitung & Lihat Hasil
        </button>
    </div>
    <div class="table-responsive mt-4 shadow rounded-4">
        <table class="text-center table table-striped table-hover align-middle">
            <thead class="table-success">
                <tr>
                    <th><i class="bi bi-trophy-fill text-warning"></i> Ranking</th>
                    <th><i class="bi bi-person-fill"></i> Nama</th>
                    <th><i class="bi bi-activity"></i> NCF</th>
                    <th><i class="bi bi-lightning-fill"></i> NSF</th>
                    <th><i class="bi bi-award-fill"></i> Nilai Akhir</th>
                    <th><i class="bi bi-check2-circle"></i> Minimal Nilai</th>
                    <th><i class="bi bi-patch-check-fill"></i> Status</th>
                </tr>
            </thead>
            <tbody id="ranking-body">
            </tbody>
        </table>
    </div>
    <div class="container d-flex align-items-center flex-column">
        <h4 class="my-5 fw-bold">
            <i class="bi bi-list-ol"></i> Detail Perhitungan (Step-by-Step)
        </h4>
        <div class="accordion w-100" id="accordionDetail"></div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
    .btn-gradient-primary {
        background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%);
        color: #fff;
        border: none;
    }
    .btn-gradient-primary:hover {
        background: linear-gradient(90deg, #8f94fb 0%, #4e54c8 100%);
        color: #fff;
    }
    .table thead th {
        vertical-align: middle;
    }
    .badge-status {
        font-size: 1rem;
        padding: 0.5em 1em;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize num outside the function so it can be incremented
        let num = 1;
        function getHasilPenilaianAwal(hasil) {
            return `
            <tr>
                <td>${num++}</td>
                <td>${hasil.nama}</td>
                <td>${hasil.stamina}</td>
                <td>${hasil.kecepatan}</td>
                <td>${hasil.kekuatan}</td>
                <td>${hasil.kerja_sama}</td>
                <td>${hasil.pengalaman}</td>
                <td><span class="badge bg-info"><i class="bi bi-star-fill"></i> 5</span></td>
            </tr>
            `;
        }

        function hasilNotFound() {
            return `
            <tr>
                <td colspan="8" class="text-center text-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i> Tidak ada data hasil ditemukan
                </td>
            </tr>
            `;
        }

        $.ajax({
            url: '/pelatih/kriteria/fetch',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    let fetchKriteria = $('#fetchKriteria');
                    let kriteria = response.data;

                    fetchKriteria.append(`
                        <tr>
                            <th><i class="bi bi-hash"></i>No</th>
                            <th><i class="bi bi-person-circle"></i>Nama Pemain</th>
                            <th><i class="bi bi-heart-pulse"></i> ${kriteria[0].kode}</th>
                            <th><i class="bi bi-wind"></i>${kriteria[1].kode}</th>
                            <th><i class="bi bi-person-arms-up"></i> ${kriteria[2].kode}</th>
                            <th><i class="bi bi-people-fill"></i> ${kriteria[3].kode}</th>
                            <th><i class="bi bi-clock-history"></i> ${kriteria[4].kode}</th>
                            <th><i class="bi bi-star-fill"></i> Nilai Ideal</th>
                        </tr>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });

        $.ajax({
            url: '/pelatih/getHasilSeleksi',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    let hasilTableBody = $('#hasilTableBody');
                    let hasil = response.data;

                    hasil.forEach(hasil => {
                        hasilTableBody.append(getHasilPenilaianAwal(hasil));
                    });
                }
            },
            error: function(xhr, status, error) {
                let hasilTableBody = $('#hasilTableBody');
                hasilTableBody.empty();

                if (xhr.status == 404) {
                    hasilTableBody.append(hasilNotFound());
                } else {
                    console.error('Error fetching data:', error);
                }
            }
        });

        // Function to display the ranking results
        function tampilkanHasil(data) {
            const tbody = $('#ranking-body');
            const accordion = $('#accordionDetail');

            $.each(data, function(index, pemain) {
                let statusIcon = pemain.status === 'lolos'
                    ? '<i class="bi bi-patch-check-fill"></i>'
                    : '<i class="bi bi-x-octagon-fill"></i>';
                let badgeClass = pemain.status === 'lolos' ? 'bg-success' : 'bg-danger';

                tbody.append(`
                <tr>
                    <td><span class="fw-bold text-warning"><i class="bi bi-trophy-fill"></i> ${pemain.ranking}</span></td>
                    <td><i class="bi bi-person-fill"></i> ${pemain.nama}</td>
                    <td><span class="text-primary"><i class="bi bi-activity"></i> ${pemain.nilai_cf}</span></td>
                    <td><span class="text-info"><i class="bi bi-lightning-fill"></i> ${pemain.nilai_sf}</span></td>
                    <td><span class="fw-bold"><i class="bi bi-award-fill"></i> ${pemain.nilai_akhir}</span></td>
                    <td><span class="badge bg-info"><i class="bi bi-check2-circle"></i> 3</span></td>
                    <td><span class="badge badge-status ${badgeClass}">${statusIcon} ${pemain.status}</span></td>
                </tr>
            `);
                accordion.append(`
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading${index}">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="false" aria-controls="collapse${index}">
                <i class="bi bi-person-badge-fill me-2"></i> ${pemain.ranking}. ${pemain.nama}
              </button>
            </h2>
            <div id="collapse${index}" class="accordion-collapse collapse" aria-labelledby="heading${index}" data-bs-parent="#accordionDetail">
              <div class="accordion-body">
                <table class="table table-bordered mb-3">
                    <tbody>
                        <tr>
                            <th><i class="bi bi-clipboard-data"></i> Nilai Asli</th>
                            <td>${convertObj(pemain.nilai_asli)}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-arrow-left-right"></i> Penentuan Nilai GAP</th>
                            <td>${convertObj(pemain.gap)}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-sliders"></i> Nilai Bobot</th>
                            <td>${convertObj(pemain.bobot_gap)}</td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-activity"></i> Perhitungan NCF</th>
                            <td>(B1 + B2 + B3) / 3 = <strong>${pemain.nilai_cf}</strong></td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-lightning-fill"></i> Perhitungan NSF</th>
                            <td>(B1 + B2) / 2 = <strong>${pemain.nilai_sf}</strong></td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-award-fill"></i> Nilai Akhir</th>
                            <td>(60% * NCF) + (40% * NSF) = <strong>${pemain.nilai_akhir}</strong></td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-patch-check-fill"></i> Status</th>
                            <td><span class="badge ${badgeClass}">${pemain.status}</span></td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-trophy-fill"></i> Ranking</th>
                            <td>${pemain.ranking}</td>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        `);
            });
        }

        // Function to convert object to string
        function convertObj(obj) {
            let headers = Object.keys(obj).map(k => `<th>${k}</th>`).join('');
            let values = Object.values(obj).map(v => `<td>${v}</td>`).join('');
            return `
            <table class="table table-sm table-bordered mb-0">
                <thead>
                    <tr>${headers}</tr>
                </thead>
                <tbody>
                    <tr>${values}</tr>
                </tbody>
            </table>`;
        }

        function rankingNotFound() {
            return `
            <tr>
                <td colspan="7" class="text-center text-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i> Tidak ada data ranking ditemukan
                </td>
            </tr>
            `;
        }

        $('#btn-hitung').click(function() {
            $('#btn-hitung').html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menghitung...').attr('disabled', true);
            const tbody = $('#ranking-body');
            const accordion = $('#accordionDetail');
            tbody.empty();
            accordion.empty();

            $.ajax({
                url: '/pelatih/hasilPerhitungan',
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        $('#btn-hitung').html('<i class="bi bi-calculator-fill me-2"></i>Hitung & Lihat Hasil').attr('disabled', false);
                        tampilkanHasil(res.data);
                        console.log(res.data);
                    } else {
                        $('#btn-hitung').html('<i class="bi bi-calculator-fill me-2"></i>Hitung & Lihat Hasil').attr('disabled', false);
                        $('#ranking-body').html(rankingNotFound());
                    }
                }
            })
        });
    });
</script>

<?= $this->endSection() ?>
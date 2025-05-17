<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Hasil Penilaian</h2>
    <h4 class="text-center my-4">Tabel Hasil Input Kriteria</h4>
    <div class="table-responsive">
        <table class="text-center table table-striped">
            <thead id="fetchKriteria">
            </thead>
            <tbody id="hasilTableBody">
            </tbody>
        </table>
        <hr class="mt-4 mb-4 border border-2 opacity-50">
    </div>
    <div class="container mt-4">
        <button id="btn-hitung" class="btn btn-primary mb-4">Hitung & Lihat Hasil</button>
    </div>
    <div class="table-responsive mt-4">
        <table class="text-center table table-striped">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Nama</th>
                    <th>NCF</th>
                    <th>NSF</th>
                    <th>Nilai Akhir</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="ranking-body">
            </tbody>
        </table>
    </div>
    <div class="container d-flex align-items-center flex-column">
        <h4 class="my-5">Detail Perhitungan (Step-by-Step)</h4>
        <div class="accordion w-100" id="accordionDetail"></div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $(document).ready(function() {
        function getHasilPenilaianAwal(hasil) {
            return `
            <tr>
                <td>${hasil.id}</td>
                <td>${hasil.nama}</td>
                <td>${hasil.stamina}</td>
                <td>${hasil.kecepatan}</td>
                <td>${hasil.kekuatan}</td>
                <td>${hasil.kerja_sama}</td>
                <td>${hasil.pengalaman}</td>
                <td>5</td>
            </tr>
            `;
        }

        function hasilNotFound() {
            return `
            <tr>
                <td colspan="7" class="text-center">Tidak ada data hasil ditemukan</td>
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
                            <th>No</th>
                            <th>Nama Pemain</th>
                            <th>${kriteria[0].kode}</th>
                            <th>${kriteria[1].kode}</th>
                            <th>${kriteria[2].kode}</th>
                            <th>${kriteria[3].kode}</th>
                            <th>${kriteria[4].kode}</th>
                            <th>Nilai Ideal</th>
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
                tbody.append(`
                <tr>
                    <td>${pemain.ranking}</td>
                    <td>${pemain.nama}</td>
                    <td>${pemain.nilai_cf}</td>
                    <td>${pemain.nilai_sf}</td>
                    <td>${pemain.nilai_akhir}</td>
                    <td><span class="badge ${pemain.status === 'Lolos' ? 'bg-success' : 'bg-danger'}">${pemain.status}</span></td>
                </tr>
            `);
                accordion.append(`
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading${index}">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="false" aria-controls="collapse${index}">
                ${pemain.ranking}. ${pemain.nama}
              </button>
            </h2>
            <div id="collapse${index}" class="accordion-collapse collapse" aria-labelledby="heading${index}" data-bs-parent="#accordionDetail">
              <div class="accordion-body">
                <ul class="list-group mb-3">
                  <li class="list-group-item"><strong>Nilai Asli:</strong> ${convertObj(pemain.nilai_asli)}</li>
                  <li class="list-group-item"><strong>GAP:</strong> ${convertObj(pemain.gap)}</li>
                  <li class="list-group-item"><strong>Bobot GAP:</strong> ${convertObj(pemain.bobot_gap)}</li>
                  <li class="list-group-item"><strong>NCF:</strong> ${pemain.nilai_cf}</li>
                  <li class="list-group-item"><strong>NSF:</strong> ${pemain.nilai_sf}</li>
                  <li class="list-group-item"><strong>Nilai Akhir:</strong> ${pemain.nilai_akhir}</li>
                  <li class="list-group-item"><strong>Status:</strong> ${pemain.status}</li>
                  <li class="list-group-item"><strong>Ranking:</strong> ${pemain.ranking}</li>
                </ul>
              </div>
            </div>
          </div>
        `);
            });
        }

        // Function to convert object to string 
        function convertObj(obj) {
            return Object.entries(obj).map(([k, v]) => `${k}: ${v}`).join(', ');
        }

        function rankingNotFound() {
            return `
            <tr>
                <td colspan="6" class="text-center">Tidak ada data ranking ditemukan</td>
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
                        $('#btn-hitung').text('Hitung & Lihat Hasil').attr('disabled', false);
                        tampilkanHasil(res.data);
                        console.log(res.data);
                    } else {
                        $('#btn-hitung').text('Hitung & Lihat Hasil').attr('disabled', false);
                        $('#ranking-body').html(rankingNotFound());
                    }
                }
            })
        });
    });
</script>

<?= $this->endSection() ?>
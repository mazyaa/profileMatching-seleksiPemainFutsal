<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <!-- Card Jumlah Pemain Lolos -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card text-white bg-success h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-emoji-smile fs-1 me-3"></i>
                    <div>
                        <h5 class="card-title">Pemain Lolos</h5>
                        <h2 id="jumlahLolos">0</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Jumlah Pemain Tidak Lolos -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card text-white bg-danger h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-emoji-frown fs-1 me-3"></i>
                    <div>
                        <h5 class="card-title">Pemain Tidak Lolos</h5>
                        <h2 id="jumlahTidakLolos">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <i class="bi bi-bar-chart-line"></i> Statistik Seleksi Pemain
                </div>
                <div class="card-body">
                    <div class="chart-responsive" style="position:relative; min-height:200px;">
                        <canvas id="grafikPemain" style="width:100%;height:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let grafikPemain; // Inisialisasi grafik secara global

    // Ambil data dari endpoint
    $.ajax({
        url: '/pelatih/getAllStatusHasilSeleksi',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 200) {
                const data = response.data;

                // Hitung jumlah pemain lolos dan tidak lolos
                const jumlahLolos = data.filter(p => p.status === 'lolos').length;
                const jumlahTidakLolos = data.filter(p => p.status === 'tidak lolos').length;

                // Update card
                document.getElementById("jumlahLolos").textContent = jumlahLolos;
                document.getElementById("jumlahTidakLolos").textContent = jumlahTidakLolos;

                // Tampilkan grafik
                const ctx = document.getElementById('grafikPemain').getContext('2d');
                grafikPemain = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Pemain Lolos', 'Pemain Tidak Lolos'],
                        datasets: [{
                            label: 'Jumlah Pemain',
                            data: [jumlahLolos, jumlahTidakLolos],
                            backgroundColor: ['#28a745', '#dc3545'],
                            borderColor: ['#218838', '#c82333'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false, 
                                labels: {
                                    color: '#333',
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                console.error('Gagal memuat data: status bukan 200');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
            if (xhr.status === 404) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data tidak ditemukan',
                    text: xhr.responseJSON.message || 'Tidak ada data hasil seleksi yang ditemukan.',
                });
            } else {
                console.error('Terjadi kesalahan: ' + xhr.status);
            }
            
        }
    });
</script>
<?= $this->endSection() ?>
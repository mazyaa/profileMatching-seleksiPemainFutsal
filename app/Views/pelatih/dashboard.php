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
    // Data contoh untuk jumlah pemain
    const dataPemain = {
        lolos: 20,  // Misalnya pemain lolos
        tidakLolos: 5  // Misalnya pemain tidak lolos
    };

    // Update jumlah pemain lolos dan tidak lolos pada card
    document.getElementById("jumlahLolos").textContent = dataPemain.lolos;
    document.getElementById("jumlahTidakLolos").textContent = dataPemain.tidakLolos;

    // Grafik Statistik
    const ctx = document.getElementById('grafikPemain').getContext('2d');
    const grafikPemain = new Chart(ctx, {
        type: 'bar',  // Jenis grafik yang digunakan
        data: {
            labels: ['Pemain Lolos', 'Pemain Tidak Lolos'],
            datasets: [{
                label: '',
                data: [dataPemain.lolos, dataPemain.tidakLolos],
                backgroundColor: ['#28a745', '#dc3545'],
                borderColor: ['#218838', '#c82333'],  // Warna border yang sedikit lebih gelap
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true  // Mulai sumbu Y dari 0
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>

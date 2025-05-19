<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .dashboard-card {
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }
    .dashboard-card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 8px 32px rgba(40,167,69,0.15), 0 1.5px 8px rgba(0,0,0,0.08);
    }
    .icon-circle {
        width: 70px; height: 70px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        font-size: 2.5rem;
    }
    .progress-bar-custom {
        height: 8px;
        border-radius: 5px;
        background: linear-gradient(90deg, #28a745 60%, #218838 100%);
        transition: width 0.8s;
    }
    .progress-bar-danger {
        background: linear-gradient(90deg, #dc3545 60%, #c82333 100%);
    }
</style>

<div class="container mt-4">
    <div class="row g-4">
        <!-- Card Jumlah Pemain Lolos -->
        <div class="col-12 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-lg bg-gradient" style="background: linear-gradient(135deg, #28a745 60%, #218838 100%);">
                <div class="card-body d-flex align-items-center">
                    <div class="me-4 icon-circle shadow" data-bs-toggle="tooltip" title="Pemain Lolos">
                        <i class="bi bi-award-fill text-success"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-dark mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-stars text-warning"></i> Pemain Lolos
                        </h5>
                        <h2 id="jumlahLolos" class="fw-bold text-dark mb-0">0</h2>
                        <span class="badge bg-light text-success mt-2"><i class="bi bi-emoji-smile-upside-down"></i> Selamat!</span>
                        <div class="mt-3">
                            <div class="progress" style="height:8px;">
                                <div id="progressLolos" class="progress-bar progress-bar-custom" style="width:0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Jumlah Pemain Tidak Lolos -->
        <div class="col-12 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-lg bg-gradient" style="background: linear-gradient(135deg, #dc3545 60%, #c82333 100%);">
                <div class="card-body d-flex align-items-center">
                    <div class="me-4 icon-circle shadow" data-bs-toggle="tooltip" title="Pemain Tidak Lolos">
                        <i class="bi bi-emoji-frown-fill text-danger"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-dark mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill text-warning"></i> Pemain Tidak Lolos
                        </h5>
                        <h2 id="jumlahTidakLolos" class="fw-bold text-dark mb-0">0</h2>
                        <span class="badge bg-light text-danger mt-2"><i class="bi bi-emoji-expressionless"></i> Coba Lagi!</span>
                        <div class="mt-3">
                            <div class="progress" style="height:8px;">
                                <div id="progressTidakLolos" class="progress-bar progress-bar-danger" style="width:0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0 d-flex align-items-center">
                    <i class="bi bi-bar-chart-steps text-primary fs-4 me-2"></i>
                    <span class="fw-semibold fs-5">Statistik Seleksi Pemain</span>
                </div>
                <div class="card-body">
                    <div class="chart-responsive position-relative" style="min-height:260px;">
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
    let grafikPemain;

    // Tooltip Bootstrap
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });

    // Animasi angka
    function animateValue(id, start, end, duration) {
        const obj = document.getElementById(id);
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.textContent = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                obj.textContent = end;
            }
        };
        window.requestAnimationFrame(step);
    }

    // Animasi progress bar
    function animateProgressBar(id, percent) {
        const bar = document.getElementById(id);
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = percent + '%';
        }, 100);
    }

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
                const total = jumlahLolos + jumlahTidakLolos;

                // Animasi update card
                animateValue("jumlahLolos", 0, jumlahLolos, 800);
                animateValue("jumlahTidakLolos", 0, jumlahTidakLolos, 800);

                // Progress bar
                animateProgressBar("progressLolos", total ? Math.round(jumlahLolos/total*100) : 0);
                animateProgressBar("progressTidakLolos", total ? Math.round(jumlahTidakLolos/total*100) : 0);

                // Tampilkan grafik
                const ctx = document.getElementById('grafikPemain').getContext('2d');
                grafikPemain = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Lolos', 'Tidak Lolos'],
                        datasets: [{
                            label: 'Jumlah Pemain',
                            data: [jumlahLolos, jumlahTidakLolos],
                            backgroundColor: ['#28a745', '#dc3545'],
                            borderColor: ['#fff', '#fff'],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    color: '#333',
                                    font: { size: 15 },
                                    padding: 20
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.label}: ${context.parsed} pemain`;
                                    }
                                }
                            }
                        },
                        cutout: '70%',
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 1200,
                            easing: 'easeOutBounce'
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
                const ctx = document.getElementById('grafikPemain').getContext('2d');
                ctx.save();
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                ctx.font = "bold 22px Poppins, Arial, sans-serif";
                ctx.textAlign = "center";
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#dc3545";
                ctx.fillText("Belum Ada Data", ctx.canvas.width / 2, ctx.canvas.height / 2);
                ctx.restore();
            } else {
                console.error('Terjadi kesalahan: ' + xhr.status);
            }
        }
    });
</script>
<?= $this->endSection() ?>
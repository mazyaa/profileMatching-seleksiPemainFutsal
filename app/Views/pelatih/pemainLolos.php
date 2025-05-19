<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h4 class="text-center my-4 fw-bold">
        <i class="bi bi-trophy-fill text-warning"></i> Data Pemain Lolos
    </h4>
    <div class="table-responsive shadow rounded bg-white p-3">
        <table class="text-center table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th><i class="bi bi-hash"></i> Ranking</th>
                    <th><i class="bi bi-person-fill"></i> Nama</th>
                    <th><i class="bi bi-universal-access"></i> Tinggi Badan</th>
                    <th><i class="bi bi-graph-up"></i> NCF</th>
                    <th><i class="bi bi-graph-up-arrow"></i> NSF</th>
                    <th><i class="bi bi-star-fill text-warning"></i> Nilai Akhir</th>
                    <th><i class="bi bi-patch-check-fill"></i> Status</th>
                </tr>
            </thead>
            <tbody id="ranking-body">
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $(document).ready(function() {
        function getStatusBadge(status) {
            if (status.toLowerCase() === 'lolos') {
                return `<span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i> ${status}</span>`;
            } else if (status.toLowerCase() === 'cadangan') {
                return `<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> ${status}</span>`;
            } else {
                return `<span class="badge bg-secondary"><i class="bi bi-x-circle-fill me-1"></i> ${status}</span>`;
            }
        }

        function getHasilSeleksiByStatusLolos(pemain) {
            return `
            <tr>
                <td><span class="fw-bold">${pemain.ranking}</span></td>
                <td>
                    <i class="bi bi-person-circle text-primary me-1"></i>
                    <span class="fw-semibold">${pemain.nama}</span>
                </td>
                <td>${pemain.tinggi_badan}</i></td>
                <td><span class="text-info fw-bold">${pemain.nilai_cf}</span></td>
                <td><span class="text-primary fw-bold">${pemain.nilai_sf}</span></td>
                <td>
                    <span class="badge bg-primary fs-6">
                        <i class="bi bi-star-fill text-warning"></i> ${pemain.nilai_akhir}
                    </span>
                </td>
                <td>${getStatusBadge(pemain.status)}</td>
            </tr>
            `;
        }

        function getHasilSeleksiByStatusLolosNotFound() {
            return `
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        <i class="bi bi-emoji-frown fs-3"></i><br>
                        Tidak ada data hasil ditemukan
                    </td>
                 </tr>
            `;
        }
        
        $.ajax({
            url: '/pelatih/getHasilLolos',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                let fetchHasilLolos = $('#ranking-body');
                fetchHasilLolos.empty();
                if (response.status == 200 && response.data.length > 0) {
                    response.data.forEach(function(pemain) {
                        let hasilLolos = getHasilSeleksiByStatusLolos(pemain);
                        fetchHasilLolos.append(hasilLolos);
                    });
                } else {
                    fetchHasilLolos.append(getHasilSeleksiByStatusLolosNotFound());
                }
            },
            error: function(xhr, status, error) {
                let fetchHasilLolos = $('#ranking-body');
                fetchHasilLolos.empty();
                fetchHasilLolos.append(getHasilSeleksiByStatusLolosNotFound());
            }
        });
    });
</script>

<?= $this->endSection() ?>
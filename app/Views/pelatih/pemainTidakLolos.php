<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h4 class="text-center my-4 fw-bold">
        <i class="bi bi-x-circle-fill text-danger"></i>
        Data Pemain Tidak Lolos
    </h4>
    <div class="table-responsive shadow rounded bg-white p-3">
        <table class="text-center table table-hover align-middle">
            <thead class="table-danger">
                <tr>
                    <th><i class="bi bi-trophy"></i> Ranking</th>
                    <th><i class="bi bi-person"></i> Nama</th>
                    <th><i class="bi bi-universal-access"></i> Tinggi Badan</th>
                    <th><i class="bi bi-graph-up"></i> NCF</th>
                    <th><i class="bi bi-graph-down"></i> NSF</th>
                    <th><i class="bi bi-star-half"></i> Nilai Akhir</th>
                    <th><i class="bi bi-x-octagon"></i> Status</th>
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
        function getHasilSeleksiByStatusLolos(pemain) {
            return `
            <tr>
                <td><span class="badge bg-secondary"><i class="bi bi-trophy"></i> ${pemain.ranking}</span></td>
                <td><i class="bi bi-person-circle text-primary"></i> ${pemain.nama}</td>
                <td><i class="bi bi-arrows-collapse-vertical"></i> ${pemain.tinggi_badan} cm</td>
                <td><span class="text-success fw-bold"><i class="bi bi-graph-up"></i> ${pemain.nilai_cf}</span></td>
                <td><span class="text-warning fw-bold"><i class="bi bi-graph-down"></i> ${pemain.nilai_sf}</span></td>
                <td><span class="fw-bold"><i class="bi bi-star-half"></i> ${pemain.nilai_akhir}</span></td>
                <td>
                    <span class="badge bg-danger">
                        <i class="bi bi-x-circle"></i> ${pemain.status}
                    </span>
                </td>
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
            url: '/pelatih/getHasilTidakLolos',
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

<!-- Pastikan Bootstrap Icons sudah di-include di layout utama -->
<?= $this->endSection() ?>
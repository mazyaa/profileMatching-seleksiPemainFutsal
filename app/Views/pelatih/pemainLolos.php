<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<div class="container mt-4">
    <h4 class="text-center my-4 fw-bold">Data Pemain Lolos</h4>
    <div class="table-rsponseive">
        <table class="text-center table table-striped">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Nama</th>
                    <th>Tinggi Badan</th>
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
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $(document).ready(function() {
        function getHasilSeleksiByStatusLolos(pemain) {
            return `
            <tr>
                <td>${pemain.ranking}</td>
                <td>${pemain.nama}</td>
                <td>${pemain.tinggi_badan}</td>
                <td>${pemain.nilai_cf}</td>
                <td>${pemain.nilai_sf}</td>
                <td>${pemain.nilai_akhir}</td>
                <td><span class="badge bg-success">${pemain.status}</span></td>
            </tr>
            `;
        }

        function getHasilSeleksiByStatusLolosNotFound() {
            return `
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data hasil ditemukan</td>
                 </tr>
            `;
        }
        
        $.ajax({
        url: '/pelatih/getHasilLolos',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status == 200) {
                let fetchHasilLolos = $('#ranking-body');
                let hasilLolos = response.data;

                hasilLolos.forEach(function(pemain) {
                    let hasilLolos = getHasilSeleksiByStatusLolos(pemain);
                    fetchHasilLolos.append(hasilLolos);
                });
            }
        },
        error: function(xhr, status, error) {
            if (xhr.status == 404) {
                let fetchHasilLolos = $('#ranking-body');
                let hasilLolosNotFound = getHasilSeleksiByStatusLolosNotFound();
                fetchHasilLolos.append(hasilLolosNotFound);
            }
        }
    });
});
</script>

<?= $this->endSection() ?>
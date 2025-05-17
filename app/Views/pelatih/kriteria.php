<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="container mt-4">
    <h4 class="text-center my-4 fw-bold">Data Kriteria Pemain</h4>
    <table class="text-center table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Kriteria</th>
                <th>Tipe</th>
                <th>Nilai Ideal</th>
            </tr>
        </thead>
        <tbody id="kriteriaTableBody">
        </tbody>
    </table>
</div>
<div class="container mt-5">
    <h4 class="text-center my-4 fw-bold">Tabel Pembobotan</h4>
    <table class="text-center table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Selisih GAP</th>
                <th>Bobot Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>0</td>
                <td>5</td>
                <td class="keterangan">Tidak ada selisih (kompetensi sesuai dengan yang dibutuhkan)</td>
            </tr>
            <tr>
                <td>2</td>
                <td>1</td>
                <td>4.5</td>
                <td class="keterangan">Kompetensi individu kelebihan 1 tingkat/level</td>
            </tr>
            <tr>
                <td>3</td>
                <td>-1</td>
                <td>4</td>
                <td class="keterangan">Kompetensi individu kekurangan 1 tingkat/level</td>
            </tr>
            <tr>
                <td>4</td>
                <td>2</td>
                <td>3.5</td>
                <td class="keterangan">Kompetensi individu kelebihan 2 tingkat/level</td>
            </tr>
            <tr>
                <td>5</td>
                <td>-2</td>
                <td>3</td>
                <td class="keterangan">Kompetensi individu kekurangan 2 tingkat/level</td>
            </tr>
            <tr>
                <td>6</td>
                <td>3</td>
                <td>2.5</td>
                <td class="keterangan">Kompetensi individu kelebihan 3 tingkat/level</td>
            </tr>
            <tr>
                <td>7</td>
                <td>-3</td>
                <td>2</td>
                <td class="keterangan">Kompetensi individu kekurangan 3 tingkat/level</td>
            </tr>
            <tr>
                <td>8</td>
                <td>4</td>
                <td>1.5</td>
                <td class="keterangan">Kompetensi individu kelebihan 4 tingkat/level</td>
            </tr>
            <tr>
                <td>9</td>
                <td>-4</td>
                <td>1</td>
                <td class="keterangan">Kompetensi individu kekurangan 4 tingkat/level</td>
            </tr>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {

        function getKriteria(kriteria) {
            return `
                <tr>
                    <td>${kriteria.id}</td>
                    <td>${kriteria.kode}</td>
                    <td>${kriteria.nama_kriteria}</td>
                    <td>${kriteria.tipe}</td>
                    <td>${kriteria.nilai_ideal}</td>
                </tr>
                `;
        }

        function kriteriaNotFound() {
            return `
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data kriteria ditemukan</td>
                </tr>
                `;
        }

        $.ajax({
            url: '/pelatih/kriteria/fetch',
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status == 200) {
                    let kriteriaRows = '';
                    res.data.forEach(kriteria => {
                        kriteriaRows += getKriteria(kriteria);
                    });
                    $('#kriteriaTableBody').html(kriteriaRows);
                } else {
                    $('#kriteriaTableBody').html(kriteriaNotFound());
                }
            },
            error: function(xhr, status, message) {
                if (xhr.status == 404) {
                    $('#kriteriaTableBody').html(kriteriaNotFound());
                } else {
                    $('#kriteriaTableBody').html(`
                            <tr>
                                <td colspan="5" class="text-center">Terjadi kesalahan: ${message}</td>
                            </tr>
                    `);
                }
            }
        });
    });
</script>


<?= $this->endSection() ?>
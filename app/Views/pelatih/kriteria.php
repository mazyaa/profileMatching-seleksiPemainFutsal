<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Data Kriteria Pemain</h4>
        <div>
            <button id="refreshBtn" class="btn btn-outline-primary me-2">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
        </div>
    </div>
    <div id="alertBox"></div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="text-center table table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Kriteria</th>
                            <th>Tipe</th>
                            <th>Nilai Ideal</th>
                        </tr>
                    </thead>
                    <tbody id="kriteriaTableBody">
                        <tr>
                            <td colspan="5">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="spinner-border text-primary" role="status"></div>
                                    <span class="ms-2">Memuat data...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kriteria (dummy, implementasi backend diperlukan) -->
<div class="modal fade" id="addKriteriaModal" tabindex="-1" aria-labelledby="addKriteriaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addKriteriaModalLabel">Tambah Kriteria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form fields -->
        <div class="mb-3">
            <label class="form-label">Kode</label>
            <input type="text" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Kriteria</label>
            <input type="text" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipe</label>
            <select class="form-select" required>
                <option value="Core">Core</option>
                <option value="Secondary">Secondary</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nilai Ideal</label>
            <input type="number" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<div class="container mt-5">
    <h4 class="text-center my-4 fw-bold">Tabel Pembobotan</h4>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="text-center table table-striped table-hover align-middle">
                    <thead class="table-info">
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
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function showAlert(type, message) {
        $('#alertBox').html(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
    }

    function getBadgeTipe(tipe) {
        if (tipe.toLowerCase() === 'core') {
            return `<span class="badge bg-primary">${tipe}</span>`;
        } else if (tipe.toLowerCase() === 'secondary') {
            return `<span class="badge bg-success">${tipe}</span>`;
        }
        return `<span class="badge bg-secondary">${tipe}</span>`;
    }

    function getKriteria(kriteria, idx) {
        return `
            <tr class="fade-in">
                <td>${idx + 1}</td>
                <td>${kriteria.kode}</td>
                <td>${kriteria.nama_kriteria}</td>
                <td>${getBadgeTipe(kriteria.tipe)}</td>
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

    function fetchKriteria() {
        $('#kriteriaTableBody').html(`
            <tr>
                <td colspan="5">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-border text-primary" role="status"></div>
                        <span class="ms-2">Memuat data...</span>
                    </div>
                </td>
            </tr>
        `);
        $.ajax({
            url: '/pelatih/kriteria/fetch',
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status == 200) {
                    let kriteriaRows = '';
                    res.data.forEach((kriteria, idx) => {
                        kriteriaRows += getKriteria(kriteria, idx);
                    });
                    $('#kriteriaTableBody').hide().html(kriteriaRows).fadeIn(400);
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
                    showAlert('danger', 'Gagal memuat data kriteria!');
                }
            }
        });
    }

    $(document).ready(function() {
        fetchKriteria();

        $('#refreshBtn').click(function() {
            fetchKriteria();
            showAlert('info', 'Data kriteria diperbarui.');
        });
    });
</script>
<style>
    .fade-in {
        animation: fadeIn 0.7s;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    .table-hover tbody tr:hover {
        background-color: #e9f7fe;
        transition: background 0.2s;
    }
</style>
<?= $this->endSection() ?>
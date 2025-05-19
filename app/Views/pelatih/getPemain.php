<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h4 class="text-center my-4 fw-bold">
        <i class="bi bi-people-fill text-primary"></i> Data Pemain
    </h4>
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-success btn-sm shadow" href="<?= base_url('/pelatih/pemain') ?>">
            <i class="bi bi-person-plus-fill"></i> Input Pemain
        </a>
    </div>
    <div class="table-responsive shadow rounded-4 p-3 bg-white">
        <table class="text-center table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th><i class="bi bi-hash"></i></th>
                    <th><i class="bi bi-person"></i> Nama</th>
                    <th><i class="bi bi-arrows-vertical"></i> Tinggi Badan</th>
                    <th><i class="bi bi-geo-alt"></i> Alamat</th>
                    <th><i class="bi bi-telephone"></i> No HP</th>
                    <th><i class="bi bi-gear"></i> Aksi</th>
                </tr>
            </thead>
            <tbody id="pemainTableBody">
                <!-- Data Pemain akan dimuat di sini -->
            </tbody>
        </table>
    </div>
    <div class="container mt-4 text-center">
        <a class="btn btn-primary btn-lg shadow" href="<?= base_url('/pelatih/pagePenilaian') ?>">
            <i class="bi bi-star-fill"></i> Nilai Pemain
        </a>
    </div>
</div>

<div class="modal fade" id="editPemain" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square"></i> Edit Pemain</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column mb-3">
                    <label for="nama" class="form-label fw-bold">Nama Pemain</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="namaPemain">
                    </div>
                </div>
                <div class="d-flex flex-column mb-3">
                    <label for="tinggiBadan" class="form-label fw-bold">Tinggi Badan</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-universal-access"></i></span>
                        <input type="text" class="form-control" id="tinggiBadan">
                    </div>
                </div>
                <div class="d-flex flex-column mb-3">
                    <label for="alamat" class="form-label fw-bold">Alamat</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" class="form-control" id="alamat">
                    </div>
                </div>
                <div class="d-flex flex-column mb-3">
                    <label for="no-telepon" class="form-label fw-bold">No Hp</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" class="form-control" id="no-telepon">
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center my-4">
                    <button type="submit" id="btnSubmitProfile" class="btn btn-success btn-block rounded-3 w-50 shadow">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $(document).ready(function() {
        function getPemain(pemain, num) {
            return `
                <tr>
                    <td class="fw-bold">${num}</td>
                    <td>
                        <span class="badge bg-info text-dark fs-6"><i class="bi bi-person-circle"></i> ${pemain.nama}</span>
                    </td>
                    <td>
                        <span class="badge bg-secondary"><i class="bi bi-arrows-vertical"></i> ${pemain.tinggi_badan} cm</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark"><i class="bi bi-geo-alt"></i> ${pemain.alamat}</span>
                    </td>
                    <td>
                        <span class="badge bg-success"><i class="bi bi-telephone"></i> ${pemain.no_hp}</span>
                    </td>
                    <td>
                        <button
                            data-bs-toggle="modal"
                            data-bs-target="#editPemain"
                            data-id="${pemain.id}"
                            data-nama="${pemain.nama}"
                            data-tinggi="${pemain.tinggi_badan}"
                            data-alamat="${pemain.alamat}"
                            data-nohp="${pemain.no_hp}"
                            class="btn btn-warning btn-sm btn-edit me-1"
                            title="Edit"
                        >
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button data-id="${pemain.id}" class="btn btn-danger btn-sm btn-delete" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        }

        function editPemain(id) {
            let nama = $('#namaPemain').val();
            let tinggi = $('#tinggiBadan').val();
            let alamat = $('#alamat').val();
            let nohp = $('#no-telepon').val();

            let data = {
                id: id,
                nama: nama,
                tinggi_badan: tinggi,
                alamat: alamat,
                no_hp: nohp
            };

            $.ajax({
                url: '/pelatih/pemain/edit/' + id,
                method: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#namaPemain').val('');
                        $('#tinggiBadan').val('');
                        $('#alamat').val('');
                        $('#no-telepon').val('');
                        $('#editPemain').modal('hide');
                        getAllPemain();
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                    });
                }
            });
        }

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let tinggi = $(this).data('tinggi');
            let alamat = $(this).data('alamat');
            let nohp = $(this).data('nohp');

            $('#namaPemain').val(nama);
            $('#tinggiBadan').val(tinggi);
            $('#alamat').val(alamat);
            $('#no-telepon').val(nohp);

            $('#btnSubmitProfile').off('click').on('click', function() {
                editPemain(id);
            });
        });

        function pemainNotFound() {
            return `
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        <i class="bi bi-emoji-frown fs-3"></i><br>
                        Tidak ada data pemain ditemukan
                    </td>
                </tr>
            `;
        }

        function getAllPemain(){
            $.ajax({
                url: '/pelatih/fetchPemain',
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200 && res.data.length > 0) {
                        let pemainRows = '';
                        let num = 1;
                        res.data.forEach(pemain => {
                            pemainRows += getPemain(pemain, num++);
                        });
                        $('#pemainTableBody').html(pemainRows);
                    } else {
                        $('#pemainTableBody').html(pemainNotFound());
                    }
                },
                error: function(xhr, status, error) {
                    $('#pemainTableBody').html(pemainNotFound());
                }
            });
        }

        $('#pemainTableBody').on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pemain akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/pelatih/pemain/delete/' + id,
                        method: 'POST',
                        dataType: 'json',
                        success: function(res) {
                            if (res.status == 200) {
                                Swal.fire(
                                    'Deleted!',
                                    res.message,
                                    'success'
                                );
                                getAllPemain();
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                            });
                        }
                    });
                }
            });
        });

        getAllPemain();
    });
</script>

<?= $this->endSection() ?>
<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h2 class="text-center fw-bold">Penilaian Pemain</h2>
    <div class="d-flex mt-4 flex-column">
        <label for="pemain" class="form-label me-2 fw-bold">Pemain</label>
        <select id="pemain" name="pemain" class="form-select">
            <option value="">Pilih Pemain</option>
        </select>
    </div>
    <div class="d-flex mt-5 flex-column">
        <label for="stamina" class="form-label me-2 fw-bold">Stamina - Core (C1)</label>
        <select id="stamina" name="stamina" class="form-select">
            <option value="">Pilih Stamina</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div class="d-flex mt-5 flex-column">
        <label for="kecepatan" class="form-label me-2 fw-bold">Kecepatan - Core (C2)</label>
        <select id="kecepatan" name="kecepatan" class="form-select">
            <option value="">Pilih Kecepatan</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div class="d-flex mt-5 flex-column">
        <label for="kekuatan" class="form-label me-2 fw-bold">Kekuatan - Secondary (C3)</label>
        <select id="kekuatan" name="kekuatan" class="form-select">
            <option value="">Pilih Kekuatan</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div class="d-flex mt-5 flex-column">
        <label for="kerjasama" class="form-label me-2 fw-bold">Kerjasama - Secondary (C4)</label>
        <select id="kerjasama" name="kerjasama" class="form-select">
            <option value="">Pilih Kerjasama</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div class="d-flex mt-5 flex-column">
        <label for="pengalaman" class="form-label me-2 fw-bold">Pengalaman - Secondary (C5)</label>
        <select id="pengalaman" name="pengalaman" class="form-select">
            <option value="">Pilih Pengalaman</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div class="d-flex mt-4 mb-5">
        <button type="button" class="btn btn-primary px-5" id="btnHitung">Hitung</button>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {

        function getPemainAfterInput(pemain) {
            return `
            <option value="${pemain.id}">${pemain.nama}</option>
            `;
        }

        function pemainNotFound() {
            return `
            <option value="">Pemain tidak ditemukan</option>
            `;
        }

        $.ajax({
                url: '/pelatih/fetchPemain',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        let pemain = res.data;
                        pemain.forEach(function(item){
                            $('#pemain').append(getPemainAfterInput(item));
                        });
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status == 404) {
                        $('#pemain').append(pemainNotFound());
                    } else {
                        console.error('Error fetching data:', error);
                    }
                }
            });
    });
</script>
<?= $this->endSection() ?>
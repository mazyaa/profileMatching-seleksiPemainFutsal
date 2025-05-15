<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h2 class="text-center fw-bold">Penilaian Pemain</h2>
    <div class="d-flex mt-4 flex-column">
        <label for="pemain" class="form-label me-2 fw-bold">Pemain:</label>
        <select id="pemain" name="pemain" class="form-select">
            <option value="">Pilih Pemain</option>
        </select>
    </div>
    <div class="d-flex mt-5 flex-column">
        <label for="stamina" class="form-label me-2 fw-bold">Stamina:</label>
        <select id="stamina" name="stamina" class="form-select">
            <option value="">Pilih Stamina</option>
            <option value="1">Sangat Kurang</option>
            <option value="2">Kurang</option>
            <option value="3">Cukup</option>
            <option value="4">Baik</option>
            <option value="5">Sangat Baik</option>
        </select>
    </div>
    <div class="d-flex mt-5 flex-column">
        <label for="kecepatan" class="form-label me-2 fw-bold">Kecepatan:</label>
        <select id="kecepatan" name="kecepatan" class="form-select">
            <option value="">Pilih Kecepatan</option>
            <option value="1">Sangat Kurang</option>
            <option value="2">Kurang</option>
            <option value="3">Cukup</option>
            <option value="4">Baik</option>
            <option value="5">Sangat Baik</option>
        </select>
    </div>
    <div class="d-flex mt-5 flex-column">
        <label for="kekuatan" class="form-label me-2 fw-bold">Kekuatan:</label>
        <select id="kekuatan" name="kekuatan" class="form-select">
            <option value="">Pilih Kekuatan</option>
            <option value="1">Sangat Kurang</option>
            <option value="2">Kurang</option>
            <option value="3">Cukup</option>
            <option value="4">Baik</option>
            <option value="5">Sangat Baik</option>
        </select>
    </div>
    <div class="d-flex mt-5 flex-column">
        <label for="kerjasama" class="form-label me-2 fw-bold">Kerjasama:</label>
        <select id="kerjasama" name="kerjasama" class="form-select">
            <option value="">Pilih Kerjasama</option>
            <option value="1">Sangat Kurang</option>
            <option value="2">Kurang</option>
            <option value="3">Cukup</option>
            <option value="4">Baik</option>
            <option value="5">Sangat Baik</option>
        </select>
    </div>
    <div class="d-flex mt-5 flex-column">
        <label for="pengalaman" class="form-label me-2 fw-bold">Pengalaman:</label>
        <select id="pengalaman" name="pengalaman" class="form-select">
            <option value="">Pilih Pengalaman</option>
            <option value="1">Sangat Kurang</option>
            <option value="2">Kurang</option>
            <option value="3">Cukup</option>
            <option value="4">Baik</option>
            <option value="5">Sangat Baik</option>
        </select>
    </div>
    <div class="d-flex mt-4 mb-5">
        <button type="button" class="btn btn-primary px-5" id="btnHitung">Hitung</button>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>

</script>
<?= $this->endSection() ?>
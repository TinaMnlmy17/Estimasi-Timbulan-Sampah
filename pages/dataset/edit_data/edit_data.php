<?php
// Include file konfigurasi database
include './conf/conf.php';

// Tangani permintaan pengeditan data
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['q']) && $_GET['q'] == 'edit_data') {
    // Pastikan id data yang akan diedit sudah disediakan dan merupakan bilangan bulat positif
    if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) && $_GET['id'] > 0) {
        // Ambil id dari parameter GET
        $id = $_GET['id'];

        // Lakukan query untuk mengambil data yang akan diedit
        $sql = "SELECT * FROM sampah WHERE id = '$id'";
        $result = $conn->query($sql);

        // Pastikan data ditemukan
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            // Jika data tidak ditemukan, berikan pesan kesalahan
            echo "<p>Data not found.</p>";
            exit(); // keluar dari skrip
        }
    } else {
        // Jika ID tidak diberikan atau tidak valid, berikan pesan kesalahan
        echo "<p>Invalid or missing ID.</p>";
        exit(); // keluar dari skrip
    }
}
?>

<!-- Tampilan Formulir Edit -->
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="?q=editproses">
                        <?php if (isset($row)) : ?>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <div class="form-group">
                            <label for="tahun">Tahun:</label>
                            <input type="text" class="form-control" id="tahun" name="tahun"
                                value="<?php echo $row['tahun']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="Bulan">Bulan:</label>
                            <input type="text" class="form-control" id="Bulan" name="Bulan"
                                value="<?php echo $row['Bulan']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="hari">Periode Bulan:</label>
                            <input type="text" class="form-control" id="hari" name="hari"
                                value="<?php echo $row['hari']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="timbulan_sampah">Timbulan Sampah:</label>
                            <input type="text" class="form-control" id="timbulan_sampah" name="timbulan_sampah"
                                value="<?php echo $row['timbulan_sampah']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'conf/conf.php';

// Query untuk mengambil data dari tabel Sampah
$sql = "SELECT * FROM sampah";
$result = $conn->query($sql);
?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p class="card-title">Dataset</p>
                        <div>
                            <form method="POST" action="?q=deleteall">
                                <button type="submit" class="btn btn-danger btn-sm mb-2" name="deleteAll">Hapus
                                    Dataset</button>
                            </form>
                            <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal"
                                data-target="#addRowModal">Tambah</button>
                            <form method="POST" action="?q=proses_csv" enctype="multipart/form-data">
                                <input type="file" name="file" id="csvFileInput" accept=".csv" style="display: none;"
                                    onchange="this.form.submit();">
                                <label for="csvFileInput" class="btn btn-info btn-sm mr-2">Impor</label>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive text-center">
                        <table id="dataTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Periode Bulan</th>
                                    <th>Timbulan Sampah (Ton)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row["tahun"]; ?></td>
                                    <td><?php echo $row["Bulan"]; ?></td>
                                    <td><?php echo $row["hari"]; ?></td>
                                    <td><?php echo number_format($row["timbulan_sampah"], 2); ?></td>
                                    <td>
                                        <a href="?q=edit_data&id=<?php echo $row['id']; ?>"
                                            class="btn btn-info btn-sm">Ubah</a>
                                        <a href="?q=delete_data&id=<?php echo $row['id']; ?>"
                                            class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Tidak ada data yang ditemukan.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menambahkan data baru -->
<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-labelledby="addRowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRowModalLabel">Tambahkan Data Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambahkan data baru -->
                <form method="POST" action="?q=add_data" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="tahun">Tahun :</label>
                        <select class="form-control" id="tahun" name="tahun" required>
                            <option value="">Pilih Tahun</option>
                            <?php
                                // Generate options for tahun from 2019 to 2022
                                for ($i = 2019; $i <= date("Y") + 5; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Bulan">Bulan:</label>
                        <select class="form-control" id="Bulan" name="Bulan">
                            <option value="">Pilih Bulan</option>
                            <?php
                            $bulanNames = [
                                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
                            ];

                            // Generate options for bulan
                            foreach ($bulanNames as $index => $bulanName) {
                                $bulanValue = $index + 1; // Bulan dimulai dari 1
                                echo "<option value='$bulanValue'>$bulanName</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hari">Periode Bulan:</label>
                        <input type="text" class="form-control" id="hari" name="hari" placeholder="Masukkan jumlah periode bulan"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="timbulan_sampah">Timbulan Sampah:</label>
                        <input type="text" class="form-control" id="timbulan_sampah" name="timbulan_sampah">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Script DataTable Live Search -->
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Data Hasil Estimasi</h4>
                        <form method="POST" action="?q=d_hasil_prediksi">
                            <button type="submit" class="btn btn-danger mb-3" name="deleteAll">Hapus Data</button>
                        </form>
                    </div>
                    <div class="table-responsive text-center">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Periode Bulan</th>
                                    <th>Timbulan Sampah (Ton)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Lakukan impor koneksi ke database
                                include 'conf/conf.php';

                                // Query untuk mengambil data dari tabel Hasil_Prediksi
                                $sql = "SELECT * FROM hasil_prediksi";
                                $result = $conn->query($sql);

                                // Pastikan ada hasil dari query
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $row["tahun"]; ?></td>
                                    <td><?php echo $row["Bulan"]; ?></td>
                                    <td><?php echo $row["hari"]; ?></td>
                                    <td><?php echo number_format($row["hasil_prediksi"], 2); ?></td>
                                </tr>
                                <?php }
                                } else {
                                    echo "<tr><td colspan='4'>Tidak ada data hasil estimasi.</td></tr>";
                                }

                                // Tutup koneksi database
                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
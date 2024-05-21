<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="">
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
                            <label for="hari">Hari :</label>
                            <select class="form-control" id="hari" name="hari" required>
                                <option value="">Pilih Hari</option>
                                <?php
                                // Generate options for hari from 1 to 365
                                for ($i = 1; $i <= 365; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="hasil_prediksi">Hasil Prediksi :</label>
                            <input type="text" class="form-control" id="hasil_prediksi" name="hasil_prediksi" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Prediksi</button>
                        <button type="button" class="btn btn-danger" id="hapusPrediksi">Hapus Prediksi</button>
                    </form>

                    <?php
                    // Tangani permintaan prediksi
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Ambil data yang dipilih oleh pengguna
                        $tahun = $_POST['tahun'];
                        $hari = $_POST['hari'];

                        // Lakukan prediksi berdasarkan data yang dipilih
                        $prediction = predict($tahun, $hari);

                        // Tampilkan hasil prediksi
                        echo "<script>document.getElementById('hasil_prediksi').value = '$prediction';</script>";
                    }

                    function predict($tahun, $hari)
                    {
                        $current_year = date("Y");
                        if ($tahun > $current_year) {
                            $m = 0.5;
                            $b = 0.1;
                            $hasil_prediksi = $m * ($tahun * $hari) + $b; // Ganti dengan rumus prediksi yang sesuai
                            return $hasil_prediksi;
                        } else {

                            // Lakukan impor koneksi ke database atau proses untuk memuat data latih
                            include 'conf/conf.php';

                            // Query untuk mengambil data dari tabel Sampah
                            $sql = "SELECT * FROM Sampah";
                            $result = $conn->query($sql);

                            // Menginisialisasi variabel untuk menyimpan hasil prediksi
                            $hasil_prediksi = null;

                            // Pastikan ada hasil dari query
                            if ($result->num_rows > 0) {
                                // Simpan data latih ke dalam array
                                $data_latih = [];
                                while ($row = $result->fetch_assoc()) {
                                    $data_latih[] = [
                                        'tahun' => $row['tahun'],
                                        'hari' => $row['hari'],
                                        'timbulan_sampah' => $row['timbulan_sampah']
                                    ];
                                }

                                // Hitung prediksi berdasarkan model regresi linear sederhana
                                $jumlah_data = count($data_latih);
                                $sum_xy = 0;
                                $sum_x = 0;
                                $sum_y = 0;
                                $sum_x_squared = 0;
                                foreach ($data_latih as $data) {
                                    $sum_xy += $data['tahun'] * $data['hari'] * $data['timbulan_sampah'];
                                    $sum_x += $data['tahun'] * $data['hari'];
                                    $sum_y += $data['timbulan_sampah'];
                                    $sum_x_squared += pow($data['tahun'] * $data['hari'], 2);
                                }

                                // Hitung koefisien regresi
                                $m = (($jumlah_data * $sum_xy) - ($sum_x * $sum_y)) / (($jumlah_data * $sum_x_squared) - pow($sum_x, 2));
                                $b = ($sum_y - ($m * $sum_x)) / $jumlah_data;

                                // Lakukan prediksi berdasarkan koefisien regresi
                                $hasil_prediksi = $m * ($tahun * $hari) + $b;
                            }

                            // Tutup koneksi database
                            $conn->close();

                            // Kembalikan hasil prediksi
                            return $hasil_prediksi;
                        }
                    }


                    // Fungsi untuk menyimpan hasil prediksi ke dalam database
                    function simpanHasilPrediksi($tahun, $hari, $hasil_prediksi)
                    {
                        // Lakukan impor koneksi ke database
                        include 'conf/conf.php';

                        // Siapkan query untuk menyimpan hasil prediksi
                        $sql = "INSERT INTO Hasil_Prediksi (tahun, hari, hasil_prediksi) VALUES ('$tahun', '$hari', '$hasil_prediksi')";

                        // Jalankan query
                        if ($conn->query($sql) === TRUE) {
                            echo "<p>Hasil prediksi berhasil disimpan</p>";
                        } else {
                            echo "<p>Terjadi kesalahan saat menyimpan hasil prediksi ke database: " . $conn->error . "</p>";
                        }

                        // Tutup koneksi database
                        $conn->close();
                    }

                    // Tangani permintaan prediksi
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Ambil data yang dipilih oleh pengguna
                        $tahun = $_POST['tahun'];
                        $hari = $_POST['hari'];

                        // Lakukan prediksi berdasarkan data yang dipilih
                        $prediction = predict($tahun, $hari);

                        // Tampilkan hasil prediksi
                        echo "<script>document.getElementById('hasil_prediksi').value = '$prediction';</script>";

                        // Simpan hasil prediksi ke dalam database
                        simpanHasilPrediksi($tahun, $hari, $prediction);
                    }


                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Hapus prediksi ketika tombol "Hapus Prediksi" diklik
    document.getElementById('hapusPrediksi').addEventListener('click', function() {
        document.getElementById('hasil_prediksi').value = '';
    });
</script>
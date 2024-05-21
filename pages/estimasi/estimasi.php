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
                                for ($i = 2023; $i <= date("Y") + 3; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Bulan">Bulan :</label>
                            <select class="form-control" id="Bulan" name="Bulan" required>
                                <option value="">Pilih Bulan</option>
                                <?php
                            $bulanNames = [
                                'January',
                                'February',
                                'March',
                                'April',
                                'May',
                                'June',
                                'July',
                                'August',
                                'September',
                                'October',
                                'November',
                                'December'
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
                            <label for="hari">Periode Bulan Ke:</label>
                            <select class="form-control" id="hari" name="hari" required>
                                <option value="">Pilih Periode Bulan</option>
                                <!-- Options will be generated dynamically by JavaScript -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Estimasi</button>
                        <div class="form-group mt-3">
                            <label for="hasil_prediksi">Hasil Estimasi :</label>
                            <input type="text" class="form-control" id="hasil_prediksi" name="hasil_prediksi" readonly>
                        </div>

                        <button type="button" class="btn btn-danger" id="hapusPrediksi">Hapus Estimasi</button>
                    </form>

                    <?php
                    // Tangani permintaan prediksi
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Ambil data yang dipilih oleh pengguna
                        $tahun = $_POST['tahun'];
                        $Bulan = $_POST['Bulan'];
                        $hari = $_POST['hari'];

                        // Ambil data latih dari tabel 'Sampah'
                        $data_latih = getDataLatih();

                        // Hitung jumlah data dan variabel untuk regresi
                        $n = count($data_latih);
                        $sum_x = 0;
                        $sum_y = 0;
                        $sum_xy = 0;
                        $sum_x_squared = 0;

                        foreach ($data_latih as $data) {
                            $sum_x += $data['hari'];
                            $sum_y += $data['timbulan_sampah'];
                            $sum_xy += $data['hari'] * $data['timbulan_sampah'];
                            $sum_x_squared += pow($data['hari'], 2);
                        }

                        // Hitung koefisien regresi
                        $m = (($n * $sum_xy) - ($sum_x * $sum_y)) / (($n * $sum_x_squared) - pow($sum_x, 2));
                        $b = ($sum_y - ($m * $sum_x)) / $n;

                        // Lakukan prediksi berdasarkan data yang dipilih
                        $prediction = predict($hari, $m, $b);

                        // Tampilkan hasil prediksi
                        echo "<script>document.getElementById('hasil_prediksi').value = '$prediction';</script>";

                        // Simpan hasil prediksi ke dalam database
                        simpanHasilPrediksi($tahun, $Bulan, $hari, $prediction);
                    }

                    // Fungsi prediksi
                    function predict($hari, $m, $b)
                    {
                        $hasil_prediksi = $m * $hari + $b;
                        return $hasil_prediksi;
                    }

                    // Fungsi untuk mengambil data latih dari tabel 'Sampah' dan menghitung koefisien regresi
                    function getDataLatih()
                    {
                        // Lakukan koneksi ke database
                        include 'conf/conf.php';

                        // Query untuk mengambil data dari tabel 'Sampah'
                        $sql = "SELECT hari, Bulan, timbulan_sampah FROM sampah";

                        // Jalankan query
                        $result = $conn->query($sql);

                        // Inisialisasi array untuk menyimpan data latih
                        $data_latih = [];

                        // Pastikan ada hasil dari query
                        if ($result->num_rows > 0) {
                            // Simpan data latih ke dalam array
                            while ($row = $result->fetch_assoc()) {
                                $data_latih[] = [
                                    'hari' => $row['hari'],
                                    'Bulan' => $row['Bulan'],
                                    'timbulan_sampah' => $row['timbulan_sampah']
                                ];
                            }
                        }

                        // Tutup koneksi database
                        $conn->close();

                        return $data_latih;
                    }

                    // Fungsi untuk menyimpan hasil prediksi ke dalam database
                    function simpanHasilPrediksi($tahun, $Bulan, $hari, $hasil_prediksi)
                    {
                        
                        // Lakukan impor koneksi ke database
                        include 'conf/conf.php';

                        // Siapkan query untuk menyimpan hasil prediksi
                        $sql = "INSERT INTO hasil_prediksi (tahun, Bulan, hari, hasil_prediksi) VALUES ('$tahun', '$Bulan', '$hari', '$hasil_prediksi')";

                        // Jalankan query
                        if ($conn->query($sql) === TRUE) {
                            echo "<p style='margin-top: 18px;'>Hasil estimasi berhasil disimpan</p>";
                        } else {
                            
                            echo "<p style='margin-top: 18px;'>Data sudah pernah diestimasi dan ada di daftar hasil estimasi</p>";
                        }

                        // Tutup koneksi database
                        $conn->close();
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

document.getElementById('tahun').addEventListener('change', function() {
    updatePeriode();
});

document.getElementById('Bulan').addEventListener('change', function() {
    updatePeriode();
});

function updatePeriode() {
    var tahun = document.getElementById('tahun').value;
    var bulan = document.getElementById('Bulan').value;
    var periodeSelect = document.getElementById('hari');
    periodeSelect.innerHTML = '<option value="">Pilih Periode Bulan</option>'; // Reset options

    var start = 0;
    var end = 0;

    if (tahun === "2023") {
        start = 49;
        end = 60;
    } else if (tahun === "2024") {
        start = 61;
        end = 72;
    } else if (tahun === "2025") {
        start = 73;
        end = 84;
    } else if (tahun === "2026") {
        start = 85;
        end = 96;
    } else if (tahun === "2027") {
        start = 97;
        end = 108;
    } else if (tahun === "2028") {
        start = 109;
        end = 120;
    } else if (tahun === "2029") {
        start = 121;
        end = 132;
    }

    if (bulan) {
        var bulanIndex = parseInt(bulan) - 1;
        var selectedPeriode = start + bulanIndex;
        var option = document.createElement('option');
        option.value = selectedPeriode;
        option.text = selectedPeriode;
        option.selected = true;
        periodeSelect.appendChild(option);
    } else {
        for (var i = start; i <= end; i++) {
            var option = document.createElement('option');
            option.value = i;
            option.text = i;
            periodeSelect.appendChild(option);
        }
    }
}
</script>
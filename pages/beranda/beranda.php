<div class="content-wrapper" style="margin-top: 5vh;">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Welcome <?php echo $username; ?></h3>
                    <h6 class="font-weight-normal mb-">Selamat datang di Sistem Estimasi Timbulan Sampah Menggunakan
                        Algoritma Rgeresi Linear Sederhana.</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card tale-bg">
                <div class="card-people mt-auto">
                    <img src="images/dashboard/people.svg" alt="people">
                    <div class="weather-info">
                        <div class="d-flex">
                            <div>
                                <!-- Menampilkan suhu cuaca Manado -->
                                <!-- <h2 class="mb-0 font-weight-normal"><i
                                        class="icon-sun mr-2"></i><?php echo $temp; ?><sup>C</sup></h2> -->
                            </div>
                            <div class="ml-2">
                                <h4 class="location font-weight-normal">Indonesia</h4>
                                <h6 class="font-weight-normal">Tondano</h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
        // Lakukan impor koneksi ke database
        include 'conf/conf.php';

        // Ambil jumlah dataset dari tabel Sampah
        $sql_jumlah_dataset = "SELECT COUNT(*) as total FROM sampah";
        $result_jumlah_dataset = $conn->query($sql_jumlah_dataset);
        $row_jumlah_dataset = $result_jumlah_dataset->fetch_assoc();
        $jumlah_dataset = $row_jumlah_dataset['total'];

        // Ambil jumlah hasil estimasi dari tabel Hasil Prediksi
        $sql_jumlah_estimasi = "SELECT COUNT(*) as total FROM hasil_prediksi";
        $result_jumlah_estimasi = $conn->query($sql_jumlah_estimasi);
        $row_jumlah_estimasi = $result_jumlah_estimasi->fetch_assoc();
        $jumlah_estimasi = $row_jumlah_estimasi['total'];

        // Ambil jumlah user dari tabel Users
        $sql_jumlah_user = "SELECT COUNT(*) as total FROM users";
        $result_jumlah_user = $conn->query($sql_jumlah_user);
        $row_jumlah_user = $result_jumlah_user->fetch_assoc();
        $jumlah_user = $row_jumlah_user['total'];

        // Tutup koneksi database
        $conn->close();
        ?>

        <div class="col-md-6 grid-margin transparent">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                        <div class="card-body">
                            <p class="mb-4">Jumlah Dataset</p>
                            <p class="fs-30 mb-2"><?php echo $jumlah_dataset; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Hasil Estimasi</p>
                            <p class="fs-30 mb-2"><?php echo $jumlah_estimasi; ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <?php
    include 'conf/conf.php';
    // Ambil data dari tabel sampah
    $sql = "SELECT * FROM Sampah";
    $result = $conn->query($sql);

    // Hitung jumlah total baris yang dikembalikan oleh hasil query
    $total_rows = $result->num_rows;

    // Ambil data dari tabel sampah
    $sql = "SELECT * FROM Hasil_prediksi";
    $result = $conn->query($sql);

    // Hitung jumlah total baris yang dikembalikan oleh hasil query
    $total_prediksi = $result->num_rows;

    ?>

</div>

<div class="content-wrapper spasi">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Grafik Dataset</h4>
                    <div class="form-group">
                        <label for="tahunFilter">Pilih Tahun:</label>
                        <select class="form-control" id="tahunFilter" name="tahunFilter" required>
                            <?php
                            // Generate options for tahun from 2019 to current year + 5
                            for ($i = 2019; $i <= date("Y") ; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </div>

                    

                    <button type="button" class="btn btn-primary mr-2" onclick="updateChart()">Filter</button>
                    <canvas id="chart-sampah"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Lakukan impor koneksi ke database
include 'conf/conf.php';

// Ambil data dari tabel Sampah
$sql_sampah = "SELECT tahun, bulan, timbulan_sampah FROM sampah";
$result_sampah = $conn->query($sql_sampah);

// Variabel untuk menyimpan data dari tabel Sampah
$data_sampah = [];
while ($row = $result_sampah->fetch_assoc()) {
    $data_sampah[] = [
        'tahun' => $row['tahun'],
        'bulan' => $row['bulan'],
        'hasil' => $row['timbulan_sampah']
    ];
}

// Tutup koneksi database
$conn->close();
?>

<!-- Chart Sampah -->
<script>
// Inisialisasi chart pertama kali
var chartSampah;

// Ambil data dari PHP dan konversi ke JavaScript untuk tabel Sampah
var dataSampah = <?php echo json_encode($data_sampah); ?>;

// Proses data untuk Chart.js
var labelsSampah = [];
var dataSampahValues = [];

dataSampah.forEach(function(item) {
    labelsSampah.push(item.tahun + '-' + item.bulan);
    dataSampahValues.push(item.hasil);
});

// Buat grafik untuk tabel Sampah dengan Chart.js
var ctxSampah = document.getElementById('chart-sampah').getContext('2d');
chartSampah = new Chart(ctxSampah, {
    type: 'line',
    data: {
        labels: labelsSampah,
        datasets: [{
            label: 'Timbulan Sampah',
            data: dataSampahValues,
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            xAxes: [{
                type: 'linear',
                position: 'bottom'
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        plugins: {
            datalabels: {
                display: false,
            },
        },
        legend: {
            display: true,
            position: 'top',
            align: 'end',
            labels: {
                filter: function(legendItem, chartData) {
                    var index = chartData.datasets[legendItem.datasetIndex]._meta[0].index;
                    return chartData.datasets[legendItem.datasetIndex].data[index] >
                        0; // Display legend only if data > 0
                }
            }
        },
    }
});

function updateChart() {
    // Ambil nilai filter dari formulir
    var selectedTahun = document.getElementById('tahunFilter').value;
    
    // Filter dataSampah sesuai dengan tahun dan bulan yang dipilih
    var filteredDataSampah = dataSampah.filter(function(item) {
        return item.tahun == selectedTahun ;
    });

    console.log('Filtered Data:', filteredDataSampah); // Tambahkan pernyataan log ini

    // Proses data untuk Chart.js
    labelsSampah = [];
    dataSampahValues = [];

    filteredDataSampah.forEach(function(item) {
        labelsSampah.push(item.tahun + '-' + item.bulan);
        dataSampahValues.push(item.hasil);
    });

    console.log('Labels:', labelsSampah); // Tambahkan pernyataan log ini
    console.log('Data Values:', dataSampahValues); // Tambahkan pernyataan log ini

    // Update data chart
    chartSampah.data.labels = labelsSampah;
    chartSampah.data.datasets[0].data = dataSampahValues;

    // Redraw chart
    chartSampah.update();
}
</script>


<div class="content-wrapper spasi">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Grafik Hasil Estimasi</h4>
                    <div class="form-group">
                        <label for="tahunFilterPrediksi">Pilih Tahun:</label>
                        <select class="form-control" id="tahunFilterPrediksi" name="tahunFilterPrediksi" required>
                            <?php
                            // Generate options for tahun from 2019 to current year + 5
                            for ($i = 2023; $i <= date("Y") + 3; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </div>

                    

                    <button type="button" class="btn btn-primary mr-2" onclick="updateEstimasi()">Filter</button>
                    <canvas id="chart-hasil-prediksi"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
// Lakukan impor koneksi ke database
include 'conf/conf.php';

// Ambil data dari tabel Hasil Prediksi
$sql_prediksi = "SELECT tahun, bulan, hasil_prediksi FROM hasil_prediksi";
$result_prediksi = $conn->query($sql_prediksi);

// Variabel untuk menyimpan data dari tabel Hasil Prediksi
$data_prediksi = [];
while ($row = $result_prediksi->fetch_assoc()) {
    $data_prediksi[] = [
        'tahun' => $row['tahun'],
        'bulan' => $row['bulan'],
        'hasil' => $row['hasil_prediksi']
    ];
}

// Tutup koneksi database
$conn->close();
?>

<!-- Chart Hasil Prediksi -->
<script>
// Inisialisasi chart untuk hasil prediksi
var chartPrediksi;

// Ambil data dari PHP dan konversi ke JavaScript untuk tabel Hasil Prediksi
var dataPrediksi = <?php echo json_encode($data_prediksi); ?>;

// Proses data untuk Chart.js
var labelsPrediksi = [];
var dataPrediksiValues = [];

dataPrediksi.forEach(function(item) {
    labelsPrediksi.push(item.tahun + '-' + item.bulan);
    dataPrediksiValues.push(item.hasil);
});

// Buat grafik untuk tabel Hasil Prediksi dengan Chart.js
var ctxPrediksi = document.getElementById('chart-hasil-prediksi').getContext('2d');
chartPrediksi = new Chart(ctxPrediksi, {
    type: 'line',
    data: {
        labels: labelsPrediksi,
        datasets: [{
            label: 'Hasil Estimasi Timbulan Sampah',
            data: dataPrediksiValues,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            xAxes: [{
                type: 'linear',
                position: 'bottom'
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        plugins: {
            datalabels: {
                display: false,
            },
        },
        legend: {
            display: true,
            position: 'top',
            align: 'end',
            labels: {
                filter: function(legendItem, chartData) {
                    var index = chartData.datasets[legendItem.datasetIndex]._meta[0].index;
                    return chartData.datasets[legendItem.datasetIndex].data[index] > 0;
                }
            }
        },
    }
});

function updateEstimasi() {
    // Ambil nilai filter dari formulir
    var selectedTahun = document.getElementById('tahunFilterPrediksi').value;

    // Filter dataPrediksi sesuai dengan tahun dan bulan yang dipilih
    var filteredDataPrediksi = dataPrediksi.filter(function(item) {
        return item.tahun == selectedTahun ;
    });

    console.log('Filtered Data:', filteredDataPrediksi); // Tambahkan pernyataan log ini

    // Proses data untuk Chart.js
    var labelsPrediksiFiltered = [];
    var dataPrediksiValuesFiltered = [];

    filteredDataPrediksi.forEach(function(item) {
        labelsPrediksiFiltered.push(item.tahun + '-' + item.bulan);
        dataPrediksiValuesFiltered.push(item.hasil);
    });

    console.log('Labels:', labelsPrediksiFiltered); // Tambahkan pernyataan log ini
    console.log('Data Values:', dataPrediksiValuesFiltered); // Tambahkan pernyataan log ini

    // Update data chart
    chartPrediksi.data.labels = labelsPrediksiFiltered;
    chartPrediksi.data.datasets[0].data = dataPrediksiValuesFiltered;

    // Redraw chart
    chartPrediksi.update();
}
</script>
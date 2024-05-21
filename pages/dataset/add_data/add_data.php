<?php
// Include file konfigurasi database
include './conf/conf.php';

// Tangani permintaan penambahan data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['q']) && $_GET['q'] == 'add_data') {
    // Ambil data dari formulir
    $tahun = $_POST['tahun'];
    $Bulan = $_POST['Bulan'];
    $hari = $_POST['hari'];
    $timbulan_sampah = $_POST['timbulan_sampah'];

    // Query untuk menambahkan data ke dalam tabel Sampah
    $sql = "INSERT INTO sampah (tahun, Bulan, hari, timbulan_sampah) VALUES ('$tahun', '$Bulan', '$hari', '$timbulan_sampah')";

    if ($conn->query($sql) === TRUE) {
        // Pesan sukses
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data added successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function(){
                    window.location.href = '?q=dataset';
                });
            </script>";
        exit();
    } else {
        // Pesan error
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error adding data: " . $conn->error . "',
                    showConfirmButton: false,
                    timer: 2500
                });
            </script>";
    }
}
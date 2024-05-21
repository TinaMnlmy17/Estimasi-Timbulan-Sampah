<?php
// Include file konfigurasi database
include './conf/conf.php';

// Tangani permintaan pengeditan data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['q']) && $_GET['q'] == 'editproses') {
    // Ambil data dari formulir
    $id = $_POST['id'];
    $tahun = $_POST['tahun'];
    $Bulan = $_POST['Bulan'];
    $hari = $_POST['hari'];
    $timbulan_sampah = $_POST['timbulan_sampah'];

    // Query untuk mengupdate data di dalam tabel Sampah
    $sql = "UPDATE sampah SET tahun='$tahun', Bulan='$Bulan', hari='$hari', timbulan_sampah='$timbulan_sampah' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        // Pesan sukses
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data updated successfully!',
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
                    text: 'Error updating data: " . $conn->error . "',
                    showConfirmButton: false,
                    timer: 2500
                });
            </script>";
    }
}
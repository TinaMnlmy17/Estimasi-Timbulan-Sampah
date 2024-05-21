<?php
// Include file konfigurasi database
include './conf/conf.php';

// Tangani permintaan penghapusan data
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['q']) && $_GET['q'] == 'delete_data') {
    // Pastikan id yang akan dihapus sudah disediakan
    if (isset($_GET['id'])) {
        // Ambil id dari parameter GET
        $id = $_GET['id'];

        // Query untuk menghapus data dari tabel Sampah berdasarkan id
        $sql = "DELETE FROM sampah WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            // Pesan sukses jika data berhasil dihapus
            echo "<script>
                    alert('Data deleted successfully!');
                    window.location.href = '?q=dataset';
                </script>";
            exit();
        } else {
            // Pesan error jika terjadi kesalahan dalam penghapusan data
            echo "<script>
                    alert('Error deleting data: " . $conn->error . "');
                    window.location.href = '?q=dataset';
                </script>";
        }
    } else {
        // Jika ID tidak diberikan, berikan pesan kesalahan
        echo "ID not provided.";
    }
}
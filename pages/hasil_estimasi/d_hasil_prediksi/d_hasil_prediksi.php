<?php

include 'conf/conf.php';

function deleteAllData()
{
    global $conn;
    $sql = "TRUNCATE TABLE hasil_prediksi"; // Query to delete all data from Sampah table
    if ($conn->query($sql) === FALSE) {
        echo "Error deleting records: " . $conn->error;
    }
}

// Panggil fungsi untuk menghapus semua data
deleteAllData();

// Redirect ke halaman dataset.php setelah operasi penghapusan selesai
echo "<script>
Swal.fire({
  title: 'Success',
  text: 'All records deleted successfully!',
  icon: 'success',
  confirmButtonText: 'OK'
}).then((result) => {
  if (result.isConfirmed) {
    window.location = '?q=hasil_estimasi';
  }
});
</script>";
?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
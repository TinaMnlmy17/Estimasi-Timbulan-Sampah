<?php
// Masukkan file konfigurasi database
include '../conf/conf.php';
?>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php
        // Ambil data dari formulir pendaftaran
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hash password sebelum menyimpannya ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Buat dan jalankan query untuk memeriksa apakah username sudah ada di database
        $sql_check_username = "SELECT * FROM users WHERE username='$username'";
        $result_check_username = $conn->query($sql_check_username);

        // Periksa apakah username sudah ada di database
        if ($result_check_username->num_rows > 0) {
            echo "Swal.fire({
                title: 'Oops!',
                text: 'Username sudah digunakan. Silakan gunakan username lain.',
                icon: 'error'
            }).then(function() {
                window.location = '../register.php';
            });";
        } else {
            // Buat dan jalankan query untuk menyimpan data pengguna ke dalam tabel database
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                echo "Swal.fire({
                    title: 'Success!',
                    text: 'Pendaftaran berhasil. Silakan login.',
                    icon: 'success'
                }).then(function() {
                    window.location = '../index.php';
                });";
            } else {
                echo "Swal.fire({
                    title: 'Oops!',
                    text: 'Error: " . $conn->error . "',
                    icon: 'error'
                }).then(function() {
                    window.location = '../register.php';
                });";
            }
        }
        ?>
    });
</script>

<?php
// Tutup koneksi
$conn->close();
?>
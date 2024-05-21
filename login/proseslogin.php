<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    include '../conf/conf.php';
    // Mulai session
    session_start();
    // Ambil data dari formulir login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Buat dan jalankan query untuk memeriksa apakah username sudah ada di database
    $sql_check_username = "SELECT * FROM users WHERE username='$username'";
    $result_check_username = $conn->query($sql_check_username);

    if ($result_check_username->num_rows > 0) {
        // Username ditemukan, periksa password
        $row = $result_check_username->fetch_assoc();
        $hashed_password = $row['password'];
        if (password_verify($password, $hashed_password)) {
            // Simpan username dalam session
            $_SESSION['username'] = $username;
            // Password cocok, proses login
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Login berhasil.',
                        icon: 'success'
                    }).then(function() {
                        window.location = '../dashboard.php';
                    });
                  </script>";
        } else {
            // Password tidak cocok
            echo "<script>
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Password salah.',
                        icon: 'error'
                    }).then(function() {
                        window.location = '../index.php';
                    });
                  </script>";
        }
    } else {
        // Username tidak ditemukan
        echo "<script>
                Swal.fire({
                    title: 'Oops!',
                    text: 'Username tidak ditemukan.',
                    icon: 'error'
                }).then(function() {
                    window.location = '../index.php';
                });
              </script>";
    }

    ?>
</body>

</html>
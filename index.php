<?php
session_start();
// Cek apakah pengguna sudah login, jika ya, arahkan ke dashboard.php
if (isset($_SESSION["username"])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login</title>

    <link rel="stylesheet" href="vendors/feather/feather.css" />
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css" />

    <link rel="stylesheet" href="css/vertical-layout-light/style.css" />
    <link rel="stylesheet" href="css/stylebaru3.css">

    <link rel="shortcut icon" href="images/iconkecil.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="images/logologin1.png" alt="logo" style="width: 200;" />
                            </div>

                            <form class="pt-3" method="POST" action="login/proseslogin.php">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" id="username"
                                        name="username" placeholder="Nama Pengguna">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" name="password"
                                        id="password" placeholder="Kata Sandi" />
                                </div>
                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Masuk</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Belum memiliki akun?
                                    <a href="register.php" class="text-primary">Daftar</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
</body>

</html>
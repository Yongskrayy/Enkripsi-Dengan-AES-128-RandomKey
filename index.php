<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title>Aplikasi Enkripsi Cahaya Battery</title>

    <link rel="shortcut icon" href="./assets/images/logoutama.png">

    <!-- CSS -->
    <link href="app/dashboard/page/asset/base/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="app/dashboard/page/asset/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="app/dashboard/page/asset/base/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body
    style="margin: 0; height: 100vh; background-image: url('assets/images/bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container" style="display: flex; justify-content: center; align-items: center; height: 100%;">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center">
                                <img src="assets/images/logoutama.png" alt="" class="img-fluid"
                                    style="max-width: 100%;" />
                                <h2 style="margin-top: 10px; text-align: center;">Cahaya Battery</h2>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    <form action="akses.php" method="post">
                                        <div class="inputbox" style="margin-bottom: 15px;">
                                            <input type="text" name="username" autofocus autocomplete="off" required
                                                oninvalid="this.setCustomValidity('Nama Pengguna tidak boleh kosong')"
                                                oninput="setCustomValidity('')" placeholder="Nama Pengguna"
                                                style="width: 100%;">
                                        </div>
                                        <div class="inputbox" style="margin-bottom: 15px;">
                                            <input type="password" name="password" required
                                                oninvalid="this.setCustomValidity('Kata Sandi tidak boleh kosong')"
                                                oninput="setCustomValidity('')" placeholder="Kata Sandi"
                                                style="width: 100%;">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" name="login"
                                            style="width: 100%;">Masuk</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- Bootstrap core JavaScript-->
<script src="app/dashboard/page/asset/base/jquery/jquery.min.js"></script>
<script src="app/dashboard/page/asset/base/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="app/dashboard/page/asset/base/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="app/dashboard/page/asset/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="app/dashboard/page/asset/base/datatables/jquery.dataTables.min.js"></script>
<script src="app/dashboard/page/asset/base/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="app/dashboard/page/asset/js/demo/datatables-demo.js"></script>

</html>
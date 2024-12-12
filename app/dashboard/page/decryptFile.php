<?php
session_start();
include('../../../config.php');

if (empty($_SESSION['username'])) {
    header("Location: ../../../index.php");
    exit();
}

$connect = mysqli_connect($host, $user, $pass, $dbname) or die(mysqli_connect_error());

$last = $_SESSION['username'];
$sqlupdate = "UPDATE users SET last_activity=now() WHERE username='$last'";
$queryupdate = mysqli_query($connect, $sqlupdate);

$user = $_SESSION['username'];
$query = mysqli_query($connect, "SELECT fullname, job_title, last_activity FROM users WHERE username='$user'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $data['fullname']; ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../../../assets/images/logoutama.png">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

    <!-- Custom CSS -->
    <style>
    .table-custom {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
        border-collapse: collapse;
    }

    .table-custom th,
    .table-custom td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table-custom thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .table-custom tbody+tbody {
        border-top: 2px solid #dee2e6;
    }

    .table-custom th {
        background-color: #343a40;
        color: #fff;
    }

    .content-wrapper {
        padding: 20px;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="../../../assets/images/logoutama.png" alt="CahayaBatteryLogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Tombol Logout -->
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="../index.php" class="brand-link">
                <img src="../../../assets/images/logoutama.png" alt="Cahaya Battery Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Cahaya Battery</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="../index.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-fw fa-folder nav-icon"></i>
                                <p>Berkas<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="encrypt.php" class="nav-link">
                                        <i class="fas fa-book nav-icon"></i>
                                        <p>Enkripsi Berkas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="decrypt.php" class="nav-link">
                                        <i class="fas fa-book nav-icon"></i>
                                        <p>Dekripsi Berkas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="daftarList.php" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>Daftar File</p>
                            </a>
                        </li>

                        <?php
                        $v = $_SESSION['username'];
                        $query_user = mysqli_query($connect, "SELECT * FROM users WHERE username='$v'");
                        $users = mysqli_fetch_array($query_user);
                        if ($users['status'] == 1) {
                            echo '
                                <hr class="sidebar-divider d-none d-md-block">
                                <li class="nav-item">
                                    <a class="nav-link" href="datauser.php">
                                        <i class="fas fa-fw fa-user"></i>
                                        <span>Daftar User</span>
                                    </a>
                                </li>';
                        }
                        ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- End of Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Tabel Pengajuan -->
            <section class="content">
                <?php
                $id_file = $_GET['id_file'];
                $query = mysqli_query($connect, "SELECT * FROM file WHERE id_file='$id_file'");
                $data2 = mysqli_fetch_array($query);
                ?>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Dekripsi File - <span
                                style="color:red"><?php echo $data2['file_name_finish'] ?></span></h3>
                    </div>
                    <form action="../decryptProses.php" method="post">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <thead>
                                        <tr>
                                            <th>Nama File Sumber</th>
                                            <th>Nama File Enkripsi</th>
                                            <th>Ukuran File</th>
                                            <th>Tanggal Enkripsi</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $data2['file_name_source']; ?></td>
                                            <td><?php echo $data2['file_name_finish']; ?></td>
                                            <td><?php echo $data2['file_size']; ?> KB</td>
                                            <td><?php echo $data2['tgl_upload']; ?></td>
                                            <td><?php echo $data2['keterangan']; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Masukan Password Untuk Mendekripsi</td>
                                            <td colspan="3">
                                                <input type="hidden" name="fileid"
                                                    value="<?php echo $data2['id_file']; ?>">
                                                <input class="form-control" id="inputPassword" type="password"
                                                    placeholder="Password" name="pwdfile" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">
                                                <button type="submit" class="btn btn-primary"
                                                    name="decrypt_now">Dekripsi File</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- OPTIONAL SCRIPTS -->
    <!-- ChartJS -->
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="../../plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="../../plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="../../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../../plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <!--<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>-->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../../dist/js/pages/dashboard.js"></script>
</body>

</html>
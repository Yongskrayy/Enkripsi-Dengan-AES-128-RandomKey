<?php
session_start();
include('../../config.php');
// memeriksa sesi username kosong atau tidak
if (empty($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit();
}

$connect = mysqli_connect($host, $user, $pass, $dbname) or die(mysqli_connect_error());

// Update last activity time
$last = $_SESSION['username'];
$sqlupdate = "UPDATE users SET last_activity=now() WHERE username='$last'";
$queryupdate = mysqli_query($connect, $sqlupdate);

// Fetch user data=
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
    <link rel="shortcut icon" href="../../assets/images/logoutama.png">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">

    <!-- Your custom CSS -->
    <!--<link rel="stylesheet" href="your-custom.css">-->

    <!-- Example custom CSS -->
    <!--<link rel="stylesheet" href="page/asset/base/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="page/asset/css/sb-admin-2.min.css">
    <link rel="stylesheet" href="../../assets/css/themify-icons.css">
    <link rel="stylesheet" href="page/asset/base/datatables/dataTables.bootstrap4.min.css">-->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="../../assets/images/logoutama.png" alt="CahayaBatteryLogo" height="60"
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
            <!-- /.navbar -->

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Tombol Logout -->
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <img src="../../assets/images/logoutama.png" alt="Cahaya Battery Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Cahaya Battery</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-fw fa-folder nav-icon"></i>
                                <p>
                                    Berkas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="page/encrypt.php" class="nav-link">
                                        <i class="fas fa-book nav-icon"></i>
                                        <p>Enkripsi Berkas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="page/decrypt.php" class="nav-link">
                                        <i class="fas fa-book nav-icon"></i>
                                        <p>Dekripsi Berkas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="page/daftarList.php" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Daftar File
                                </p>
                            </a>
                        </li>
                        <?php
              $v = $_SESSION['username'];
              $query = mysqli_query($connect, "SELECT * FROM users WHERE username='$v'");
              $users = mysqli_fetch_array($query);
              if ($users['status'] == 1) {
                echo '
                      <hr class="sidebar-divider d-none d-md-block">
                      <li class="nav-item">
                         <a class="nav-link" href="page/datauser.php">
                         <i class="fas fa-fw fa-user"></i>
                         <span>Daftar User</span></a>
                      </li>';
              } elseif ($users['status'] == 2) {
                echo "";
              } else {
                echo "";
              }
              ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <?php
                                            $query = mysqli_query($connect, "SELECT count(*) totaluser FROM users");
                                            $datauser = mysqli_fetch_array($query);
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                TOTAL USER
                                            </div>
                                            <div class="h2 text-info mb-4">
                                                <span id="totalUser"><?php echo $datauser['totaluser'] ?></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <?php
                                            $query = mysqli_query($connect, "SELECT count(*) totalencrypt FROM file WHERE status='1'");
                                            $dataencrypt = mysqli_fetch_array($query);
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                ENKRIPSI
                                            </div>
                                            <div class="h2 text-info mb-4">
                                                <span id="totalUser"><?php echo $dataencrypt['totalencrypt'] ?></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="nav-icon fas fa-book text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <?php
                                            $query = mysqli_query($connect, "SELECT count(*) totaldecrypt FROM file WHERE status='2'");
                                            $datadecrypt = mysqli_fetch_array($query);
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                DEKRIPSI
                                            </div>
                                            <div class="h2 text-info mb-4">
                                                <span id="totalUser"><?php echo $datadecrypt['totaldecrypt'] ?></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="nav-icon fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->

                    <!-- Content Row for Pengajuan -->
                    <div class="row mt-4">
                        <div class="col-xl-12">
                            <!-- Your Pengajuan Content Goes Here -->
                            <div class="row">

                                <!-- Deskripsi -->
                                <section>
                                    <div class="card-deskripsi">
                                        <div style="display: flex; align-items: center;">
                                            <img src="../../assets/images/logoutama.png" alt="" width="500"
                                                height="300" />
                                            <h2 style="margin-left: 15px;">Cahaya battery</h2>
                                        </div>
                                        <div class="deskripsi">
                                            <p>Cahaya Battery merupakan salah satu bengkel aki yang berada di Jl.
                                                Kp.Buaran, Rt03/02, Lengkong Karya, kec.Serpong Utara,Kota Tangerang
                                                Selatan, dengan kode pos 15310.
                                            </p>
                                        </div>
                                    </div>
                                </section>

                            </div>
                        </div>
                    </div>
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <footer class="main-footer">
            <div class="text-center my-auto">
                <strong>Cahaya battery</strong>
            </div>
        </footer>
        <!-- /.footer -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- ChartJS -->
    <script src="../plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="../plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="../plugins/moment/moment.min.js"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <!-- <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
     AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard.js"></script>
</body>

</html>
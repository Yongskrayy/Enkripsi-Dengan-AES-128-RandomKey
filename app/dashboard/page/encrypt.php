<?php
session_start();
include('../../../config.php');
if (empty($_SESSION['username'])) {
  header("Location: ../../../index.php");
  exit;
}
$connect = mysqli_connect($host, $user, $pass, $dbname) or die(mysqli_connect_error());
$last = $_SESSION['username'];
$sqlupdate = "UPDATE users SET last_activity=now() WHERE username='$last'";
$queryupdate = mysqli_query($connect, $sqlupdate);
?>

<!DOCTYPE html>
<html lang="en">
<?php
$user = $_SESSION['username'];
$query = mysqli_query($connect, "SELECT fullname,job_title,last_activity FROM users WHERE username='$user'");
$data = mysqli_fetch_array($query);
?>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome <?php echo $data['fullname']; ?></title>

    <link rel="shortcut icon" href="../../../assets/images/logoutama.png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

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
            <!-- /.navbar -->

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
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="../index.php" class="nav-link">
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
                         <a class="nav-link" href="datauser.php">
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
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="main-head">
                                        <p class="dash-title">Enkripsi</p>
                                        <p>/ <?php echo $data['fullname']; ?> / Aktivitas Terakhir :
                                            <?php echo $data['last_activity'] ?> </p>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow mb-4">
                                                <!-- Card Body -->
                                                <div class="card-body">
                                                    <h1>Form Pengisian File Enkripsi</h1>
                                                    <p id="statusMessage"></p>

                                                    <!-- Formulir Pengajuan -->
                                                    <form action="../encryptProses.php" method="post"
                                                        enctype="multipart/form-data">
                                                        <div class="form-group">
                                                            <label for="">Tanggal</label>
                                                            <input class="form-control" type="text" id="inputTgl"
                                                                placeholder="Tanggal" name="datenow"
                                                                value="<?php date_default_timezone_set("Asia/Bangkok"); echo date("Y-m-d"); ?>"
                                                                style="background-color: #E3F4F4;" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputFile">File</label>
                                                            <input class="form-control" type="file" id="inputFile"
                                                                placeholder="Input File" name="file"
                                                                style="background-color: #F8F6F4;" value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPassword">Password</label>
                                                            <input class="form-control" type="password"
                                                                id="inputPassword" placeholder="Password Enkripsi"
                                                                name="pwdfile" style="background-color: #F8F6F4;"
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="textArea">Keterangan</label>
                                                            <textarea class="form-control" name="desc" id="textArea"
                                                                rows="3" placeholder="Keterangan File"
                                                                style="background-color: #F8F6F4;"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="submit"
                                                                name="encrypt_now">Enkripsi File</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="../../plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="../../plugins/jqvmap/jquery.vmap.min.js"></script>
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
    <!--<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/pages/dashboard.js"></script>

</body>

</html>
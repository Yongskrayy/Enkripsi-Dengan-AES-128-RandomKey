<?php
session_start();
include('../../../config.php');

// Redirect to login if session username is empty
if (empty($_SESSION['username'])) {
    header("Location: ../../../index.php");
    exit();
}

$connect = mysqli_connect($host, $user, $pass, $dbname) or die(mysqli_connect_error());

// Update last activity time
$last = $_SESSION['username'];
$sqlupdate = "UPDATE users SET last_activity=now() WHERE username='$last'";
$queryupdate = mysqli_query($connect, $sqlupdate);

// Fetch user data
$user = $_SESSION['username'];
$query_user = mysqli_query($connect, "SELECT fullname, job_title, last_activity FROM users WHERE username='$user'");
$data = mysqli_fetch_array($query_user);
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

    <!-- Your custom CSS -->
    <!--<link rel="stylesheet" href="your-custom.css">-->

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
        <!-- End of Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="main-head">
                                        <p class="dash-title">Dekripsi</p>
                                        <p>/ <?php echo $data['fullname']; ?> / Aktivitas Terakhir :
                                            <?php echo $data['last_activity'] ?> </p>
                                    </div>

                                    <!-- Tabel Pengajuan -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama File</th>
                                                    <th>Nama File Enkripsi</th>
                                                    <th>Path File</th>
                                                    <th>Status File</th>
                                                    <th>Opsi</th> <!-- Kolom baru untuk tombol View -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Pengaturan pagination
                                                $results_per_page = 10; // jumlah data per halaman
                                                if (!isset($_GET['page'])) {
                                                    $page = 1;
                                                } else {
                                                    $page = $_GET['page'];
                                                }

                                                $start_from = ($page - 1) * $results_per_page;
                                                
                                                $query = "SELECT * FROM file LIMIT $start_from, $results_per_page";
                                                $result = mysqli_query($connect, $query);
                                                
                                                $i = 1 + ($page - 1) * $results_per_page;

                                                while ($data = mysqli_fetch_array($result)) { ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $data['file_name_source']; ?></td>
                                                    <td><?php echo $data['file_name_finish']; ?></td>
                                                    <td><?php echo $data['file_url']; ?></td>
                                                    <td>
                                                        <?php
                                                            if ($data['status'] == 1) {
                                                                echo "Enkripsi";
                                                            } elseif ($data['status'] == 2) {
                                                                echo "Dekripsi";
                                                            } else {
                                                                echo "Status Tidak Diketahui";
                                                            }
                                                            ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $a = $data['id_file'];
                                                            if ($data['status'] == 1) {
                                                                echo '<a href="decryptFile.php?id_file=' . $a . '" class="action_btn_dekrip">Dekripsi</a>';
                                                            } 
                                                            ?>
                                                        <!-- Add the download button -->
                                                        <a href="..//download.php?id_file=<?php echo $data['id_file']; ?>"
                                                            class="btn btn-primary">Download</a>
                                                    </td>
                                                </tr>
                                                <?php $i++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Tampilkan pagination -->
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-end">
                                            <?php
                                            $query = "SELECT COUNT(id_file) AS total FROM file";
                                            $result = mysqli_query($connect, $query);
                                            $row = mysqli_fetch_array($result);
                                            $total_pages = ceil($row['total'] / $results_per_page);

                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                echo '<li class="page-item"><a class="page-link" href="daftarList.php?page=' . $i . '">' . $i . '</a></li>';
                                            }
                                            ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="text-center my-auto">
                <strong>Cahaya battery</strong>
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="../../dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../../dist/js/pages/dashboard3.js"></script>
</body>

</html>
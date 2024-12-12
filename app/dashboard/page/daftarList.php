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

    <!-- Your custom CSS -->
    <!--<link rel="stylesheet" href="your-custom.css">-->

    <style>
    .pagination {
        justify-content: flex-end;
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
                <!-- Logout Button -->
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
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="../index.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <!-- Berkas -->
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

                        <!-- Daftar File -->
                        <li class="nav-item">
                            <a href="daftarList.php" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Daftar File
                                </p>
                            </a>
                        </li>

                        <!-- Daftar User (if admin) -->
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
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- Card Header -->
                                <div class="card-body">
                                    <div class="main-head">
                                        <p class="dash-title">Daftar File</p>
                                        <p>/ <?php echo $data['fullname']; ?> / Aktivitas Terakhir :
                                            <?php echo $data['last_activity'] ?> </p>
                                    </div>
                                </div>
                                <!-- /.card-header -->

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID File</th>
                                                    <th>Keterangan</th>
                                                    <th>Nama Pengguna</th>
                                                    <th>Nama File</th>
                                                    <th>Nama File Enkripsi</th>
                                                    <th>Ukuran File</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT * FROM file";
                                                $result = mysqli_query($connect, $query);

                                                if ($result && mysqli_num_rows($result) > 0) {
                                                    while ($data = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                <tr>
                                                    <td><?php echo $data['id_file']; ?></td>
                                                    <td><?php echo $data['keterangan']; ?></td>
                                                    <td><?php echo $data['username']; ?></td>
                                                    <td><?php echo $data['file_name_source']; ?></td>
                                                    <td><?php echo $data['file_name_finish']; ?></td>
                                                    <td><?php echo $data['file_size']; ?> KB</td>
                                                    <td>
                                                        <?php
                                                                if ($data['status'] == 1) {
                                                                    echo "<span class='badge badge-success'>Terenkripsi</span>";
                                                                } elseif ($data['status'] == 2) {
                                                                    echo "<span class='badge badge-primary'>Terdekripsi</span>";
                                                                } else {
                                                                    echo "<span class='badge badge-danger'>Status Tidak Diketahui</span>";
                                                                }
                                                                ?>
                                                    </td>
                                                    <td>
                                                        <a href="../hapus.php?id_file=<?php echo $data['id_file']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">
                                                            <i class="fas fa-trash-alt"></i> Hapus
                                                            <a href="../download.php?id_file=<?php echo $data['id_file']; ?>"
                                                                class="btn btn-sm btn-success"
                                                                onclick="return confirm('Apakah anda yakin ingin mendownload file ini?');">
                                                                <i class="fas fa-download"></i> Download
                                                    </td>
                                                </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='9'>Tidak ada data</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-end mt-3">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <?php
                                                // Query total rows
                                                $query_count = "SELECT COUNT(*) AS total_rows FROM file";
                                                $result_count = mysqli_query($connect, $query_count);
                                                $row_count = mysqli_fetch_assoc($result_count);
                                                $total_rows = $row_count['total_rows'];

                                                // Number of records per page
                                                $records_per_page = 3;

                                                // Calculate total pages
                                                $total_pages = ceil($total_rows / $records_per_page);

                                                // Current page
                                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                                                $page = max($page, 1);
                                                $page = min($page, $total_pages);

                                                // Offset for the query
                                                $offset = ($page - 1) * $records_per_page;

                                                // Previous Page
                                                if ($page > 1) {
                                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
                                                } else {
                                                    echo '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
                                                }

                                                // Page numbers
                                                for ($i = 1; $i <= $total_pages; $i++) {
                                                    if ($i == $page) {
                                                        echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                                                    } else {
                                                        echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                                    }
                                                }

                                                // Next Page
                                                if ($page < $total_pages) {
                                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
                                                } else {
                                                    echo '<li class="page-item disabled"><span class="page-link">Next</span></li>';
                                                }
                                                ?>
                                            </ul>
                                        </nav>
                                    </div>
                                    <!-- /.pagination -->
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <footer class="main-footer">
            <div class="text-center my-auto">
                <strong>Cahaya Battery</strong>
            </div>
        </footer>
        <!-- /.footer -->
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

    <!-- Your custom scripts -->
    <!--<script src="your-custom.js"></script>-->

</body>

</html>
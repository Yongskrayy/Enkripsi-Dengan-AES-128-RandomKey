<?php
session_start();
include('../../../config.php');


// Set the default timezone to your preferred timezone
date_default_timezone_set('Asia/Jakarta'); // Example for Jakarta time

// Fetch user data
$user = $_SESSION['username'];
$query = mysqli_query($connect, "SELECT fullname, job_title, last_activity FROM users WHERE username='$user'");
$data = mysqli_fetch_array($query);

// Proses tambah user
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $job_title = $_POST['job_title'];
    $status = 2;

    $insert_query = "INSERT INTO users (username, password, fullname, job_title, status, join_date) VALUES ('$username', '$password', '$fullname', '$job_title', '$status', NOW())";
    if (mysqli_query($connect, $insert_query)) {
        echo "<script>alert('User berhasil ditambahkan');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menambahkan user');</script>";
    }
}

// Proses edit user (termasuk edit password)
if (isset($_POST['edit_user'])) {
    $edit_username = $_POST['edit_username'];
    $new_username = $_POST['new_username']; // Added new username field
    $edit_fullname = $_POST['edit_fullname'];
    $edit_job_title = $_POST['edit_job_title'];
    $edit_password = $_POST['edit_password'];

    // Jika password diisi, enkripsi password baru
    if (!empty($edit_password)) {
        $edit_password_hashed = $edit_password;
        $update_query = "UPDATE users SET username='$new_username', fullname='$edit_fullname', job_title='$edit_job_title', password='$edit_password_hashed' WHERE username='$edit_username'";
    } else {
        // Jika password tidak diisi, update tanpa mengubah password
        $update_query = "UPDATE users SET username='$new_username', fullname='$edit_fullname', job_title='$edit_job_title' WHERE username='$edit_username'";
    }

    if (mysqli_query($connect, $update_query)) {
        echo "<script>alert('User berhasil diupdate');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengupdate user');</script>";
    }
}

// Proses hapus user
if (isset($_POST['delete_user'])) {
    $delete_username = $_POST['delete_username'];

    $delete_query = "DELETE FROM users WHERE username='$delete_username'";
    if (mysqli_query($connect, $delete_query)) {
        echo "<script>alert('User berhasil dihapus');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus user');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

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
        <div class="container-fluid">
            <div class="content-wrapper">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Daftar User</h1>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah User</button>

                        <div class="modal fade" id="addModal" tabindex="-1" role="dialog"
                            aria-labelledby="addModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addModalLabel">Tambah User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" action="">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" name="username"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="fullname">Fullname</label>
                                                <input type="text" class="form-control" id="fullname" name="fullname"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="job_title">Job Title</label>
                                                <input type="text" class="form-control" id="job_title" name="job_title"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary"
                                                name="add_user">Tambah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3"></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><strong>Username</strong></th>
                                                <th><strong>Fullname</strong></th>
                                                <th><strong>Job Title</strong></th>
                                                <th><strong>Join Date</strong></th>
                                                <th><strong>Action</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                    $query = mysqli_query($connect, "SELECT * FROM users");
                                                    while ($data = mysqli_fetch_array($query)) { ?>
                                            <tr>
                                                <td><?php echo $data['username']; ?></td>
                                                <td><?php echo $data['fullname']; ?></td>
                                                <td><?php echo $data['job_title']; ?></td>
                                                <td><?php echo $data['join_date']; ?></td>
                                                <td>
                                                    <!-- Tombol Edit -->
                                                    <a href="#" class="btn btn-sm btn-warning edit-btn"
                                                        data-toggle="modal"
                                                        data-target="#editModal<?php echo $data['username']; ?>">Edit</a>
                                                    <!-- Tombol Hapus -->
                                                    <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                        data-toggle="modal"
                                                        data-target="#deleteModal<?php echo $data['username']; ?>">Delete</button>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit untuk setiap user -->
                                            <div class="modal fade" id="editModal<?php echo $data['username']; ?>"
                                                tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form method="POST" action="">
                                                            <div class="modal-body">
                                                                <!-- Tampilkan data yang akan diubah -->
                                                                <input type="hidden" name="edit_username"
                                                                    value="<?php echo $data['username']; ?>">
                                                                <div class="form-group">
                                                                    <label for="new_username">New Username</label>
                                                                    <input type="text" class="form-control"
                                                                        id="new_username" name="new_username"
                                                                        value="<?php echo $data['username']; ?>"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="edit_fullname">Fullname</label>
                                                                    <input type="text" class="form-control"
                                                                        id="edit_fullname" name="edit_fullname"
                                                                        value="<?php echo $data['fullname']; ?>"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="edit_job_title">Job Title</label>
                                                                    <input type="text" class="form-control"
                                                                        id="edit_job_title" name="edit_job_title"
                                                                        value="<?php echo $data['job_title']; ?>"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="edit_password">New Password</label>
                                                                    <input type="password" class="form-control"
                                                                        id="edit_password" name="edit_password">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary"
                                                                    name="edit_user">Save Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Delete untuk setiap user -->
                                            <div class="modal fade" id="deleteModal<?php echo $data['username']; ?>"
                                                tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel">Delete User
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form method="POST" action="">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="delete_username"
                                                                    value="<?php echo $data['username']; ?>">
                                                                <p>Are you sure you want to delete user
                                                                    <?php echo $data['username']; ?>?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger"
                                                                    name="delete_user">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
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
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../../dist/js/pages/dashboard.js"></script>

</body>

</html>
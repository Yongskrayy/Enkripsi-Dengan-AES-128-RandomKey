<?php
 session_start();

 // menghubungkan dengan config.php
 include 'config.php';

 $username = $_POST['username'];
 $password = $_POST['password'];

 $data = mysqli_query($connect, "select * from users where username='$username' and password='$password'");

 $cek = mysqli_num_rows($data);

 if($cek > 0){
    $_SESSION['username'] = $username;
    $_SESSION['status'] = "login";
    header("location: app/dashboard/index.php");
 }else{
    echo "<script>
    alert('Username atau Password yang anda masukan salah');
    window.location='index.php';
    </script>";
 }

?>
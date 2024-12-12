<?php
session_start();
include "../../config.php";
include "../algoritm/AES.php";

// Modifikasi menggabungkan key
function combineKeys($inputKey, $randomKey)
{
    $combinedKey = $randomKey . $inputKey;
    $finalKey = substr(md5($combinedKey), 0, 16); // mengambil 16 karakter pertama
    return $finalKey;
}

if (isset($_POST['encrypt_now'])) {
    $user = $_SESSION['username']; // mengambil data pengguna
    $inputKey = mysqli_real_escape_string($connect, $_POST["pwdfile"]); //mengamankan kuci pengguna
    $randomKey = bin2hex(random_bytes(8)); // Akan menghasilkan 8 byte acak yang dimana menghasilkan 16 karakter heksadesimal
    $key = combineKeys($inputKey, $randomKey); // menggabungkan kunci untuk menghasilkan kunci sepanjang 16 karakter

    $deskripsi = mysqli_real_escape_string($connect, $_POST['desc']); // mengamankan file input

    $file_tmpname = $_FILES['file']['tmp_name']; // mengambil nama file sementara

    // Untuk nama file url
    $file = rand(1000, 100000) . "-" . $_FILES['file']['name']; // menghasilkan nama supaya tidak bentrok
    $new_file_name = strtolower($file); // mengubah menjadi huruf kecil
    $final_file = str_replace(' ', '-', $new_file_name); // mengganti nama hubung 

    // Untuk nama file
    $filename = rand(1000, 100000) . "-" . pathinfo($_FILES['file']['name'], PATHINFO_FILENAME); // menghasilkan nama file unik
    $new_filename = strtolower($filename); // mengubah menjadi huruf kecil
    $finalfile = str_replace(' ', '-', $new_filename);
    $size = filesize($file_tmpname);
    $size2 = (filesize($file_tmpname)) / 1024; // menyimpan ukuran file dalam byte 1024
    $info = pathinfo($final_file); // mengambil informasi path
    $file_source = fopen($file_tmpname, 'rb'); //membuka file untuk di proses
    $ext = $info["extension"]; //mengambil informasi path
    // format file
    if ($ext == "docx" || $ext == "doc" || $ext == "pdf" || $ext == "xls" || $ext == "xlsx") {
    } else {
        echo ("<script language='javascript'>
          window.location.href='page/encrypt.php';
          window.alert('Maaf, file yang bisa dienkrip hanya word, excel, ataupun pdf.');
          </script>");
        exit();
    }
    // besar size file
    if ($size2 > 5000) {
        echo ("<script language='javascript'>
        window.location.href='page/encrypt.php';
        window.alert('Maaf, file tidak bisa lebih besar dari 5MB.');
        </script>");
        exit();
    }
    // Auto increment
    $queryinc = "SELECT MAX(id_file) as max_id FROM file"; // untuk mendapat nilai max dari id_file
    $result = mysqli_query($connect, $queryinc);
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['max_id']; // 

    // Membuat ID baru dengan menambahkan 1 ke nilai terakhir
    $newId = $lastId + 1; // menambah id baru

    $sql1 = "INSERT INTO file VALUES ('$newId', '$user', '$final_file', '$finalfile.rda', '', '$size2', '$inputKey', '$randomKey', now(), '1', '$deskripsi')";
    $query1 = mysqli_query($connect, $sql1) or die(mysqli_error($connect));

    $sql2 = "select * from file where file_url =''"; //mencari kolom file yang belum diisi
    $query2 = mysqli_query($connect, $sql2) or die(mysqli_error($connect));

    $url = $finalfile . ".rda"; // membuat nama file menjadi rda
    $file_url = "file_encrypt/$url"; // menentukan path file enkripsi

    $sql3 = "UPDATE file SET file_url ='$file_url' WHERE file_url=''"; // memperbaharui path
    $query3 = mysqli_query($connect, $sql3) or die(mysqli_error($connect));

    $file_output = fopen($file_url, 'wb'); //membuka file (write binary)

    $mod = $size % 16; // menghitung jumlah blok
    if ($mod == 0) {
        $banyak = $size / 16;
    } else {
        $banyak = ($size - $mod) / 16; // menghitung jumlah yang dapat ditampung 
        $banyak = $banyak + 1; // menambah 1 blok bila tidak penuh
    }

    // memeriksa valid file yang di upload 
    if (is_uploaded_file($file_tmpname)) {
        ini_set('max_execution_time', -1); //mengatur batas waktu
        ini_set('memory_limit', -1); // mengatur batas memory
        $aes = new AES($key); // menyiapkan objek untuk enkripsi 
        $start_time = microtime(true); // pengukuran waktu proses

        // membaca data dalam blok 16 byte
        for ($bawah = 0; $bawah < $banyak; $bawah++) { 
            $data = fread($file_source, 16); //membaca 16 byte data
            $cipher = $aes->encrypt($data); // menggunakan objek AES untuk enkripsi data
            fwrite($file_output, $cipher); //menulis data ter enkripsi
        }
        fclose($file_source); //menutup file
        fclose($file_output);

        // Mengukur waktu selesai enkripsi
        $end_time = microtime(true);

        // Menghitung kecepatan enkripsi
        $elapsed_time = $end_time - $start_time;
        $limit = round($elapsed_time, 2);

        echo ("<script language='javascript'>
          window.location.href='page/encrypt.php';
          window.alert('Enkripsi File Berhasil, Kecepatan Enkripsi: $limit detik');
          </script>");
    } else {
        echo ("<script language='javascript'>
          window.location.href='page/encrypt.php';
          window.alert('Enkripsi File mengalami masalah');
          </script>");
    }
}
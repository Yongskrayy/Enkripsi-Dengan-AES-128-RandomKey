<?php
session_start();
include "../../config.php";
include "../algoritm/AES.php";

$idfile    = mysqli_real_escape_string($connect, $_POST['fileid']); // menyimpan id file 
$pwdfile   = mysqli_real_escape_string($connect, $_POST["pwdfile"]); // menyimpan pass
$query     = "SELECT password FROM file WHERE id_file='$idfile' AND password='$pwdfile'"; // memastikan password dan id yang sesuai
$sql       = mysqli_query($connect, $query);
// menghitung baris query
if (mysqli_num_rows($sql) > 0) {
    $query1     = "SELECT * FROM file WHERE id_file='$idfile'"; //memilih kolom id file
    $sql1       = mysqli_query($connect, $query1);
    $data       = mysqli_fetch_assoc($sql1); //menyimpan data

    $file_path  = $data["file_url"]; // mengambil data path file
    $inputKey   = $data["password"]; //mengambil data pass
    $randomKey  = $data["random_key"]; // mengambil data random key
    $key        = combineKeys($inputKey, $randomKey); //penggabungan kunci
    $file_name  = $data["file_name_source"]; // mengambil nama file
    $size       = $data["file_size"]; // mengambil ukuran file

    $file_size  = filesize($file_path); // mendapat ukuran file

    $query2     = "UPDATE file SET status='2' WHERE id_file='$idfile'"; // memperbaharui database id file
    $sql2       = mysqli_query($connect, $query2);

    $mod        = $file_size % 16; // menghitung susa hasil bagi ukuran file 16

    $aes        = new AES($key); // membuat parameter dari kelas AES dangan key
    $fopen1     = fopen($file_path, "rb"); // membuka file yang dipilih
    $cache      = "file_decrypt/$file_name"; // menyusun path untuk dekripsi
    $fopen2     = fopen($cache, "wb"); // membuka data hasil dekripsi (write binary)

    if ($mod == 0) {
        $banyak = $file_size / 16; // menghitung ukuran file 
    } else {
        $banyak = ($file_size - $mod) / 16; // memproses jumlah blok penuh 
        $banyak = $banyak + 1; // menambah 1 blok tambahan
    }

    ini_set('max_execution_time', -1); // mengatur batas waktu
    ini_set('memory_limit', -1); // mengatur batas memory
    $start_time = microtime(true); // mencatat waktu

    // loop jumlah blok 16 byte
    for ($bawah = 0; $bawah < $banyak; $bawah++) {
        $filedata    = fread($fopen1, 16); //membaca 16 byte
        $plain       = $aes->decrypt($filedata); //mendekripsi data dengan AES
        fwrite($fopen2, $plain); // menulis data yang telah didekripsi
    }
    fclose($fopen1); // menutup file
    fclose($fopen2);

    // Mengukur waktu selesai dekripsi
    $end_time = microtime(true);

    // Menghitung kecepatan dekripsi
    $elapsed_time = $end_time - $start_time;
    $limit = round($elapsed_time, 2);

    echo ("<script language='javascript'>
       window.location.href='page/decrypt.php';
       window.alert('Dekripsi File Berhasil, Kecepatan Dekripsi: $limit detik');
       </script>
       ");
} else {
    echo ("<script language='javascript'>
    window.location.href='page/decryptFile.php?id_file=$idfile';
    window.alert('Maaf, Password tidak sesuai');
    </script>");
}

// Modifikasi untuk menggabungkan key
function combineKeys($inputKey, $randomKey)
{
    $combinedKey = $randomKey . $inputKey;
    $finalKey = substr(md5($combinedKey), 0, 16); // mengambil 16 karakter pertama
    return $finalKey;
}
?>
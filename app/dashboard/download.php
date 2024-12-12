<?php
include "../../config.php";

$id_file = $_GET['id_file'];

// Ambil nama file yang terenkripsi dari database
$quer1 = mysqli_query($connect, "SELECT file_name_source FROM file WHERE id_file='$id_file'");
$row = mysqli_fetch_assoc($quer1);

if ($row) {
    $fileEnkripsi = "file_decrypt/" . $row['file_name_source'];

    // Pastikan file ada dan dapat dibaca
    if (file_exists($fileEnkripsi)) {
        // Atur header untuk download file
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate");
        header("Content-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Transfer-Encoding: binary");
        header("Content-Disposition: attachment; filename=\"" . basename($fileEnkripsi) . "\"");
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . filesize($fileEnkripsi));
        
        // Buka file untuk dibaca
        $fileHandle = fopen($fileEnkripsi, "rb");
        if ($fileHandle === false) {
            die("Error: Tidak dapat membuka file.");
        }

        // Lakukan output buffer secara manual
        while (!feof($fileHandle)) {
            echo fread($fileHandle, 8192);
            flush();
        }
        
        fclose($fileHandle);

        // Setelah selesai download, arahkan ke halaman download
        header("Location: download/"); // Ganti dengan direktori yang sesuai
        exit();
    } else {
        die("Error: File tidak ditemukan atau tidak dapat diakses.");
    }
} else {
    echo "File tidak ditemukan.";
}
?>
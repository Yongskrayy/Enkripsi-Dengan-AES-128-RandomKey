<?php
include "../../config.php";

$id_file = $_GET['id_file'];

// Fetch both file_name_finish and file_name_source
$quer1 = mysqli_query($connect, "SELECT file_name_finish, file_name_source FROM file WHERE id_file='$id_file'");
$row = mysqli_fetch_assoc($quer1);

$fileEnkripsi = "file_encrypt/" . $row['file_name_finish'];
$fileDekripsi = "file_decrypt/" . $row['file_name_source'];

$query = mysqli_query($connect, "DELETE FROM file WHERE id_file='$id_file'");

if ($query) {
    if (file_exists($fileEnkripsi)) {
        unlink($fileEnkripsi);
    } else {
        echo "<script>alert('Encrypted file not found!');</script>";
    }

    if (file_exists($fileDekripsi)) {
        unlink($fileDekripsi);
    } else {
        echo "<script>alert('Decrypted file not found!');</script>";
    }
    
    echo "<script>alert('File Berhasil dihapus!'); window.location = 'page/daftarList.php'</script>";
} else {
    echo "<script>alert('File Gagal dihapus!'); window.location = 'page/daftarList.php'</script>";
}
?>
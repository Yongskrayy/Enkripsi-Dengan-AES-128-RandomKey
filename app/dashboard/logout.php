<?php
session_start();
session_unset(); // mengkosongkan array $_session
session_destroy(); //menghapus semua sesi data terbaru
echo '<script>alert("Logout berhasil."); window.location.href = "../../index.php";</script>';
?>
<?php
include_once("koneksi.php");

// Pastikan parameter ID dikirim lewat URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // ubah ke integer untuk keamanan

    // Cek dulu apakah data film dengan ID tersebut ada
    $cek = mysqli_query($conn, "SELECT * FROM film WHERE film_id = $id");
    if (mysqli_num_rows($cek) == 0) {
        echo "<script>alert('❌ Data film tidak ditemukan!'); window.location='admin.php';</script>";
        exit;
    }

    // Hapus data film berdasarkan ID
    $stmt = mysqli_prepare($conn, "DELETE FROM film WHERE film_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $hapus = mysqli_stmt_execute($stmt);

    if ($hapus) {
        // Jika berhasil, kembali ke halaman admin
        header("Location: admin.php?status=deleted");
        exit;
    } else {
        echo "❌ Gagal menghapus film: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "❌ Parameter ID tidak ditemukan!";
}
?>

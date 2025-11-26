<?php
include 'koneksi.php';

// 1. LOGIKA UBAH STATUS
if(isset($_GET['status']) && isset($_GET['id'])){
    $id = $_GET['id'];
    $st = $_GET['status'];
    mysqli_query($conn, "UPDATE transactions SET status='$st' WHERE id='$id'");
    header("location:laporan.php"); // Kembali otomatis
}

// 2. LOGIKA HAPUS TRANSAKSI (Sesuai diskusi kita sebelumnya)
if(isset($_GET['hapus'])){
    $id_transaksi = $_GET['hapus'];
    
    // Hapus anaknya dulu (detail)
    mysqli_query($conn, "DELETE FROM transaction_details WHERE id_transaksi='$id_transaksi'");
    
    // Hapus induknya (invoice)
    mysqli_query($conn, "DELETE FROM transactions WHERE id='$id_transaksi'");

    echo "<script>alert('Data Transaksi Berhasil Dihapus'); window.location='laporan.php';</script>";
}
?>
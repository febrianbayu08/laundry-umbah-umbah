<?php 
include 'koneksi.php';
$id = $_GET['id'];

// Ambil Data Transaksi Lengkap
$data = mysqli_query($conn, "SELECT t.*, c.nama as nama_pelanggan, p.nama_paket, p.harga, d.qty 
                             FROM transactions t
                             JOIN customers c ON t.id_member = c.id
                             JOIN transaction_details d ON t.id = d.id_transaksi
                             JOIN packages p ON d.id_paket = p.id
                             WHERE t.id='$id'");
$trx = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran</title>
    <style>
        body { font-family: 'Courier New', monospace; width: 300px; }
        .header, .footer { text-align: center; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        .flex { display: flex; justify-content: space-between; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h3>LAUNDRY SMK</h3>
        <p>Jl. Pendidikan No. 1<br>Telp: 0812-3456-7890</p>
    </div>

    <div class="line"></div>

    <div>
        No Nota : <?= $trx['kode_invoice']; ?><br>
        Tanggal : <?= date('d/m/Y H:i', strtotime($trx['tgl'])); ?><br>
        Pelanggan: <b><?= $trx['nama_pelanggan']; ?></b>
    </div>

    <div class="line"></div>

    <div class="flex">
        <span><?= $trx['nama_paket']; ?></span>
    </div>
    <div class="flex">
        <span><?= $trx['qty']; ?> Kg x Rp <?= number_format($trx['harga']); ?></span>
        <span>Rp <?= number_format($trx['qty'] * $trx['harga']); ?></span>
    </div>

    <div class="line"></div>

    <div class="flex">
        <b>TOTAL BAYAR</b>
        <b>Rp <?= number_format($trx['qty'] * $trx['harga']); ?></b>
    </div>

    <div class="line"></div>

    <div class="footer">
        <p>Terima Kasih Atas Kunjungan Anda<br>Barang yang tidak diambil > 1 bulan<br>bukan tanggung jawab kami.</p>
    </div>

</body>
</html>
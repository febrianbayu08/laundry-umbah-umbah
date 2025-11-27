<?php 
include 'koneksi.php';
$id = $_GET['id'];

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
    <title>Struk - PIKUCEK!</title>
    <style>
        body { font-family: 'Courier New', monospace; width: 300px; margin: 0; padding: 10px; }
        .header, .footer { text-align: center; }
        .header h3 { margin: 0; font-size: 22px; font-weight: 800; font-style: italic; } /* Font agak miring biar keren */
        .header p { margin: 5px 0; font-size: 12px; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        .flex { display: flex; justify-content: space-between; font-size: 12px; }
        .info { font-size: 12px; margin-bottom: 5px; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h3>PIKUCEK!</h3>
        <p>Jalan Remang Senja No 12,<br>Laweyan, Surakarta<br>Telp: 0812-3456-7890</p>
    </div>

    <div class="line"></div>

    <div class="info">
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

    <div class="flex" style="font-weight: bold; font-size: 14px;">
        <span>TOTAL BAYAR</span>
        <span>Rp <?= number_format($trx['qty'] * $trx['harga']); ?></span>
    </div>

    <div class="line"></div>

    <div class="footer">
        <p style="font-size: 11px;">~ Terima Kasih Kakak! ~<br>
        Barang tidak diambil > 1 bulan<br>
        bukan tanggung jawab kami.</p>
    </div>

</body>
</html>
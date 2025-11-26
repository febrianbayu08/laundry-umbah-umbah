<?php include 'header.php'; ?>

<div class="card shadow border-0 mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-file-invoice"></i> Laporan Transaksi</h5>
    </div>
    <div class="card-body">
        
        <form method="GET" class="row g-3 mb-4 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold">Dari Tanggal</label>
                <input type="date" name="tgl_mulai" class="form-control" value="<?php echo isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : date('Y-m-01'); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Sampai Tanggal</label>
                <input type="date" name="tgl_selesai" class="form-control" value="<?php echo isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : date('Y-m-d'); ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                <a href="laporan.php" class="btn btn-outline-secondary"><i class="fas fa-sync"></i> Reset</a>
                <button type="button" onclick="exportExcel()" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle" id="tabelLaporan">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tgl Masuk</th>
                        <th>Kode Invoice</th>
                        <th>Pelanggan</th>
                        <th>Paket</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // LOGIKA FILTER TANGGAL
                    $tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : date('Y-m-01');
                    $tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : date('Y-m-d');
                    
                    // Tambahkan jam agar filter akurat (00:00:00 sampai 23:59:59)
                    $mulai = $tgl_mulai . " 00:00:00";
                    $selesai = $tgl_selesai . " 23:59:59";

                    $no = 1;
                    $query = "SELECT t.*, c.nama as nama_pelanggan, p.nama_paket, d.qty, (p.harga * d.qty) as total_bayar 
                              FROM transactions t 
                              JOIN customers c ON t.id_member = c.id 
                              JOIN transaction_details d ON t.id = d.id_transaksi
                              JOIN packages p ON d.id_paket = p.id
                              WHERE t.tgl BETWEEN '$mulai' AND '$selesai'
                              ORDER BY t.id DESC";
                              
                    $data = mysqli_query($conn, $query);
                    $total_omset_periode = 0; // Variabel hitung total bawah

                    while($row = mysqli_fetch_array($data)){
                        $total_omset_periode += $row['total_bayar'];
                        
                        // Warna Status
                        $badge = 'secondary';
                        if($row['status'] == 'baru') $badge = 'primary';
                        if($row['status'] == 'proses') $badge = 'warning';
                        if($row['status'] == 'selesai') $badge = 'success';
                        if($row['status'] == 'diambil') $badge = 'dark';
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tgl'])); ?></td>
                        <td><span class="badge bg-light text-dark border"><?= $row['kode_invoice']; ?></span></td>
                        <td class="fw-bold"><?= $row['nama_pelanggan']; ?></td>
                        <td><?= $row['nama_paket']; ?> <small class="text-muted">(<?= $row['qty']; ?>)</small></td>
                        <td>Rp <?= number_format($row['total_bayar']); ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-<?= $badge; ?> dropdown-toggle py-0 px-2" type="button" data-bs-toggle="dropdown">
                                    <?= strtoupper($row['status']); ?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="proses_laporan.php?id=<?= $row['id']; ?>&status=proses">Proses Cuci</a></li>
                                    <li><a class="dropdown-item" href="proses_laporan.php?id=<?= $row['id']; ?>&status=selesai">Selesai</a></li>
                                    <li><a class="dropdown-item" href="proses_laporan.php?id=<?= $row['id']; ?>&status=diambil">Sudah Diambil</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <a href="cetak_struk.php?id=<?= $row['id']; ?>" target="_blank" class="btn btn-sm btn-info text-white" title="Struk"><i class="fas fa-print"></i></a>
                            <a href="proses_laporan.php?hapus=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus transaksi ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot class="bg-light fw-bold">
                    <tr>
                        <td colspan="5" class="text-end">TOTAL PENDAPATAN PERIODE INI:</td>
                        <td colspan="3" class="text-primary fs-5">Rp <?= number_format($total_omset_periode); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
function exportExcel() {
    // Trik sederhana mengubah tabel HTML menjadi file Excel
    var html = document.querySelector("#tabelLaporan").outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html);
    var link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", "Laporan_Laundry.xls");
    link.click();
}
</script>

</div></body></html>
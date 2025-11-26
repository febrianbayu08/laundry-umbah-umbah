<?php include 'header.php'; 

// Tambah Paket Baru
if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $harga = $_POST['harga'];
    // URUTAN BENAR: nama_paket diisi $nama, jenis diisi $jenis
mysqli_query($conn, "INSERT INTO packages (id_outlet, nama_paket, jenis, harga) VALUES (1, '$nama', '$jenis', '$harga')");
    echo "<script>alert('Paket Berhasil Ditambah'); window.location='paket.php';</script>";
}

// Hapus Paket
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM packages WHERE id='$id'");
    echo "<script>window.location='paket.php';</script>";
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-box-open"></i> Daftar Layanan & Harga</h3>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPaket">
        <i class="fas fa-plus"></i> Tambah Paket
    </button>
</div>

<div class="row">
    <?php
    $data = mysqli_query($conn, "SELECT * FROM packages");
    while($p = mysqli_fetch_array($data)){
        // Logika Ikon & Warna berdasarkan jenis
        $icon = "fa-tshirt"; 
        $warna = "primary"; // Biru default
        
        if($p['jenis'] == 'bed_cover') { $icon = "fa-bed"; $warna = "info"; }
        if($p['jenis'] == 'kaos') { $icon = "fa-socks"; $warna = "warning"; }
        if($p['harga'] > 20000) { $warna = "danger"; } // Mahal warna merah
    ?>
    
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-transparent border-0 text-center mt-3">
                <i class="fas <?php echo $icon; ?> fa-4x text-<?php echo $warna; ?>"></i>
            </div>
            <div class="card-body text-center">
                <h5 class="card-title font-weight-bold"><?php echo $p['nama_paket']; ?></h5>
                <span class="badge bg-<?php echo $warna; ?> mb-2"><?php echo strtoupper($p['jenis']); ?></span>
                <h4 class="text-primary fw-bold">Rp <?php echo number_format($p['harga']); ?></h4>
            </div>
            <div class="card-footer bg-transparent border-0 text-center mb-3">
                <a href="paket.php?hapus=<?php echo $p['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus paket ini?')">Hapus</a>
            </div>
        </div>
    </div>
    
    <?php } ?>
</div>

<div class="modal fade" id="modalPaket" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Paket Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST">
      <div class="modal-body">
        <div class="mb-3">
            <label>Nama Paket</label>
            <input type="text" name="nama" class="form-control" required placeholder="Contoh: Cuci Boneka">
        </div>
        <div class="mb-3">
            <label>Jenis</label>
            <select name="jenis" class="form-control">
                <option value="kiloan">Kiloan</option>
                <option value="selimut">Selimut/Bedcover</option>
                <option value="kaos">Satuan (Sepatu/Tas/Dll)</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div></body></html>
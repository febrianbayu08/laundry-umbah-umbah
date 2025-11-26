<?php include 'header.php'; 

// --- LOGIKA 1: TAMBAH DATA (CREATE) ---
if(isset($_POST['tambah'])){
    $nama = $_POST['nama'];
    $hp   = $_POST['hp'];
    $alamat = $_POST['alamat']; // Tambahan kolom alamat

    $simpan = mysqli_query($conn, "INSERT INTO customers (nama, telp, alamat) VALUES ('$nama', '$hp', '$alamat')");
    
    if($simpan){
        echo "<script>
            Swal.fire('Berhasil!', 'Data pelanggan disimpan.', 'success').then(() => {
                window.location='pelanggan.php';
            });
        </script>";
    } else {
        echo "<script>Swal.fire('Gagal', 'Terjadi kesalahan sistem', 'error');</script>";
    }
}

// --- LOGIKA 2: HAPUS DATA (DELETE) ---
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    
    // Cek dulu apakah pelanggan ini punya transaksi?
    // (Kita tidak boleh menghapus pelanggan yang datanya dipakai di Laporan Transaksi)
    $cek_transaksi = mysqli_query($conn, "SELECT * FROM transactions WHERE id_member='$id'");
    
    if(mysqli_num_rows($cek_transaksi) > 0){
        // Jika pelanggan sudah pernah laundry, DILARANG hapus (demi keamanan data laporan)
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menghapus!',
                text: 'Pelanggan ini memiliki riwayat transaksi. Data tidak boleh dihapus demi arsip laporan.',
            }).then(() => {
                window.location='pelanggan.php';
            });
        </script>";
    } else {
        // Jika bersih (belum pernah laundry), BOLEH hapus
        $hapus = mysqli_query($conn, "DELETE FROM customers WHERE id='$id'");
        if($hapus){
            echo "<script>
                Swal.fire('Terhapus!', 'Data pelanggan berhasil dihapus.', 'success').then(() => {
                    window.location='pelanggan.php';
                });
            </script>";
        }
    }
}
?>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-user-plus"></i> Tambah Pelanggan</h6>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="mb-3">
                        <label>Nomor HP (WhatsApp)</label>
                        <input type="text" name="hp" class="form-control" required placeholder="0812...">
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat Singkat"></textarea>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-users"></i> Data Pelanggan Terdaftar</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $data = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC");
                            while($d = mysqli_fetch_array($data)){
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td><b><?php echo $d['nama']; ?></b></td>
                                <td><?php echo $d['telp']; ?></td>
                                <td><small><?php echo $d['alamat']; ?></small></td>
                                <td class="text-center">
                                    <a href="pelanggan.php?hapus=<?php echo $d['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Yakin ingin menghapus data <?php echo $d['nama']; ?>?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div></body></html>
<?php include 'header.php'; 

// LOGIKA PENYIMPANAN DATA
if(isset($_POST['bayar'])){
    $pelanggan = $_POST['id_member'];
    $paket_id  = $_POST['id_paket']; // Isinya format: "ID,HARGA" (contoh: "1,7000")
    $berat     = $_POST['qty'];
    
    // Pecah data paket untuk mendapatkan ID murni dan Harga
    $pecah = explode(",", $paket_id);
    $id_paket_asli = $pecah[0];
    // $harga_paket = $pecah[1]; // Tidak perlu disimpan, cuma buat hitung di JS
    
    // VALIDASI: Cek apakah user sudah pilih paket atau belum
    if($id_paket_asli == 0) {
        // Tampilkan Error pakai SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Mohon pilih paket laundry terlebih dahulu.',
            });
        </script>";
    } else {
        // Generate Nomor Invoice Otomatis (INV-TahunBulanTanggalJamMenitDetik)
        $invoice = "INV-".date('YmdHis');
        $tgl = date('Y-m-d H:i:s');
    
        // 1. Simpan ke Tabel Transaksi Utama
        $query_trx = mysqli_query($conn, "INSERT INTO transactions (kode_invoice, id_member, tgl, status, dibayar) VALUES ('$invoice', '$pelanggan', '$tgl', 'baru', 'dibayar')");
        
        if($query_trx){
            // 2. Ambil ID dari transaksi yang barusan dibuat
            $id_transaksi = mysqli_insert_id($conn);
    
            // 3. Simpan Detail Barang/Paket
            mysqli_query($conn, "INSERT INTO transaction_details (id_transaksi, id_paket, qty) VALUES ('$id_transaksi', '$id_paket_asli', '$berat')");
        
            // Tampilkan Sukses pakai SweetAlert
            echo "<script>
                Swal.fire({
                    title: 'Transaksi Berhasil!',
                    text: 'Data telah disimpan. Lanjut cetak struk?',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lihat Laporan',
                    cancelButtonText: 'Tetap Disini'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'laporan.php';
                    }
                });
            </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white p-3 rounded-top-4">
                <h5 class="mb-0"><i class="fas fa-cash-register me-2"></i> Input Transaksi Baru</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-primary">Pilih Pelanggan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                            <select name="id_member" class="form-select" required>
                                <option value="">-- Cari Nama Pelanggan --</option>
                                <?php
                                $cust = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC");
                                while($c = mysqli_fetch_array($cust)){
                                    echo "<option value='{$c['id']}'>{$c['nama']} (No HP: {$c['telp']})</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-text"><a href="pelanggan.php" class="text-decoration-none">Pelanggan belum terdaftar? Klik disini.</a></div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-primary">Pilih Layanan / Paket</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-box-open"></i></span>
                            <select name="id_paket" id="paket" class="form-select" onchange="hitung()" required>
                                <option value="0,0">-- Pilih Paket Laundry --</option>
                                <?php
                                $pkt = mysqli_query($conn, "SELECT * FROM packages ORDER BY nama_paket ASC");
                                while($p = mysqli_fetch_array($pkt)){
                                    echo "<option value='{$p['id']},{$p['harga']}'>{$p['nama_paket']} - Rp " . number_format($p['harga']) . " / " . strtoupper($p['jenis']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-primary">Berat (Kg) / Jumlah (Pcs)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-weight-hanging"></i></span>
                            <input type="number" name="qty" id="berat" class="form-control" value="1" min="1" step="0.1" onkeyup="hitung()" onchange="hitung()" required>
                        </div>
                    </div>

                    <div class="alert alert-success text-end shadow-sm border-0">
                        <span class="text-muted small">Estimasi Total Biaya:</span>
                        <h1 class="fw-bold mb-0 text-success">Rp <span id="total">0</span></h1>
                    </div>

                    <button type="submit" name="bayar" class="btn btn-primary w-100 btn-lg shadow fw-bold mt-2">
                        <i class="fas fa-save me-2"></i> SIMPAN & PROSES
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function hitung() {
    // 1. Ambil nilai dari elemen input
    var paket_string = document.getElementById('paket').value; // Isinya "ID,HARGA"
    var berat = document.getElementById('berat').value;
    
    // 2. Pecah string paket untuk ambil harganya saja (data setelah koma)
    // Contoh: "5,7000" -> split(',') -> ["5", "7000"]
    var harga = paket_string.split(',')[1];
    
    // 3. Pastikan angka valid
    if(isNaN(harga) || isNaN(berat)){
        harga = 0;
    }

    // 4. Hitung Total
    var total_bayar = harga * berat;
    
    // 5. Tampilkan ke layar dengan format Rupiah (tanpa refresh)
    document.getElementById('total').innerHTML = new Intl.NumberFormat('id-ID').format(total_bayar);
}
</script>

</div> </body>
</html>
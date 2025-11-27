<?php include 'header.php'; 

// --- LOGIKA BACKEND ---
if(isset($_POST['bayar'])){
    $pelanggan = $_POST['id_member'];
    $paket_id  = $_POST['id_paket']; 
    $berat     = $_POST['qty'];
    
    $pecah = explode(",", $paket_id);
    $id_paket_asli = $pecah[0];
    
    if($id_paket_asli == 0) {
        echo "<script>Swal.fire({icon: 'error', title: 'Gagal!', text: 'Mohon pilih paket laundry terlebih dahulu.'});</script>";
    } else {
        $invoice = "INV-".date('YmdHis');
        $tgl = date('Y-m-d H:i:s');
    
        $query_trx = mysqli_query($conn, "INSERT INTO transactions (kode_invoice, id_member, tgl, status, dibayar) VALUES ('$invoice', '$pelanggan', '$tgl', 'baru', 'dibayar')");
        
        if($query_trx){
            $id_transaksi = mysqli_insert_id($conn);
            mysqli_query($conn, "INSERT INTO transaction_details (id_transaksi, id_paket, qty) VALUES ('$id_transaksi', '$id_paket_asli', '$berat')");
        
            echo "<script>
                Swal.fire({
                    title: 'Berhasil Disimpan!',
                    text: 'Transaksi baru telah berhasil ditambahkan.',
                    icon: 'success',
                    confirmButtonColor: '#004e92', // Warna tombol disesuaikan tema
                    showCancelButton: true,
                    confirmButtonText: 'Lihat Laporan',
                    cancelButtonText: 'Input Lagi'
                }).then((result) => {
                    if (result.isConfirmed) { window.location = 'laporan.php'; }
                });
            </script>";
        } else {
            echo "Error Database: " . mysqli_error($conn);
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white p-4 rounded-top-4" style="background: linear-gradient(135deg, #000428 0%, #004e92 100%);">
                <h5 class="mb-0 fw-bold"><i class="fas fa-cash-register me-2"></i> Input Transaksi Baru</h5>
                <small class="opacity-75">Masukkan data pelanggan dan paket dengan teliti</small>
            </div>
            
            <div class="card-body p-4">
                <form method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Pelanggan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-secondary border-end-0"><i class="fas fa-user"></i></span>
                            <select name="id_member" class="form-select border-start-0 ps-0" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php
                                $cust = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC");
                                while($c = mysqli_fetch_array($cust)){
                                    echo "<option value='{$c['id']}'>{$c['nama']} ({$c['telp']})</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-text text-end">
                            <a href="pelanggan.php" class="text-decoration-none fw-bold small text-primary">
                                + Pelanggan Baru
                            </a>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Layanan & Paket</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-secondary border-end-0"><i class="fas fa-box-open"></i></span>
                            <select name="id_paket" id="paket" class="form-select border-start-0 ps-0" onchange="hitung()" required>
                                <option value="0,0">-- Pilih Paket --</option>
                                <?php
                                $pkt = mysqli_query($conn, "SELECT * FROM packages ORDER BY nama_paket ASC");
                                while($p = mysqli_fetch_array($pkt)){
                                    
                                    // --- LOGIKA SATUAN OTOMATIS ---
                                    $satuan = "Pcs"; 
                                    $nama_kecil = strtolower($p['nama_paket']); // Ubah ke huruf kecil biar gampang dicek

                                    if($p['jenis'] == 'kiloan'){
                                        $satuan = "Kg";
                                    } elseif(strpos($nama_kecil, 'sepatu') !== false){
                                        $satuan = "Pasang";
                                    } elseif(strpos($nama_kecil, 'karpet') !== false){
                                        $satuan = "m (Meter)"; // INI YANG KAMU MINTA
                                    }
                                    
                                    echo "<option value='{$p['id']},{$p['harga']}'>{$p['nama_paket']} - Rp " . number_format($p['harga']) . " / $satuan</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Jumlah / Berat / Luas</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-secondary border-end-0"><i class="fas fa-calculator"></i></span>
                            <input type="number" name="qty" id="berat" class="form-control border-start-0 ps-0" value="1" min="1" step="0.1" onkeyup="hitung()" onchange="hitung()" required>
                        </div>
                    </div>

                    <div class="card bg-light border-0 p-3 mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small fw-bold text-uppercase">Total Biaya</span>
                            <h2 class="fw-bold mb-0 text-dark">Rp <span id="total">0</span></h2>
                        </div>
                    </div>

                    <button type="submit" name="bayar" class="btn btn-primary w-100 py-3 rounded-3 fw-bold border-0 shadow-sm" 
                            style="background: linear-gradient(135deg, #000428 0%, #004e92 100%);">
                        <i class="fas fa-save me-2"></i> PROSES TRANSAKSI
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function hitung() {
    var paket_string = document.getElementById('paket').value;
    var berat = document.getElementById('berat').value;
    var harga = paket_string.split(',')[1];
    if(isNaN(harga) || isNaN(berat) || harga === undefined){ harga = 0; }
    var total_bayar = harga * berat;
    document.getElementById('total').innerHTML = new Intl.NumberFormat('id-ID').format(total_bayar);
}
</script>

</div></body></html>
<?php include 'header.php'; 

// --- BAGIAN 1: LOGIKA DATA (SAMA SEPERTI SEBELUMNYA) ---
// Hitung Total Pelanggan
$q_cust = mysqli_query($conn, "SELECT COUNT(*) as total FROM customers");
$d_cust = mysqli_fetch_assoc($q_cust);
$cust   = $d_cust['total'];

// Hitung Sedang Proses
$q_proses = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions WHERE status != 'diambil'");
$d_proses = mysqli_fetch_assoc($q_proses);
$proses   = $d_proses['total'];

// Hitung Total Omset
$q_duit = mysqli_query($conn, "SELECT SUM(p.harga * d.qty) as total FROM transaction_details d JOIN packages p ON d.id_paket = p.id");
$duit = mysqli_fetch_assoc($q_duit);

// --- BAGIAN 2: DATA GRAFIK 7 HARI ---
$tgl_grafik = [];
$total_grafik = [];
for ($i = 6; $i >= 0; $i--) {
    $tgl = date('Y-m-d', strtotime("-$i days"));
    $tgl_tampil = date('d/M', strtotime("-$i days"));
    $query_omset = mysqli_query($conn, "SELECT COALESCE(SUM(p.harga * d.qty), 0) as total 
                                        FROM transactions t
                                        JOIN transaction_details d ON t.id = d.id_transaksi
                                        JOIN packages p ON d.id_paket = p.id
                                        WHERE DATE(t.tgl) = '$tgl'");
    $data_omset = mysqli_fetch_assoc($query_omset);
    $tgl_grafik[] = $tgl_tampil;
    $total_grafik[] = $data_omset['total'];
}
?>

<style>
    /* Gradient Modern Professional */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0061ff 0%, #60efff 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    /* Efek Kartu */
    .card-dashboard {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        color: white;
        overflow: hidden; /* Agar hiasan tidak keluar kotak */
        position: relative;
    }
    .card-dashboard:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
    
    /* Hiasan Ikon Besar Transparan */
    .icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem;
        opacity: 0.2;
        transform: rotate(-15deg);
    }
</style>

<div class="row mb-4 align-items-center">
    <div class="col-md-12">
        <h2 class="fw-bold text-dark mb-1">Dashboard Overview</h2>
        <p class="text-secondary">Ringkasan performa <b>Umbah Umbah Laundry</b> hari ini.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card card-dashboard bg-gradient-primary shadow h-100">
            <div class="card-body p-4">
                <h6 class="text-uppercase fw-bold text-white-50 mb-2">Total Pelanggan</h6>
                <div class="d-flex align-items-center">
                    <h2 class="fw-bold mb-0 display-5"><?php echo $cust; ?></h2>
                    <span class="ms-2 small">Orang</span>
                </div>
                <i class="fas fa-users icon-bg"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card card-dashboard bg-gradient-warning shadow h-100">
            <div class="card-body p-4">
                <h6 class="text-uppercase fw-bold text-white-50 mb-2">Sedang Dicuci</h6>
                <div class="d-flex align-items-center">
                    <h2 class="fw-bold mb-0 display-5"><?php echo $proses; ?></h2>
                    <span class="ms-2 small">Transaksi</span>
                </div>
                <i class="fas fa-tshirt icon-bg"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card card-dashboard bg-gradient-success shadow h-100">
            <div class="card-body p-4">
                <h6 class="text-uppercase fw-bold text-white-50 mb-2">Omset Keseluruhan</h6>
                <div class="d-flex align-items-center">
                    <h3 class="fw-bold mb-0">Rp <?php echo number_format($duit['total'] ?? 0); ?></h3>
                </div>
                <i class="fas fa-wallet icon-bg"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                <h6 class="m-0 fw-bold text-primary"><i class="fas fa-chart-area me-2"></i>Trend Pendapatan (7 Hari)</h6>
                <span class="badge bg-light text-secondary">Realtime Update</span>
            </div>
            <div class="card-body">
                <canvas id="myChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="m-0 fw-bold text-dark"><i class="fas fa-compass me-2"></i>Aksi Cepat</h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                
                <a href="transaksi.php" class="btn btn-primary btn-lg mb-3 shadow-sm rounded-3 py-3 d-flex align-items-center justify-content-between">
                    <span><i class="fas fa-plus-circle me-2"></i> Transaksi Baru</span>
                    <i class="fas fa-chevron-right small"></i>
                </a>
                
                <a href="laporan.php" class="btn btn-light btn-lg mb-3 shadow-sm rounded-3 py-3 d-flex align-items-center justify-content-between text-start text-dark">
                    <span><i class="fas fa-file-invoice me-2 text-secondary"></i> Laporan Keuangan</span>
                    <i class="fas fa-chevron-right small text-muted"></i>
                </a>

                <a href="paket.php" class="btn btn-light btn-lg shadow-sm rounded-3 py-3 d-flex align-items-center justify-content-between text-start text-dark">
                    <span><i class="fas fa-box me-2 text-secondary"></i> Kelola Paket</span>
                    <i class="fas fa-chevron-right small text-muted"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('myChart');
    // Membuat Gradient untuk area bawah grafik agar terlihat modern
    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 97, 255, 0.5)'); // Warna atas (biru terang)
    gradient.addColorStop(1, 'rgba(0, 97, 255, 0.0)'); // Warna bawah (transparan)

    new Chart(ctx, {
        type: 'line', 
        data: {
            labels: <?php echo json_encode($tgl_grafik); ?>,
            datasets: [{
                label: 'Pendapatan',
                data: <?php echo json_encode($total_grafik); ?>,
                borderColor: '#0061ff', // Garis Biru Modern
                backgroundColor: gradient, // Pakai gradient yang dibuat diatas
                borderWidth: 3,
                tension: 0.4, // Kurva halus
                fill: true,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#0061ff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }, // Hilangkan legenda biar bersih
                tooltip: {
                    backgroundColor: '#1e1e1e',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    border: { display: false },
                    grid: {
                        color: '#f0f0f0',
                        borderDash: [5, 5]
                    },
                    ticks: {
                        font: { family: "'Poppins', sans-serif", size: 11 },
                        callback: function(value) { return 'Rp ' + (value/1000) + 'k'; } // Singkat angka (misal 10k)
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: "'Poppins', sans-serif", size: 11 }
                    }
                }
            }
        }
    });
</script>

</div> </body>
</html>
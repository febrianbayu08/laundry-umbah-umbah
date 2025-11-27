<?php
session_start();
include 'koneksi.php';

// Logika Login
if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
    if(mysqli_num_rows($cek) > 0){
        $data = mysqli_fetch_assoc($cek);
        $_SESSION['status'] = "login";
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];
        
        // Redirect pakai script biar smooth
        echo "<script>window.location='index.php';</script>";
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PIKUCEK! Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Background Midnight Blue Professional */
            background: linear-gradient(135deg, #000428 0%, #004e92 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            width: 100%; max-width: 400px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4); /* Bayangan lebih dalam */
            padding: 40px;
        }
        .brand-icon {
            width: 80px; height: 80px;
            /* Ikon senada dengan background */
            background: linear-gradient(135deg, #000428, #004e92);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 35px;
            margin: 0 auto 20px auto;
            box-shadow: 0 10px 20px rgba(0, 78, 146, 0.3);
        }
        .btn-primary-custom {
            background: linear-gradient(90deg, #000428 0%, #004e92 100%);
            border: none; padding: 12px;
            border-radius: 8px; font-weight: 600;
        }
        .btn-primary-custom:hover {
            box-shadow: 0 5px 15px rgba(0, 78, 146, 0.4);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-icon">
            <i class="fas fa-soap"></i>
        </div>

        <div class="text-center mb-4">
            <h4 class="fw-bold text-dark">PIKUCEK!</h4>
            <p class="text-muted small">Silakan login untuk mengelola laundry</p>
        </div>

        <?php if(isset($error)) { ?>
            <div class="alert alert-danger py-2 text-center small border-0 shadow-sm mb-4">
                <i class="fas fa-exclamation-circle me-1"></i> Username / Password Salah!
            </div>
        <?php } ?>

        <form method="POST">
            <div class="form-floating mb-3">
                <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username" required>
                <label for="floatingInput"><i class="fas fa-user me-1"></i> Username</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword"><i class="fas fa-lock me-1"></i> Password</label>
            </div>

            <button type="submit" name="login" class="btn btn-primary btn-primary-custom w-100 text-white">
                MASUK SEKARANG <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="cek_status.php" class="text-decoration-none text-secondary small">
                <i class="fas fa-search me-1"></i> Cek Status Cucian (Pelanggan)
            </a>
        </div>
        
        <div class="text-center mt-4">
             <small class="text-muted" style="font-size: 10px;">&copy; 2025 Umbah Umbah Laundry</small>
        </div>
    </div>

</body>
</html>
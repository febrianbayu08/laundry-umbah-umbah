<?php include 'header.php'; 

if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $role = $_POST['role'];
    
    mysqli_query($conn, "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$user', '$pass', '$role')");
    echo "<script>window.location='pengguna.php';</script>";
}
?>

<h3><i class="fas fa-users-cog"></i> Manajemen Pengguna (Pegawai)</h3>
<hr>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Tambah Pegawai Baru</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-2">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Username</label>
                        <input type="text" name="user" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Password</label>
                        <input type="text" name="pass" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jabatan</label>
                        <select name="role" class="form-control">
                            <option value="kasir">Kasir</option>
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <table class="table table-bordered table-striped bg-white">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no=1;
                $data = mysqli_query($conn, "SELECT * FROM users");
                while($d = mysqli_fetch_array($data)){
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $d['nama']; ?></td>
                    <td><?= $d['username']; ?></td>
                    <td>
                        <span class="badge bg-secondary"><?= strtoupper($d['role']); ?></span>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</div></body></html>
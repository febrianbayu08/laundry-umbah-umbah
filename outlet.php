<?php include 'header.php'; ?>

<h3><i class="fas fa-store"></i> Data Cabang Outlet</h3>
<div class="alert alert-info">Kelola data cabang laundry Anda disini.</div>

<table class="table table-striped mt-3">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Cabang</th>
            <th>Alamat</th>
            <th>No Telepon</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $data = mysqli_query($conn, "SELECT * FROM outlets");
        while($d = mysqli_fetch_array($data)){
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><b><?php echo $d['nama']; ?></b></td>
            <td><?php echo $d['alamat']; ?></td>
            <td><a href="https://wa.me/<?php echo $d['telp']; ?>" class="btn btn-success btn-sm"><i class="fab fa-whatsapp"></i> Hubungi</a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div></body></html>
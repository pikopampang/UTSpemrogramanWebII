<?php
// config.php sudah include di sini
include 'config.php';

// Fungsi toggle order untuk link sorting
function toggleOrder($currentOrder) {
    return $currentOrder === 'ASC' ? 'desc' : 'asc';
}

// Ambil parameter sorting dari URL
$allowed_sort = ['kode_barang', 'jumlah_barang'];
$sort = $_GET['sort'] ?? 'id_barang'; // default sort id_barang (tidak ada link)
$order = $_GET['order'] ?? 'asc';

if (!in_array($sort, $allowed_sort)) {
    $sort = 'id_barang';
}

$order = strtolower($order) == 'desc' ? 'DESC' : 'ASC';

// Query dengan sorting
$sql = "SELECT * FROM tb_inventory ORDER BY $sort $order";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>UTSanugerah - Sistem Inventory Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="index.php">UTSanugerah</a>
  </div>
</nav>

<div class="container mt-4">
    <h1>Inventory Barang</h1>
    <a href="add_item.php" class="btn btn-success mb-3">Tambah Barang</a>
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">
                    <a href="?sort=kode_barang&order=<?= toggleOrder($order) ?>">
                        Kode Barang
                        <?php if ($sort == 'kode_barang') echo $order == 'ASC' ? '▲' : '▼'; ?>
                    </a>
                </th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">
                    <a href="?sort=jumlah_barang&order=<?= toggleOrder($order) ?>">
                        Jumlah Barang
                        <?php if ($sort == 'jumlah_barang') echo $order == 'ASC' ? '▲' : '▼'; ?>
                    </a>
                </th>
                <th class="text-center">Satuan</th>
                <th class="text-center">Harga Beli</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1; // Mulai nomor urut dari 1
        while($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= $no++ ?></td> <!-- Nomor urut PHP -->
                <td><?= htmlspecialchars($row['kode_barang']) ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td><?= $row['jumlah_barang'] ?></td>
                <td><?= htmlspecialchars($row['satuan_barang']) ?></td>
                <td>Rp <?= number_format($row['harga_beli'], 2, ',', '.') ?></td>
                <td><?= $row['status_barang'] ? 'Available' : 'Not Available' ?></td>
                <td>
                    <a href="use_item.php?id=<?= $row['id_barang'] ?>" class="btn btn-primary btn-sm">Pakai</a>
                    <a href="add_stock.php?id=<?= $row['id_barang'] ?>" class="btn btn-success btn-sm">Tambah Stok</a>
                    <a href="edit_item.php?id=<?= $row['id_barang'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_item.php?id=<?= $row['id_barang'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

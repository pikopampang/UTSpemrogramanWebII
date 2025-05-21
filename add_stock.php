<?php
include 'config.php';

if (!isset($_GET['id'])) {
    echo "ID barang tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM tb_inventory WHERE id_barang = $id";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    echo "Barang tidak ditemukan.";
    exit;
}
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tambah = $_POST['jumlah_tambah'];
    if ($tambah < 1) {
        echo "Jumlah yang ditambahkan minimal 1.";
        exit;
    }

    $jumlah_baru = $row['jumlah_barang'] + $tambah;
    $status_baru = $jumlah_baru > 0 ? 1 : 0;

    $stmt = $conn->prepare("UPDATE tb_inventory SET jumlah_barang = ?, status_barang = ? WHERE id_barang = ?");
    $stmt->bind_param("iii", $jumlah_baru, $status_baru, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambahkan stock.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Stock Barang - UTSanugerah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Tambah Stock Barang</h2>
    <div class="card p-3">
        <p><strong>Nama Barang:</strong> <?= $row['nama_barang'] ?></p>
        <p><strong>Stok Sekarang:</strong> <?= $row['jumlah_barang'] ?> <?= $row['satuan_barang'] ?></p>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Jumlah yang ingin ditambahkan</label>
                <input type="number" name="jumlah_tambah" class="form-control" min="1" required>
            </div>
            <button type="submit" class="btn btn-success">Tambah Stock</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
</body>
</html>

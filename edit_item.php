<?php
include 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM tb_inventory WHERE id_barang = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    header("Location: index.php");
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = $_POST['kode_barang'];
    $nama = $_POST['nama_barang'];
    $jumlah = (int)$_POST['jumlah_barang'];
    $satuan = $_POST['satuan_barang'];
    $harga = (float)$_POST['harga_beli'];
    $status = isset($_POST['status_barang']) ? 1 : 0;

    if (!$kode || !$nama || $jumlah < 0 || !$satuan || $harga < 0) {
        $errors[] = "Semua field harus diisi dengan benar.";
    } else {
        $stmt = $conn->prepare("UPDATE tb_inventory SET kode_barang=?, nama_barang=?, jumlah_barang=?, satuan_barang=?, harga_beli=?, status_barang=? WHERE id_barang=?");
        $stmt->bind_param("ssissii", $kode, $nama, $jumlah, $satuan, $harga, $status, $id);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>UTSanugerah - Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="index.php">UTSanugerah</a>
  </div>
</nav>

<div class="container mt-4">
    <h1>Edit Barang</h1>
    <?php if ($errors): ?>
        <div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label>Kode Barang / Barcode</label>
            <input type="text" name="kode_barang" class="form-control" value="<?= htmlspecialchars($data['kode_barang']) ?>" required />
        </div>
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($data['nama_barang']) ?>" required />
        </div>
        <div class="mb-3">
            <label>Jumlah Barang</label>
            <input type="number" name="jumlah_barang" class="form-control" min="0" value="<?= $data['jumlah_barang'] ?>" required />
        </div>
        <div class="mb-3">
            <label>Satuan Barang</label>
            <select name="satuan_barang" class="form-select" required>
                <option value="kg" <?= $data['satuan_barang'] == 'kg' ? 'selected' : '' ?>>kg</option>
                <option value="pcs" <?= $data['satuan_barang'] == 'pcs' ? 'selected' : '' ?>>pcs</option>
                <option value="liter" <?= $data['satuan_barang'] == 'liter' ? 'selected' : '' ?>>liter</option>
                <option value="meter" <?= $data['satuan_barang'] == 'meter' ? 'selected' : '' ?>>meter</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Harga Beli</label>
            <input type="number" step="0.01" name="harga_beli" class="form-control" min="0" value="<?= $data['harga_beli'] ?>" required />
        </div>
        <div class="mb-3">
            <label>Status Barang</label><br />
            <div class="form-check form-check-inline">
                <input type="radio" id="status1" name="status_barang" value="1" <?= $data['status_barang'] ? 'checked' : '' ?> class="form-check-input" />
                <label for="status1" class="form-check-label">Available</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" id="status0" name="status_barang" value="0" <?= !$data['status_barang'] ? 'checked' : '' ?> class="form-check-input" />
                <label for="status0" class="form-check-label">Not Available</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

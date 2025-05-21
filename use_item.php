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
    $pakai = (int)$_POST['jumlah_pakai'];

    if ($pakai <= 0) {
        $errors[] = "Jumlah pakai harus lebih dari 0.";
    } elseif ($pakai > $data['jumlah_barang']) {
        $errors[] = "Jumlah pakai melebihi stok yang tersedia.";
    } else {
        $stok_baru = $data['jumlah_barang'] - $pakai;
        $status_baru = $stok_baru == 0 ? 0 : 1;

        $stmt = $conn->prepare("UPDATE tb_inventory SET jumlah_barang = ?, status_barang = ? WHERE id_barang = ?");
        $stmt->bind_param("iii", $stok_baru, $status_baru, $id);
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
    <title>UTSanugerah - Pemakaian Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="index.php">UTSanugerah</a>
  </div>
</nav>

<div class="container mt-4">
    <h1>Pemakaian Barang: <?= htmlspecialchars($data['nama_barang']) ?></h1>

    <?php if ($errors): ?>
        <div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label>Jumlah Stok Saat Ini: <?= $data['jumlah_barang'] ?> <?= htmlspecialchars($data['satuan_barang']) ?></label>
        </div>
        <div class="mb-3">
            <label>Jumlah Barang yang Dipakai</label>
            <input type="number" name="jumlah_pakai" class="form-control" min="1" max="<?= $data['jumlah_barang'] ?>" required />
        </div>
        <button type="submit" class="btn btn-primary">Gunakan Barang</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

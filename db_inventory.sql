CREATE TABLE `tb_inventory` (
  `id_barang` int(10) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `jumlah_barang` int(10) NOT NULL,
  `satuan_barang` varchar(20) NOT NULL,
  `harga_beli` double(20,2) NOT NULL,
  `status_barang` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_inventory`
--

INSERT INTO `tb_inventory` (`id_barang`, `kode_barang`, `nama_barang`, `jumlah_barang`, `satuan_barang`, `harga_beli`, `status_barang`) VALUES
(1, 'KB001', 'Pensil', 20, 'pcs', 1500.00, 1),
(2, 'KB002', 'Buku Tulis', 100, 'pcs', 5000.00, 1),
(3, 'KB003', 'Penghapus', 30, 'pcs', 1200.00, 1),
(4, 'KB004', 'Penggaris', 25, 'pcs', 2000.00, 1),
(5, 'KB005', 'Spidol', 60, 'pcs', 3000.00, 1),
(6, 'KB006', 'Kertas A4', 200, 'lembar', 2500.00, 1),
(7, 'KB007', 'Stapler', 15, 'pcs', 12000.00, 1),
(8, 'KB008', 'Paku', 500, 'pcs', 500.00, 1),
(9, 'KB009', 'Lem', 40, 'pcs', 7000.00, 1),
(10, 'KB010', 'Tinta Printer', 5, 'pcs', 45000.00, 1),
(11, 'KB011', 'Kalkulator', 0, 'pcs', 75000.00, 0),
(12, 'KB012', 'Map Plastik', 100, 'pcs', 2000.00, 1),
(13, 'KB013', 'Kabel USB', 25, 'pcs', 15000.00, 1),
(14, 'KB014', 'Mouse', 20, 'pcs', 85000.00, 1),
(15, 'KB015', 'Keyboard', 15, 'pcs', 90000.00, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_inventory`
--
ALTER TABLE `tb_inventory`
  ADD PRIMARY KEY (`id_barang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_inventory`
--
ALTER TABLE `tb_inventory`
  MODIFY `id_barang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

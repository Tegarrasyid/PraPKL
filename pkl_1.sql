-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 02:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pkl_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$81.lLTouSumRFvlNVaBIrOTnSOhMXXB9/LIPAcFrgXUAyQF9lE6mi');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `id_admin`, `nama`) VALUES
(1, NULL, 'Sepatu Olahraga'),
(2, NULL, 'Sepatu Sneakers'),
(3, NULL, 'Sepatu Pantofel');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `ukuran` int(11) NOT NULL,
  `jumlah_produk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_produk`, `id_users`, `ukuran`, `jumlah_produk`) VALUES
(84, 2, 0, 36, 1),
(85, 1, 0, 36, 1),
(135, 7, 0, 37, 2),
(151, 8, 4, 37, 1),
(155, 24, 4, 39, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `provider` enum('bca','bni','mandiri') DEFAULT NULL,
  `bukti_pembayaran` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pemesanan`, `provider`, `bukti_pembayaran`) VALUES
(113, 127, 'bni', 'bukti_681f3968321f2.png');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_keranjang` int(11) DEFAULT NULL,
  `tanggal_pemesanan` datetime DEFAULT NULL,
  `jumlah_produk` int(11) NOT NULL,
  `total_harga` int(50) NOT NULL,
  `diskon` int(11) DEFAULT 0,
  `ongkir` int(11) NOT NULL,
  `total_bayar` int(11) DEFAULT 0,
  `ukuran` int(11) NOT NULL,
  `catatan` varchar(225) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_users`, `id_produk`, `id_keranjang`, `tanggal_pemesanan`, `jumlah_produk`, `total_harga`, `diskon`, `ongkir`, `total_bayar`, `ukuran`, `catatan`, `status`) VALUES
(127, 4, 15, NULL, '2025-05-10 13:32:56', 1, 956000, 0, 15000, 971000, 38, '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` double NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `ketersediaan_stok` enum('habis','tersedia') DEFAULT 'tersedia',
  `ukuran` enum('36-42','36','37','38','39','40','41','42') DEFAULT '36-42'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_admin`, `id_kategori`, `nama`, `harga`, `foto`, `detail`, `ketersediaan_stok`, `ukuran`) VALUES
(1, NULL, 3, 'ISODORE', 989000, 'z6008p8tskVByxsWrcou.png', '                            Deskripsi: \r\nSepatu loafer Isidore memadukan kulit sapi halus dan desain yang bersih, cocok untuk penampilan sehari-hari yang anggun.\r\n\r\nBagian atas: Kulit Sapi Halus\r\nLapisan: Mesh\r\nSol dalam: Kulit\r\nSol luar: Phylon\r\n\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.                        ', 'tersedia', '36-42'),
(2, NULL, 3, 'MOREY', 998000, 'OYDQH7LpKmFDBQvqW0Cv.png', '                            Deskripsi: \r\nDibuat untuk gaya hidup modern, Morey menawarkan potongan yang terstruktur dengan bahan berkualitas tinggi yang dirancang untuk dikenakan sepanjang hari.\r\n\r\nBagian atas: Kulit Sapi Halus\r\nLapisan: Kain\r\nSol dalam: Kain\r\nSol luar: Microtech\r\n\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.                        ', 'tersedia', '36-42'),
(3, NULL, 3, 'MINOS', 1079000, '8YLVA9hBHj3ard3H3790.png', '                            Deskripsi: \r\nMinos adalah pilihan yang sempurna untuk pria cerdas yang menghargai gaya dan kenyamanan. Dibuat dari kulit halus, sepatu bot ini menampilkan desain yang ramping dan tak lekang oleh waktu. Lapisan kulit halus, sol dalam, dan sol luar berbahan khusus memastikan kenyamanan dan daya tahan yang unggul.\r\n\r\nBagian Atas: Kulit Halus\r\nLapisan: Kulit Halus\r\nSol Dalam: Kulit Halus\r\nSol Luar: TPR\r\n\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.                        ', 'tersedia', '36-42'),
(4, NULL, 3, 'DARIJO', 1179000, 'SJLcIfJ85YrS3eiMkwg0.png', '                            Deskripsi: \r\nMemperkenalkan Darijo yang mendefinisikan ulang kenyamanan klasik dengan sentuhan modern. Sepatu loafer ini dirancang dengan mempertimbangkan pria yang cerdas, yang menampilkan konstruksi kulit sapi yang sangat halus untuk tampilan dan nuansa yang berkelas. Sol luar yang dirancang khusus memberikan fondasi yang lembut dan suportif, memastikan setiap langkah merupakan bukti kenyamanan dan gaya. Dengan Darijo, rasakan perpaduan sempurna antara keahlian tradisional dan desain kontemporer.\r\n\r\nBagian atas: Kulit Sapi Halus\r\nLapisan: Kulit Sapi Halus\r\nSol dalam: Kulit Sapi Halus\r\nSol luar: TPR\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.                        ', 'tersedia', '36-42'),
(7, NULL, 3, 'ROMANOS', 969000, 'lxCmsgysGmOXhT079YRA.png', '                            Deskripsi: Tingkatkan penampilan formal Anda dengan sepatu bertali Romanos. Dirancang untuk pria yang menghargai hal-hal yang lebih baik dalam hidup, sepatu ini terbuat dari kulit sapi halus premium dan memiliki lapisan dan sol dalam dari kulit domba yang lembut untuk kenyamanan yang luar biasa. Sol luar dari serat menambahkan sentuhan kepraktisan tanpa mengurangi gaya, menjadikan Roma sebagai tambahan penting untuk lemari pakaian Anda untuk semua acara yang canggih.\r\n\r\nBagian atas: Kulit Sapi Halus\r\nBagian dalam: Kulit Domba Halus\r\nSol dalam: Kulit Domba Halus\r\nSol luar: Serat\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.                        ', 'tersedia', '36-42'),
(8, NULL, 3, 'ADONIS', 876000, 'NudLjnrkPJbXZ9CM2IwO.png', '                            Deskripsi: \r\nTemui Adonis – sepatu formal penuh gaya yang menggambarkan kecanggihan. Sepatu ini terbuat dari kulit sapi berkualitas tinggi dan memiliki sol dalam dari kulit domba yang lembut untuk kenyamanan luar biasa.\r\n\r\nBagian Atas: Kulit Sapi Halus\r\nLapisan: Kulit Sapi Halus\r\nSol Dalam: Kulit Domba\r\nSol Luar: Karet\r\n\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.                        ', 'tersedia', '36-42'),
(9, NULL, 3, 'ORINDA', 959000, 'HD41gDI2NDKsVM41ZIcv.png', '                            Deskripsi: Sepatu flat Orinda memadukan kulit buaya timbul dengan sentuhan akhir yang halus, menciptakan tampilan yang menonjol untuk acara apa pun.\r\n\r\nBagian atas: Kulit Sapi Buaya Timbul\r\nLapisan: Kulit Sapi Halus\r\nSol dalam: Kulit Sapi Halus\r\nSol luar: Karet\r\n\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.                        ', 'tersedia', '36-42'),
(10, NULL, 3, 'VALERIA', 809000, 'nXoK2j1caEViW7n7zvmj.png', '                            Deskripsi:\r\nValeria – perpaduan gaya dan kenyamanan. Sepatu flat yang sangat cantik ini dibuat dengan bagian atas berbahan kulit sapi halus premium, yang menjanjikan daya tahan dan tampilan yang canggih. Bagian dalamnya dilengkapi lapisan mikrofiber yang nyaman dan sol dalam berbahan kulit domba yang lentur, yang dirancang untuk menopang kaki Anda dari siang hingga malam. Sol luar berbahan karet memastikan ketahanan dan cengkeraman, menjadikan Valreia pilihan ideal bagi wanita elegan dan modern yang menghargai penampilan dan kenyamanan.\r\n\r\nBagian Atas: Kulit Sapi Halus\r\nLapisan: Mikrofiber\r\nSol Dalam: Kulit Domba Halus\r\nSol Luar: Karet\r\n\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.                        ', 'tersedia', '36-42'),
(11, NULL, 2, 'JOGOSALA STRIVE', 359000, 'N6JfNpgCMeIgLnf7dKaU.png', '                            Deskripsi :\r\nJOGOSALA STRIVE adalah sepatu futsal terbaru dari Ortuseight yang dirilis pada musim panas tahun 2024. Didesain dengan teknologi canggih untuk meningkatkan performa Anda di lapangan. Memiliki fitur Quick Fit pada bagian atas untuk kenyamanan maksimal, serta Midsole berupa Cumulus Foam dan Ortshox yang memberikan dukungan dan responsivitas saat bermain. Tak hanya itu, sepatu ini juga dilengkapi dengan teknologi Outsole OrtCurve untuk stabilitas dan traksi yang optimal. Terbuat dari material Upper PU Synthetic dan Sandwhich Mesh, serta Midsole Injection Phylon, serta Outsole berbahan karet.   \r\n\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.                        ', 'tersedia', '36-42'),
(12, NULL, 2, 'BOSTON MOSS GREEN', 599000, 'S6jHk2MsS7wmkROS7EXI.png', '                            Deskripsi : \r\nOrtuseight BOSTON adalah sepatu sneakers serbaguna yang menggabungkan gaya modern dengan teknologi canggih. Dilengkapi dengan teknologi OrtFlow yang memastikan sirkulasi udara tetap optimal, serta CumulusFoam yang memberikan bantalan empuk di setiap langkah, sepatu ini sangat nyaman digunakan dalam berbagai aktivitas. Desainnya yang sporty dengan kombinasi warna membuatnya mudah dipadukan dengan berbagai gaya.\r\n\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.                        ', 'tersedia', '36-42'),
(13, NULL, 2, 'CONCORD LIGHT GREY BLACK', 449000, 'tllkaruWQCsD51drLeCt.png', '                            Deskripsi : \r\nOrtuseight Concord adalah sepatu sneakers serbaguna yang menggabungkan gaya modern dengan teknologi canggih. Dilengkapi dengan teknologi OrtFlow yang memastikan sirkulasi udara tetap optimal, serta CumulusFoam yang memberikan bantalan empuk di setiap langkah, sepatu ini sangat nyaman digunakan dalam berbagai aktivitas. Desainnya yang sporty dengan kombinasi warna membuatnya mudah dipadukan dengan berbagai gaya.\r\n\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.                        ', 'tersedia', '36-42'),
(14, NULL, 2, 'BERLIN WALNUT FERN GREEN', 599000, 'Dch9TsiCQTjXxxnXPDJN.png', 'Deskripsi : \r\nBerlin adalah sepatu walking shoes yang didesain khusus untuk mendukung gaya hidup aktif Anda. Produk ini merupakan bagian dari kategori Lifestyle, sehingga tidak hanya memberikan kenyamanan namun juga tampilan yang modern dan trendi. Teknologi Ortflow pada bagian upper sepatu memastikan sirkulasi udara yang optimal, sehingga kaki tetap segar dan kering bahkan saat digunakan dalam waktu lama. Midsole menggunakan teknologi Cumulus foam dan Ortshox, memberikan tingkat kenyamanan yang tinggi serta penyerapan benturan yang luar biasa. Dengan begitu, Anda dapat berjalan jauh tanpa merasakan rasa sakit atau kelelahan pada kaki. Dalam hal material, upper sepatu terbuat dari Sandwich mesh dan PU synt. Kombinasi ini memberikan kekuatan dan fleksibilitas yang baik, sehingga sepatu dapat menyesuaikan dengan gerakan kaki Anda saat berjalan. Sementara itu, material midsole menggunakan compression Phylon yang memberikan cushioning yang baik, sehingga langkah Anda terasa ringan dan nyaman. Outsole sepatu terbuat dari rubber dengan kekerasan 55, memberikan daya tahan dan cengkeraman yang baik pada berbagai jenis permukaan. Dengan demikian, sepatu ini bisa Anda gunakan dengan percaya diri baik di dalam maupun di luar ruangan.\r\n\r\nUkuran:\r\nAda kemungkinan perbedaan 1-2 cm karena proses pengembangan dan produksi.', 'tersedia', '36-42'),
(15, NULL, 2, 'GRAND COURT', 956000, 'Tdam3iYvJXiR0bU9dEAX.png', 'Deskripsi : \r\nSiap untuk meningkatkan tampilan sehari-harimu? Sepatu adidas ini membantu dengan mudah. Berasal dari style tenis era &#039;70-an, dengan desain low-profile dan 3-Stripes ikonis. Detail modern hadir agar kamu tetap nyaman dalam keseharian, seperti sockliner Cloudfoam superlembut dan upper berbahan kulit sintetis. Produk ini mengandung sedikitnya 20% material daur ulang. Dengan menggunakan kembali material yang telah dibuat, kita membantu mengurangi limbah dan ketergantungan kita pada sumber daya terbatas dan mengurangi jejak karbon dari produk yang kita buat.\r\n\r\nSpesifikasi\r\n•	Fit reguler\r\n•	Upper dari bahan tekstil dan kulit sintetis\r\n•	Sockliner Cloudfoam\r\n•	Kode produk: JS2881\r\n•	Menggunakan tali sepatu\r\n•	Lining dari bahan tekstil\r\n•	Outsole berbahan karet\r\n', 'tersedia', '36-42'),
(16, NULL, 2, 'FULLY FASHIONED TRAINERS', 699900, 'aZfWPdJdenGlVrUjoODy.png', 'Deskripsi: \r\nSepatu kets yang sepenuhnya dibuat dari bahan jala dan kain berlapis. Elastisitas di sekeliling bukaan, tali di bagian depan dan lingkaran di bagian depan dan belakang. Sol dalam berbahan jala dan sol karet tebal yang berpola di bagian bawah.', 'tersedia', '36-42'),
(17, NULL, 2, 'NIKE DUNK LOW WOMEN’S', 1479900, 'WXxKeLpIIIm5ZcwZrxib.png', 'Deskripsi : \r\nSepatu Nike Dunk Low Wanita menghadirkan kembali gaya ikonik basket era &#039;80-an yang kini menjadi tren streetwear. Dengan desain klasik dan memadukan warna beige dan putih, sepatu ini menawarkan kenyamanan optimal berkat kerah rendah berlapis bantalan serta midsole busa yang ringan dan responsif. Bagian atas dari kulit yang mengkilap memberikan tampilan yang mewah dan semakin lembut seiring waktu. Dilengkapi dengan sol karet yang tahan lama dan traksi khas lingkaran pivot, sepatu ini siap menemani aktivitas harian Anda dengan gaya dan kenyamanan. Pilih Nike Dunk Low di JD Sports Indponesia untuk tampilan sporty yang penuh warisan budaya.\r\n', 'tersedia', '36-42'),
(18, NULL, 2, 'New Balance CT 500 V1 Women&#039;s', 1769900, 'cN9T4j6DYP6fnfNp8CwS.png', 'Deskripsi :\r\nSneaker New Balance CT 500 V1 menghadirkan gaya klasik yang terinspirasi dari tenis retro, memberikan sentuhan elegan yang tetap nyaman untuk pemakaian sehari-hari. Dengan warna abu-abu yang netral, sepatu ini mudah dipadukan dengan berbagai outfit, mulai dari kasual hingga sporty. Upper berbahan suede dan mesh untuk keseimbangan antara daya tahan dan sirkulasi udara. Cushioned insole memberikan kenyamanan optimal untuk penggunaan sepanjang hari. Midsole EVA ringan yang memberikan bantalan empuk dan responsif. Outsole berbahan karet dengan pola grip untuk daya tahan dan traksi yang lebih baik. Desain low-cut klasik untuk tampilan minimalis yang tetap stylish. Sepatu ini cocok untuk aktivitas sehari-hari dan memberikan kesan clean, modern, serta effortlessly stylish. New Balance CT 500 V1 Grey adalah pilihan sempurna untuk kamu yang mengutamakan kenyamanan tanpa mengorbankan gaya!', 'tersedia', '36-42'),
(19, NULL, 1, 'Shadowrun Eagle Shoes', 469900, 'd0WL1IPEx9yQElALPcek.png', 'Deskripsi: \r\n•	Upper material menggunakan material Seamless ( minim jahitan ) sehingga nyaman di gunakan dan breathable\r\n•	Upper Mesh Molded membuat Sepatu terlihat unik\r\n•	Menggunakan Insole Ultrafit dan Maximum breathable\r\n•	Bottom outsole menggunakan material IU, merupakan campuran Eva dan Rubber sehingga lebih responsif saat di pakai.\r\n', 'tersedia', '36-42'),
(20, NULL, 1, 'Alpha ST Eagle Shoes', 819900, 'c7TPqSSE48bcqiYz4BCP.png', 'Deskripsi:\r\n•	Upper material menggunakan kombinasi membrane + dan TPU Flex Film dengan karakter yang minimalis , ringan dan membantu konstruksi lebih fit saat di gunakan.\r\n•	Midsole menggunakan perpaduan teknologi baru LEAP Foam yang menghasilkan energy return dan Phylite Foam untuk meredam guncangan atau energy impact.\r\n•	Outsole menggunakan Solid Compund Rubber ( SCR ) dengan Tingkat abrasi yang sangat baik dan di lengkapi Slingshot Plate sebagai support system antara leap Foam dan Phylite Foam.\r\n•	Ortholite Insole menggunakan X-40 Ortholite yang sangat responsive dengan spesifikasi intensitas tinggi dan eco friendly sehingga aman di gunakan.\r\n', 'tersedia', '36-42'),
(21, NULL, 1, 'Overdrive Eagle Shoes', 369900, 'Z0RTtKEBRHgtTf8mJhlx.png', 'Deskripsi:  \r\n•	Upper Material Kombinasi Sandwich Mesh , TPU Hotmelt ,Synthetic Leather menambah kenyamanan saat di gunakan .\r\n•	Tounge Lining Cushion Bantalan empuk pada bagian dalam tange sepatu\r\n•	IP ( Injection Phylon ) yang empuk di kombinasikan dengan Rubber yang kuat dan tidak Licin .\r\n', 'tersedia', '36-42'),
(22, NULL, 1, 'Run Rider Eagle Shoes', 319900, 'iVR04JZpgAzCcBjl5fD8.png', 'Deskripsi: \r\n•	Upper dengan material sandwich mesh yang sangat ringan\r\n•	Toecap Guard material PVC synthetic yang dapat melindungi area depan kaki\r\n•	Ankle support dengan material PVC moulded sebagai struktur penahan area pergelangan kaki\r\n•	Durable bottom tooling dengan outsole menggunakan TPR\r\n•	Back Counter stabilizer menggunakan mica emboss molded dapat membantu stabilitas area belakang Sepatu\r\n•	Comfort lining material Flex mesh pada colar membuat nyaman saat di gunakan.\r\n', 'tersedia', '36-42'),
(23, NULL, 1, 'Nomad Eagle Shoes', 319900, 'w66BHb0v9kyKDYmewwVB.png', 'Deskripsi: \r\n•	Breathable Upper Based dengan bermaterial Sandwich Mesh yang sangat ringan dan memiliki sirkulasi udara yang baik ketika di gunakan\r\n•	Toecap Guard, dengan material PVC Synthetic dapat melindungi area depan kaki dari benturan saat beraktivitas\r\n•	Mudguard Area, dengan material PVC Synthetic sebagai struktur penahan area samping untuk pemakaian yang lebih nyaman\r\n•	Durable Bottom Tooling , dengan outsole menggunakan material TPR dapat meningkatkan kekuatan struktur outsole\r\n', 'tersedia', '36-42'),
(24, NULL, 1, 'Galaxy 7 Men&#039;s Running Shoes - Ftwr White', 850000, 'KH4cfnBTN2IeA0f3SqZk.png', 'Deskripsi: \r\nSetiap lari adalah perjalanan penemuan. Kenakan sepatu lari adidas ini dan jelajahi potensi Anda. Midsole Cloudfoam meredam langkah Anda agar tetap nyaman saat Anda membangun ketahanan. Bagian atas yang terbuat dari bahan tekstil yang tahan lama memberikan rasa nyaman mulai dari putaran pertama hingga 5K pertama Anda.\r\n', 'tersedia', '36-42'),
(25, NULL, 1, 'Mirella Men&#039;s Running - Grey', 599000, '5Iu0NlNRkIep8U3sV1DH.png', 'Deskripsi: \r\nTampil dengan textile upper yang ringnan dan outsole eva untuk perasaan ringan pada aktivitas olahraga yang mudah, terbuat dari material tekstil yang ringan dengan sol eva , menghasilkan rasa ringan di kaki dalam aktivitas olahraga ringan, Tampil dengan mesh ringan yang dipadukan dengan upper sintetis dan outsole eva untuk sensasi ringan pada aktivitas olahraga yang mudah, Dibuat dengan material poliester dan PU untuk bagian upper dengan eva + outsole karet untuk rasa ringan pada aktivitas olahraga yang mudah, Dibuat dengan nilon air mesh dan teknologi dd anima. Sepatu ini diciptakan untuk memenuhi segala kebutuhan, menggabungkan kinerja dan kenyamanan yang luar biasa.', 'tersedia', '36-42'),
(26, NULL, 1, 'Matron Men&#039;s Running - Navy', 499000, '2eGO67rckePEhNtxbk43.png', 'Deskripsi: \r\nTampil dengan textile upper yang ringnan dan outsole eva untuk perasaan ringan pada aktivitas olahraga yang mudah, terbuat dari material tekstil yang ringan dengan sol eva , menghasilkan rasa ringan di kaki dalam aktivitas olahraga ringan, Tampil dengan mesh ringan yang dipadukan dengan upper sintetis dan outsole eva untuk sensasi ringan pada aktivitas olahraga yang mudah, Dibuat dengan material poliester dan PU untuk bagian upper dengan eva + outsole karet untuk rasa ringan pada aktivitas olahraga yang mudah, Dibuat dengan nilon air mesh dan teknologi dd anima. Sepatu ini diciptakan untuk memenuhi segala kebutuhan, menggabungkan kinerja dan kenyamanan yang luar biasa.\r\n', 'tersedia', '36-42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_tlpn` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `nama`, `username`, `email`, `password`, `alamat`, `no_tlpn`) VALUES
(2, 'syifa anisa', 'syifa', 'syifa@gmail.com', '21224ee77157bf0306ddf5d58444b7a3', 'Purbalingga', 121234),
(4, 'tegar rasyid', 'tegar', 'tegar@gmail.com', '288253bad64f97cd6dc12668c3febc39', 'Purwokerto', 876249342),
(5, '', 'faqih', 'kamu@gmail.com', '202cb962ac59075b964b07152d234b70', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `pemesanan_ibfk_3` (`id_keranjang`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `nama` (`nama`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kategori`
--
ALTER TABLE `kategori`
  ADD CONSTRAINT `kategori_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `pemesanan_ibfk_3` FOREIGN KEY (`id_keranjang`) REFERENCES `keranjang` (`id_keranjang`) ON DELETE SET NULL;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

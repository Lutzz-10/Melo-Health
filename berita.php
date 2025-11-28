<?php
session_start();
require_once 'includes/functions.php';

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1
$articles_per_page = 4; // Maximum 4 articles per page
$offset = ($page - 1) * $articles_per_page;

// Ambil semua berita dari database untuk menghitung jumlah total
try {
    $total_stmt = $pdo->prepare("SELECT COUNT(*) FROM berita");
    $total_stmt->execute();
    $total_articles = $total_stmt->fetchColumn();

    // Ambil berita untuk halaman saat ini
    $stmt = $pdo->prepare("SELECT * FROM berita ORDER BY tanggal_publish DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $articles_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Hitung jumlah total halaman
    $total_pages = ceil($total_articles / $articles_per_page);

    // Ambil 5 berita terbaru untuk berita populer
    $popular_stmt = $pdo->prepare("SELECT * FROM berita ORDER BY tanggal_publish DESC LIMIT 5");
    $popular_stmt->execute();
    $popular_articles = $popular_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $articles = [];
    $popular_articles = [];
    $total_articles = 0;
    $total_pages = 1;
}

// Ambil berita untuk ditampilkan di halaman ini
$latest_articles = $articles;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Kesehatan - Melo Health</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/melohealth.jpg">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-50">
    <?php include 'includes/navbar.php'; ?>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-green-500 to-blue-500 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Berita & Artikel Kesehatan</h1>
            <p class="text-xl max-w-2xl mx-auto">Informasi terkini seputar kesehatan, tips hidup sehat, dan perkembangan dunia medis.</p>
        </div>
    </section>

    <!-- Berita Content -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Artikel List -->
                <div class="md:w-2/3">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Artikel Terbaru</h2>

                        <div class="grid grid-cols-1 gap-8">
                            <?php if (!empty($latest_articles)): ?>
                                <?php foreach ($latest_articles as $index => $article): ?>
                                    <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden">
                                        <div class="md:flex">
                                            <div class="md:shrink-0">
                                                <img src="<?php echo !empty($article['gambar']) ? $article['gambar'] : 'https://images.unsplash.com/photo-1516559828984-fb3b99548b21?auto=format&fit=crop&w=400'; ?>"
                                                     alt="<?php echo htmlspecialchars($article['judul']); ?>"
                                                     class="h-48 w-full md:w-48 object-cover">
                                            </div>
                                            <div class="p-6">
                                                <div class="text-sm text-gray-500 mb-2"><?php echo date('d F Y', strtotime($article['tanggal_publish'])); ?></div>
                                                <h3 class="text-xl font-bold mb-3 text-gray-800"><?php echo htmlspecialchars($article['judul']); ?></h3>
                                                <p class="text-gray-600 mb-4"><?php echo substr(htmlspecialchars(strip_tags($article['konten'])), 0, 150) . '...'; ?></p>
                                                <a href="detail-berita.php?id=<?php echo $article['id']; ?>"
                                                   class="inline-block text-green-600 font-medium hover:underline">
                                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-10">
                                    <p class="text-gray-600">Belum ada berita tersedia.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-10 flex justify-center">
                            <nav class="flex items-center space-x-2">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?php echo $page - 1; ?>" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 hover:scale-105 transition-all duration-500 ease-in-out">Previous</a>
                                <?php else: ?>
                                    <span class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md opacity-50 cursor-not-allowed">Previous</span>
                                <?php endif; ?>

                                <?php
                                // Calculate pagination range
                                $start = max(1, $page - 2);
                                $end = min($total_pages, $page + 2);

                                // Previous pages
                                if ($start > 1) {
                                    echo '<a href="?page=1" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 hover:scale-105 transition-all duration-500 ease-in-out">1</a>';
                                    if ($start > 2) {
                                        echo '<span class="px-4 py-2 text-gray-500">...</span>';
                                    }
                                }

                                // Current range
                                for ($i = $start; $i <= $end; $i++) {
                                    if ($i == $page) {
                                        echo '<a href="?page=' . $i . '" class="bg-green-600 text-white px-4 py-2 rounded-md">' . $i . '</a>';
                                    } else {
                                        echo '<a href="?page=' . $i . '" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 hover:scale-105 transition-all duration-500 ease-in-out">' . $i . '</a>';
                                    }
                                }

                                // Next pages
                                if ($end < $total_pages) {
                                    if ($end < $total_pages - 1) {
                                        echo '<span class="px-4 py-2 text-gray-500">...</span>';
                                    }
                                    echo '<a href="?page=' . $total_pages . '" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 hover:scale-105 transition-all duration-500 ease-in-out">' . $total_pages . '</a>';
                                }
                                ?>

                                <?php if ($page < $total_pages): ?>
                                    <a href="?page=<?php echo $page + 1; ?>" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 hover:scale-105 transition-all duration-500 ease-in-out">Next</a>
                                <?php else: ?>
                                    <span class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md opacity-50 cursor-not-allowed">Next</span>
                                <?php endif; ?>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="md:w-1/3">
                    <div class="bg-gray-50 rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Berita Populer</h3>
                        <ul class="space-y-4">
                            <?php if (!empty($popular_articles)): ?>
                                <?php foreach ($popular_articles as $index => $article): ?>
                                    <li class="flex items-start">
                                        <span class="bg-green-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 mt-1 text-sm"><?php echo $index + 1; ?></span>
                                        <a href="detail-berita.php?id=<?php echo $article['id']; ?>"
                                           class="text-gray-800 hover:text-green-600">
                                           <?php echo htmlspecialchars($article['judul']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="text-gray-600 text-center">Belum ada berita populer</li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <div class="bg-gray-50 rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Kategori Berita</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="flex justify-between text-gray-800 hover:text-green-600">
                                <span>Kesehatan Umum</span>
                                <span class="bg-gray-200 text-gray-800 text-xs rounded-full px-2 py-1">12</span>
                            </a></li>
                            <li><a href="#" class="flex justify-between text-gray-800 hover:text-green-600">
                                <span>Gaya Hidup Sehat</span>
                                <span class="bg-gray-200 text-gray-800 text-xs rounded-full px-2 py-1">8</span>
                            </a></li>
                            <li><a href="#" class="flex justify-between text-gray-800 hover:text-green-600">
                                <span>Nutrisi</span>
                                <span class="bg-gray-200 text-gray-800 text-xs rounded-full px-2 py-1">5</span>
                            </a></li>
                            <li><a href="#" class="flex justify-between text-gray-800 hover:text-green-600">
                                <span>Pola Makan</span>
                                <span class="bg-gray-200 text-gray-800 text-xs rounded-full px-2 py-1">7</span>
                            </a></li>
                            <li><a href="#" class="flex justify-between text-gray-800 hover:text-green-600">
                                <span>Olahraga</span>
                                <span class="bg-gray-200 text-gray-800 text-xs rounded-full px-2 py-1">6</span>
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Melo Health</h3>
                    <p class="text-gray-400">Sistem informasi dan antrian Puskesmas yang efisien dan mudah diakses oleh masyarakat.</p>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="poli/poli-gigi.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Poli Gigi</a></li>
                        <li><a href="poli/poli-gizi.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Poli Gizi</a></li>
                        <li><a href="poli/poli-umum.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Poli Umum</a></li>
                        <li><a href="poli/ugd.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Unit Gawat Darurat</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Tautan</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Beranda</a></li>
                        <li><a href="tentang.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Tentang</a></li>
                        <li><a href="berita.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Berita</a></li>
                        <li><a href="login.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Login</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                            <span>Jl. Kesehatan No. 123, Kota Sehat</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3"></i>
                            <span>(021) 1234-5678</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            <span>info@melhealth.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-10 pt-6 text-center text-gray-400">
                <p>&copy; 2025 Melo Health. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="assets/js/script.js"></script>
</body>
</html>
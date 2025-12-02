<?php
session_start();
require_once 'includes/functions.php';

// Ambil ID berita dari URL
$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Jika tidak ada ID atau ID tidak valid, redirect ke halaman berita
if ($article_id <= 0) {
    header("Location: berita.php");
    exit();
}

// Ambil data berita dari database
try {
    $stmt = $pdo->prepare("SELECT * FROM berita WHERE id = ?");
    $stmt->execute([$article_id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika berita tidak ditemukan, redirect ke halaman berita
    if (!$article) {
        header("Location: berita.php");
        exit();
    }
} catch (PDOException $e) {
    header("Location: berita.php");
    exit();
}

// Ambil beberapa berita terkait (berita selain yang sedang dibaca)
try {
    $stmt_related = $pdo->prepare("SELECT * FROM berita WHERE id != ? ORDER BY tanggal_publish DESC LIMIT 3");
    $stmt_related->execute([$article_id]);
    $related_articles = $stmt_related->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $related_articles = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['judul']); ?> - Melo Health</title>
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

    <!-- Artikel Detail -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="mb-6">
                <a href="berita.php" class="inline-flex items-center text-green-600 hover:text-green-800 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Berita
                </a>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="<?php echo !empty($article['gambar']) ? $article['gambar'] : 'https://images.unsplash.com/photo-1516559828984-fb3b99548b21?auto=format&fit=crop&w=1200'; ?>"
                     alt="<?php echo htmlspecialchars($article['judul']); ?>"
                     class="w-full h-96 object-cover">

                <div class="p-8">
                    <div class="flex items-center text-gray-500 mb-4">
                        <span><?php echo date('d F Y', strtotime($article['tanggal_publish'])); ?></span>
                        <span class="mx-2">•</span>
                        <span>Kesehatan Umum</span>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-800 mb-6"><?php echo htmlspecialchars($article['judul']); ?></h1>

                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        <?php echo nl2br(htmlspecialchars($article['konten'])); ?>
                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Bagikan Artikel Ini</h3>
                        <div class="flex space-x-4">
                            <?php
                                $current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                                $encoded_url = urlencode($current_url);
                                $encoded_title = urlencode($article['judul']);
                                $encoded_text = urlencode($article['judul'] . ' - ' . $current_url);
                            ?>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $encoded_url; ?>"
                               target="_blank"
                               class="bg-blue-600 text-white px-4 py-2 rounded-md flex items-center hover:bg-blue-700 transition-colors">
                                <i class="fab fa-facebook-f mr-2"></i>
                                Facebook
                            </a>
                            <a href="https://api.whatsapp.com/send?text=<?php echo $encoded_text; ?>"
                               target="_blank"
                               class="bg-green-600 text-white px-4 py-2 rounded-md flex items-center hover:bg-green-700 transition-colors">
                                <i class="fab fa-whatsapp mr-2"></i>
                                WhatsApp
                            </a>
                            <a href="https://twitter.com/intent/tweet?text=<?php echo $encoded_title; ?>&url=<?php echo $encoded_url; ?>"
                               target="_blank"
                               class="bg-blue-400 text-white px-4 py-2 rounded-md flex items-center hover:bg-blue-500 transition-colors">
                                <i class="fab fa-twitter mr-2"></i>
                                Twitter
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 bg-gray-50 rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Artikel Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <?php foreach ($related_articles as $related_article): ?>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="font-bold text-gray-800 mb-2">
                            <a href="detail-berita.php?id=<?php echo $related_article['id']; ?>"
                               class="hover:text-green-600">
                                <?php echo htmlspecialchars($related_article['judul']); ?>
                            </a>
                        </h4>
                        <p class="text-sm text-gray-600"><?php echo substr(htmlspecialchars(strip_tags($related_article['konten'])), 0, 100) . '...'; ?></p>
                    </div>
                    <?php endforeach; ?>

                    <?php if (empty($related_articles)): ?>
                    <div class="col-span-3 text-center text-gray-500 py-8">
                        Tidak ada artikel terkait
                    </div>
                    <?php endif; ?>
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
                        <li><a href="poli/poli-gigi.php" class="text-gray-400 hover:text-white transition duration-300">Poli Gigi</a></li>
                        <li><a href="poli/poli-gizi.php" class="text-gray-400 hover:text-white transition duration-300">Poli Gizi</a></li>
                        <li><a href="poli/poli-umum.php" class="text-gray-400 hover:text-white transition duration-300">Poli Umum</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Tautan</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition duration-300">Beranda</a></li>
                        <li><a href="tentang.php" class="text-gray-400 hover:text-white transition duration-300">Tentang</a></li>
                        <li><a href="berita.php" class="text-gray-400 hover:text-white transition duration-300">Berita</a></li>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_confirmed'] == 'confirmed'): ?>
                        <li><a href="user/profile.php" class="text-gray-400 hover:text-white transition duration-300">Profile</a></li>
                        <?php else: ?>
                        <li><a href="login.php" class="text-gray-400 hover:text-white transition duration-300">Login</a></li>
                        <?php endif; ?>
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
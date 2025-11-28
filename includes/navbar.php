<?php
// Simple and robust approach: determine path based on the current script location
// Check if the current page is in a subdirectory
$request_path = $_SERVER['REQUEST_URI'];

if (preg_match('@/poli/|/poli$@', $request_path)) {
    // We're in the poli subdirectory
    $base_path = '../';
} else if (preg_match('@/user/|/user$@', $request_path)) {
    // We're in the user subdirectory
    $base_path = '../';
} else if (preg_match('@/admin/berita/@', $request_path)) {
    // We're in the admin/berita subdirectory (nested)
    $base_path = '../../';
} else if (preg_match('@/admin/|/admin$@', $request_path)) {
    // We're in the admin subdirectory
    $base_path = '../';
} else {
    // We're in the main directory (index.php, tentang.php, berita.php, etc.)
    $base_path = '';
}

// Check if user is logged in to determine navbar content
$isLoggedIn = isset($_SESSION['user_id']);
$userConfirmed = isset($_SESSION['user_confirmed']) && $_SESSION['user_confirmed'] == 'confirmed';
$isAdminLoggedIn = isset($_SESSION['admin_id']);
?>

<nav class="bg-white shadow-md py-3 px-6 flex justify-between items-center sticky top-0 z-50">    <div class="flex items-center">
        <a href="<?php echo $base_path; ?>index.php" class="flex items-center">
            <img src="<?php echo $base_path; ?>assets/images/melohealth.jpg" alt="Melo Health Logo" class="h-12">
            <span class="sr-only">Melo Health</span>
        </a>
    </div>
    
    <div class="hidden md:flex space-x-8">
        <a href="<?php echo $base_path; ?>index.php" class="text-gray-800 hover:text-green-600 font-medium">Beranda</a>
        <a href="<?php echo $base_path; ?>tentang.php" class="text-gray-800 hover:text-green-600 font-medium">Tentang</a>
        <div class="relative group">
            <button class="text-gray-800 hover:text-green-600 font-medium flex items-center">
                Layanan <i class="fas fa-chevron-down ml-1"></i>
            </button>
            <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-md py-2 w-48 z-50">
                <a href="<?php echo $base_path; ?>poli/poli-gigi.php" class="block px-4 py-2 text-gray-800 hover:bg-green-100">Poli Gigi</a>
                <a href="<?php echo $base_path; ?>poli/poli-gizi.php" class="block px-4 py-2 text-gray-800 hover:bg-green-100">Poli Gizi</a>
                <a href="<?php echo $base_path; ?>poli/poli-umum.php" class="block px-4 py-2 text-gray-800 hover:bg-green-100">Poli Umum</a>
            </div>
        </div>
        <a href="<?php echo $base_path; ?>berita.php" class="text-gray-800 hover:text-green-600 font-medium">Berita</a>
    </div>
    
    <div>
        <?php if ($isLoggedIn && $userConfirmed): ?>
            <!-- User menu when logged in -->
            <div class="relative">
                <button id="user-menu-button" class="flex items-center text-gray-800 hover:text-green-600">
                    <i class="fas fa-user-circle text-2xl"></i>
                </button>
                <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" style="top: 100%; min-width: max-content;">
                    <a href="<?php echo $base_path; ?>user/profile.php" class="block px-4 py-2 text-gray-800 hover:bg-green-100">Profile</a>
                    <a href="<?php echo $base_path; ?>logout.php" class="block px-4 py-2 text-gray-800 hover:bg-red-100">Logout</a>
                </div>
            </div>
        <?php elseif ($isAdminLoggedIn): ?>
            <!-- Admin menu when logged in -->
            <a href="<?php echo $base_path; ?>admin/dashboard.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-300">Admin Panel</a>
        <?php else: ?>
            <!-- Login button when not logged in -->
            <a href="<?php echo $base_path; ?>login.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition duration-300">Login</a>
        <?php endif; ?>
    </div>
    
    <!-- Mobile menu button -->
    <button id="mobile-menu-button" class="md:hidden text-gray-800">
        <i class="fas fa-bars text-2xl"></i>
    </button>
</nav>

<!-- Mobile Menu -->
<div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg absolute w-full z-40">
    <div class="px-2 pt-2 pb-3 space-y-1">
        <a href="<?php echo $base_path; ?>index.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Beranda</a>
        <a href="<?php echo $base_path; ?>tentang.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Tentang</a>
        <div class="pl-3 border-l-2 border-green-500">
            <a href="<?php echo $base_path; ?>poli/poli-gigi.php" class="block px-3 py-2 text-gray-800 hover:bg-green-100">Poli Gigi</a>
            <a href="<?php echo $base_path; ?>poli/poli-gizi.php" class="block px-3 py-2 text-gray-800 hover:bg-green-100">Poli Gizi</a>
            <a href="<?php echo $base_path; ?>poli/poli-umum.php" class="block px-3 py-2 text-gray-800 hover:bg-green-100">Poli Umum</a>
        </div>
        <a href="<?php echo $base_path; ?>berita.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Berita</a>
        <?php if ($isLoggedIn && $userConfirmed): ?>
            <a href="<?php echo $base_path; ?>user/profile.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Profile</a>
            <a href="<?php echo $base_path; ?>logout.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-red-100">Logout</a>
        <?php elseif ($isAdminLoggedIn): ?>
            <a href="<?php echo $base_path; ?>admin/dashboard.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-blue-100">Admin Panel</a>
        <?php else: ?>
            <a href="<?php echo $base_path; ?>login.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Login</a>
        <?php endif; ?>
    </div>
</div>

<!-- Scroll to Top Button -->
<div id="scrollToTop" class="fixed bottom-8 right-8 z-50" style="opacity: 0; pointer-events: none; transition: opacity 0.3s ease;">
    <button onclick="scrollToTop()" class="bg-green-600 hover:bg-green-700 text-white p-3 rounded-full shadow-lg">
        <i class="fas fa-arrow-up text-lg"></i>
    </button>
</div>

<script>
    // Optimized and reliable approach
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                const menu = document.getElementById('mobile-menu');
                if (menu) {
                    menu.classList.toggle('hidden');
                }
            });
        }

        // User menu toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        if (userMenuButton && userMenu) {
            // Use direct style manipulation for more reliable behavior
            userMenuButton.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                // Toggle visibility using display property for more reliable behavior
                if (userMenu.style.display === 'none' || userMenu.classList.contains('hidden')) {
                    userMenu.classList.remove('hidden');
                    userMenu.style.display = 'block';
                } else {
                    userMenu.classList.add('hidden');
                    userMenu.style.display = 'none';
                }
            });

            // Close when clicking elsewhere
            document.addEventListener('click', function(event) {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                    userMenu.style.display = 'none';
                }
            });
        }

        // Scroll to top functionality
        const scrollToTopBtn = document.getElementById('scrollToTop');
        if (scrollToTopBtn) {
            // Show/hide scroll to top button based on scroll position
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollToTopBtn.style.opacity = '1';
                    scrollToTopBtn.style.pointerEvents = 'auto';
                } else {
                    scrollToTopBtn.style.opacity = '0';
                    scrollToTopBtn.style.pointerEvents = 'none';
                }
            });

            // Show button immediately when page loads if already scrolled
            if (window.pageYOffset > 300) {
                scrollToTopBtn.style.opacity = '1';
                scrollToTopBtn.style.pointerEvents = 'auto';
            }
        }
    });

    // Function to scroll to top smoothly
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>
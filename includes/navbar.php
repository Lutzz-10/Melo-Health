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

<nav class="bg-white shadow-md py-3 px-6 flex justify-between items-center sticky top-0 z-[9997]">
    <div class="flex items-center">
        <a href="<?php echo $base_path; ?>index.php" class="flex items-center">
            <img src="<?php echo $base_path; ?>assets/images/melohealth.jpg" alt="Melo Health Logo" class="h-12">
            <span class="sr-only">Melo Health</span>
        </a>
    </div>

    <div class="hidden md:flex space-x-8">
        <a href="<?php echo $base_path; ?>index.php" class="text-gray-800 hover:text-green-600 font-medium">Beranda</a>
        <a href="<?php echo $base_path; ?>tentang.php" class="text-gray-800 hover:text-green-600 font-medium">Tentang</a>
        <a href="<?php echo $base_path; ?>layanan.php" class="text-gray-800 hover:text-green-600 font-medium">Layanan</a>
        <a href="<?php echo $base_path; ?>berita.php" class="text-gray-800 hover:text-green-600 font-medium">Berita</a>
    </div>

    <div class="flex items-center">
        <?php if ($isLoggedIn && $userConfirmed): ?>
            <!-- User menu when logged in -->
            <div class="relative md:mr-4 hidden md:block">
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
            <a href="<?php echo $base_path; ?>admin/dashboard.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-300 hidden md:block">
                Admin Panel
            </a>
        <?php else: ?>
            <!-- Login button when not logged in -->
            <a href="<?php echo $base_path; ?>login.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition duration-300 hidden md:block">
                Login
            </a>
        <?php endif; ?>

        <!-- Mobile menu button -->
        <button id="hamburger-menu-btn" class="text-gray-800 ml-4 md:hidden lg:hidden xl:hidden 2xl:hidden relative z-[9999]" onclick="toggleMobileMenu(event)" style="cursor: pointer; user-select: none;">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </div>
</nav>

<!-- Mobile Menu -->
<div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg absolute w-full z-[9998]" style="top: 100%;">
    <div class="px-2 pt-2 pb-3 space-y-1">
        <a href="<?php echo $base_path; ?>index.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Beranda</a>
        <a href="<?php echo $base_path; ?>tentang.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Tentang</a>
        <a href="<?php echo $base_path; ?>layanan.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Layanan</a>
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
<div id="scrollToTop" class="fixed bottom-8 right-8 z-[9996]" style="opacity: 0; pointer-events: none; transition: opacity 0.3s ease;">
    <button onclick="scrollToTop()" class="bg-green-600 hover:bg-green-700 text-white p-3 rounded-full shadow-lg">
        <i class="fas fa-arrow-up text-lg"></i>
    </button>
</div>

<script>
    function toggleMobileMenu(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu) {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                mobileMenu.style.display = 'block';
                mobileMenu.style.position = 'fixed';
                mobileMenu.style.top = '4rem';
                mobileMenu.style.left = '0';
                mobileMenu.style.right = '0';
                mobileMenu.style.zIndex = '9998';
            } else {
                mobileMenu.classList.add('hidden');
                mobileMenu.style.display = 'none';
            }
        }
    }

    // Set up event listeners after the page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure the hamburger button has the event handler
        const hamburgerBtn = document.getElementById('hamburger-menu-btn');
        if (hamburgerBtn) {
            // Try multiple approaches to attach the event
            hamburgerBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMobileMenu(e);
            };

            // Add event listener as backup
            hamburgerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMobileMenu(e);
            }, true); // Use capture phase
        }

        // Close mobile menu when clicking on links
        const menuLinks = document.querySelectorAll('#mobile-menu a');
        menuLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    mobileMenu.style.display = 'none';
                    mobileMenu.style.visibility = 'hidden';
                }
            });
        });
    });

    // Also try setting the event immediately if DOM is already loaded
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        const hamburgerBtn = document.getElementById('hamburger-menu-btn');
        if (hamburgerBtn) {
            hamburgerBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMobileMenu(e);
            };
        }
    }

    // Function to scroll to top
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>
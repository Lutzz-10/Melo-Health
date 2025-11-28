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

<nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center sticky top-0 z-50">
    <div class="flex items-center">
        <h1 class="text-xl font-bold text-green-600">Melo Health</h1>
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
                <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
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

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
    
    // User menu toggle
    if (document.getElementById('user-menu-button')) {
        document.getElementById('user-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
        });
        
        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('user-menu');
            const userButton = document.getElementById('user-menu-button');
            
            if (!userMenu.contains(event.target) && !userButton.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }
</script>
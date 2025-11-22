// JavaScript for Melo Health website

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // User menu toggle
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    
    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function() {
            userMenu.classList.toggle('hidden');
        });
        
        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }
    
    // Set minimum date to today for date inputs
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(function(input) {
        if (!input.min) {
            input.min = new Date().toISOString().split('T')[0];
        }
    });
});

// Function to handle queue confirmation
function ambilAntrian() {
    // Check if user is logged in
    if (!isLoggedIn()) {
        // Redirect to login if not logged in
        window.location.href = 'login.php';
    } else {
        // Show confirmation modal
        document.getElementById('antrianModal').classList.remove('hidden');
    }
}

// Function to close modal
function tutupModal() {
    document.getElementById('antrianModal').classList.add('hidden');
}

// Function to confirm queue
function konfirmasiAntrian() {
    // In a real application, this would send a request to the server
    alert('Nomor antrian berhasil diambil!');
    tutupModal();
}

// Function to check if user is logged in
function isLoggedIn() {
    // This is a placeholder - in a real app you'd check session or local storage
    // For now, return true if a login element doesn't exist
    return !document.querySelector('a[href="login.php"]');
}

// Function for emergency call
function panggilDarurat() {
    alert('Anda akan dihubungkan ke unit gawat darurat. Mohon tunggu sebentar...');
    // In a real application, this would make a call to the UGD
}

// Function to update expired queues (would be called via cron job)
function updateExpiredQueues() {
    // This would typically be a server-side function called via cron job
    // but we'll include the client-side function for completeness
    console.log('Checking for expired queues...');
    // In a real implementation, this would be an AJAX call to a PHP file
    fetch('includes/update-expired-queues.php')
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                console.log(`Updated ${data.updated} expired queues`);
            }
        })
        .catch(error => {
            console.error('Error updating expired queues:', error);
        });
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.fixed');
    modals.forEach(modal => {
        if (modal.classList.contains('hidden')) return;
        if (!modal.querySelector('.bg-white').contains(event.target)) {
            modal.classList.add('hidden');
        }
    });
});
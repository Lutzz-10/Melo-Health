// JavaScript for Melo Health website

// User menu toggle (excluding mobile menu which is handled in navbar)
document.addEventListener('DOMContentLoaded', function() {
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
        if (!modal || modal.classList.contains('hidden')) return;
        const modalContent = modal.querySelector('.bg-white');
        if (modalContent && !modalContent.contains(event.target)) {
            modal.classList.add('hidden');
        }
    });
});
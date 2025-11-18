// 1. Toggle Sidebar di Mobile
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.querySelector('.navbar-toggler');
    const sidebar = document.querySelector('.sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }
    
    // Tutup sidebar saat klik link
    const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            sidebar.classList.remove('show');
        });
    });
    
    // Tutup sidebar saat klik di luar
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.sidebar') && !event.target.closest('.navbar-toggler')) {
            sidebar.classList.remove('show');
        }
    });
});

// 2. Auto-hide Alert setelah 5 detik
function autoHideAlert() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (typeof bootstrap !== 'undefined') {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } else {
                alert.style.display = 'none';
            }
        }, 5000);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', autoHideAlert);
} else {
    autoHideAlert();
}

// 3. Konfirmasi Delete
document.addEventListener('DOMContentLoaded', function() {
    // Untuk tombol dengan class .btn-delete
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                const form = this.closest('form');
                if (form) {
                    form.submit();
                } else {
                    // Jika bukan dalam form, langsung ke URL
                    window.location.href = this.getAttribute('href');
                }
            }
        });
    });
    
    // Untuk link delete di tabel (dengan onclick inline)
    document.querySelectorAll('a[href*="action=tamu_delete"]').forEach(link => {
        if (!link.hasAttribute('data-confirm-added')) {
            link.addEventListener('click', function(e) {
                return confirm('Apakah Anda yakin ingin menghapus data ini?');
            });
            link.setAttribute('data-confirm-added', 'true');
        }
    });
});

// 4. Format Tanggal Otomatis
function formatInputDate(inputElement) {
    inputElement.addEventListener('blur', function() {
        if (this.value) {
            const date = new Date(this.value);
            if (!isNaN(date)) {
                this.value = date.toISOString().split('T')[0];
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => formatInputDate(input));
});

// 5. Validasi Form Sebelum Submit
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form:not(.form-no-validate)');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                const value = input.value.trim();
                
                // Lewati validasi untuk hidden input
                if (input.type === 'hidden') {
                    return;
                }
                
                if (!value) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Mohon isi semua field yang wajib diisi!');
            }
        });
    });
});

// 6. Real-time Character Counter untuk Textarea
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('textarea[maxlength]').forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');
        const counter = document.createElement('small');
        counter.className = 'text-muted d-block mt-1';
        textarea.parentElement.appendChild(counter);
        
        function updateCounter() {
            const remaining = maxLength - textarea.value.length;
            counter.textContent = `${textarea.value.length}/${maxLength} karakter`;
            
            if (remaining < 20) {
                counter.classList.add('text-danger');
            } else {
                counter.classList.remove('text-danger');
            }
        }
        
        textarea.addEventListener('input', updateCounter);
        updateCounter();
    });
});

// 7. Highlight Active Menu berdasarkan URL
function setActiveMenu() {
    const currentAction = new URLSearchParams(window.location.search).get('action');
    
    document.querySelectorAll('.nav-link, .sidebar .nav-link').forEach(link => {
        link.classList.remove('active');
        
        const href = link.getAttribute('href') || '';
        
        // Cocokkan dengan action di URL
        if (href.includes('action=' + currentAction)) {
            link.classList.add('active');
        }
        
        // Untuk dashboard
        if (currentAction === 'dashboard' && href.includes('action=dashboard')) {
            link.classList.add('active');
        }
        
        // Untuk tamu
        if ((currentAction === 'tamu' || currentAction.includes('tamu_')) && 
            (href.includes('action=tamu') || href.includes('action=tamu_aktif'))) {
            link.classList.add('active');
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setActiveMenu);
} else {
    setActiveMenu();
}

// 8. Loading Spinner saat Form Submit
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.dataset.submitted) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
                submitBtn.dataset.originalText = originalText;
            }
        });
    });
});

// 9. Tooltip Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});

// 10. Popover Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap !== 'undefined') {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }
});

// 11. Format Waktu (HH:MM)
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="time"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.value) {
                const [hours, minutes] = this.value.split(':');
                this.value = `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
            }
        });
    });
});

// 12. Search/Filter Tabel Real-time
function setupTableFilter(searchInputId, tableId) {
    const searchInput = document.getElementById(searchInputId);
    const table = document.getElementById(tableId);
    
    if (searchInput && table) {
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const isVisible = text.includes(query);
                row.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });
            
            // Tampilkan pesan jika tidak ada hasil
            if (visibleCount === 0) {
                const tbody = table.querySelector('tbody');
                if (!tbody.querySelector('.no-results')) {
                    const noResults = document.createElement('tr');
                    noResults.className = 'no-results';
                    noResults.innerHTML = '<td colspan="100%" class="text-center text-muted py-3">Tidak ada hasil yang cocok</td>';
                    tbody.appendChild(noResults);
                }
            } else {
                const noResults = table.querySelector('tbody .no-results');
                if (noResults) noResults.remove();
            }
        });
    }
}

// 13. Animasi Smooth Scroll
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
});

// 14. Disable Double Submit
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                if (submitBtn.dataset.submitted === 'true') {
                    e.preventDefault();
                    return false;
                }
                submitBtn.dataset.submitted = 'true';
            }
        });
    });
});

// 15. Helper: Debugging (Hapus di production)
window.debugLog = function(message) {
    if (localStorage.getItem('debug') === 'true') {
        console.log('[DEBUG]', message);
    }
};
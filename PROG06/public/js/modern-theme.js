/**
 * Modern Theme JS - Handles UI interactions for the new design system
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Mobile Sidebar Toggle
    initSidebarToggle();
    
    // Initialize dropdowns
    initDropdowns();
    
    // Highlight active navigation item
    highlightActiveNavItem();
    
    // Initialize form validation styling
    enhanceFormValidation();
    
    // Initialize datepicker styling if jQuery UI is available
    if (typeof $.fn.datepicker !== 'undefined') {
        enhanceDatepickers();
    }
    
    // Initialize tabs if present
    initTabs();
    
    // Initialize tooltips
    initTooltips();
    
    // Handle file input styling
    styleFileInputs();
    
    // Add alert dismiss functionality
    initAlertDismiss();
});

/**
 * Initialize sidebar toggle functionality for mobile
 */
function initSidebarToggle() {
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (!menuToggle || !sidebar || !mainContent) return;
    
    menuToggle.addEventListener('click', function() {
        sidebar.classList.toggle('show');
        document.body.classList.toggle('sidebar-open');
    });
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const isMobile = window.innerWidth < 1024;
        const isOutsideSidebar = !sidebar.contains(event.target) && !menuToggle.contains(event.target);
        
        if (isMobile && isOutsideSidebar && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            document.body.classList.remove('sidebar-open');
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('show');
            document.body.classList.remove('sidebar-open');
        }
    });
}

/**
 * Initialize dropdown menus
 */
function initDropdowns() {
    const dropdownToggles = document.querySelectorAll('[data-toggle="dropdown"]');
    
    dropdownToggles.forEach(toggle => {
        const menu = toggle.nextElementSibling;
        
        if (!menu || !menu.classList.contains('profile-menu')) return;
        
        toggle.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            menu.classList.toggle('show');
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const openMenus = document.querySelectorAll('.profile-menu.show');
        
        openMenus.forEach(menu => {
            const toggle = menu.previousElementSibling;
            
            if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.classList.remove('show');
            }
        });
    });
}

/**
 * Highlight active navigation item based on current URL
 */
function highlightActiveNavItem() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.sidebar-menu a');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        
        // Check if the current path matches the link or is a child page
        if (href === currentPath || 
            (currentPath.startsWith(href) && href !== '/' && href !== '#')) {
            link.classList.add('active');
            
            // If the link is in a submenu, expand the parent menu
            const parentMenu = link.closest('.submenu');
            if (parentMenu) {
                const parentToggle = parentMenu.previousElementSibling;
                parentMenu.classList.add('show');
                parentToggle.classList.add('active');
            }
        }
    });
}

/**
 * Enhance form validation with visual feedback
 */
function enhanceFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            // Add validation styling on blur
            input.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else if (this.value !== '') {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
            
            // Reset validation styling on focus
            input.addEventListener('focus', function() {
                this.classList.remove('is-invalid');
                this.classList.remove('is-valid');
            });
        });
        
        // Prevent form submission if invalid
        form.addEventListener('submit', function(event) {
            if (!this.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                // Show validation errors
                const invalidInputs = this.querySelectorAll(':invalid');
                invalidInputs.forEach(input => {
                    input.classList.add('is-invalid');
                });
            }
            
            form.classList.add('was-validated');
        });
    });
}

/**
 * Enhance datepicker styling for jQuery UI datepicker
 */
function enhanceDatepickers() {
    $.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        yearRange: 'c-100:c+10',
        showOtherMonths: true,
        selectOtherMonths: true,
        beforeShow: function(input, inst) {
            // Ensure the datepicker is styled correctly
            inst.dpDiv.addClass('modern-datepicker');
        }
    });
}

/**
 * Initialize tab navigation
 */
function initTabs() {
    const tabLinks = document.querySelectorAll('[data-tab]');
    
    tabLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            
            const targetId = this.getAttribute('data-tab');
            const tabContainer = this.closest('.tabs-container');
            
            if (!tabContainer) return;
            
            // Deactivate all tabs
            tabContainer.querySelectorAll('[data-tab]').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Hide all tab content
            tabContainer.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Activate clicked tab and its content
            this.classList.add('active');
            document.getElementById(targetId).classList.add('active');
        });
    });
    
    // Activate the first tab by default
    const tabContainers = document.querySelectorAll('.tabs-container');
    
    tabContainers.forEach(container => {
        const firstTab = container.querySelector('[data-tab]');
        if (firstTab) {
            firstTab.click();
        }
    });
}

/**
 * Initialize tooltips
 */
function initTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    
    tooltips.forEach(tooltip => {
        const text = tooltip.getAttribute('data-tooltip');
        const tooltipEl = document.createElement('div');
        
        tooltipEl.className = 'tooltip';
        tooltipEl.textContent = text;
        
        tooltip.appendChild(tooltipEl);
        
        tooltip.addEventListener('mouseenter', () => {
            tooltipEl.classList.add('show');
        });
        
        tooltip.addEventListener('mouseleave', () => {
            tooltipEl.classList.remove('show');
        });
    });
}

/**
 * Style file input elements
 */
function styleFileInputs() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        const parent = input.parentElement;
        
        if (parent.classList.contains('custom-file')) return;
        
        // Create file label
        const fileLabel = document.createElement('label');
        fileLabel.className = 'file-label';
        fileLabel.innerHTML = '<span class="file-text">Choose file</span>';
        
        // Style the original input
        input.classList.add('file-input');
        
        // Update label text when file is selected
        input.addEventListener('change', function() {
            const fileName = this.files.length ? this.files[0].name : 'Choose file';
            fileLabel.querySelector('.file-text').textContent = fileName;
        });
        
        // Insert the label after the input
        input.parentNode.insertBefore(fileLabel, input.nextSibling);
        fileLabel.prepend(input);
    });
}

/**
 * Initialize alert dismiss functionality
 */
function initAlertDismiss() {
    const dismissButtons = document.querySelectorAll('.alert .dismiss');
    
    dismissButtons.forEach(button => {
        button.addEventListener('click', function() {
            const alert = this.closest('.alert');
            
            // Add fade out class
            alert.classList.add('fade-out');
            
            // Remove after animation
            setTimeout(() => {
                alert.remove();
            }, 300);
        });
    });
}

/**
 * Add custom enhancements for the message system
 */
function enhanceMessageSystem() {
    const messageForm = document.querySelector('.message-form');
    
    if (!messageForm) return;
    
    const recipientSelect = messageForm.querySelector('#recipient');
    const messageSend = messageForm.querySelector('.message-send');
    
    if (recipientSelect) {
        // Add nice select styling if Select2 is available
        if (typeof $.fn.select2 !== 'undefined') {
            $(recipientSelect).select2({
                placeholder: "Select recipient",
                theme: "modern"
            });
        }
    }
    
    // Add typing animation
    if (messageSend) {
        messageSend.addEventListener('click', function() {
            const messageStatus = document.querySelector('.message-status');
            
            if (messageStatus) {
                messageStatus.innerHTML = '<span class="typing-indicator"><span></span><span></span><span></span></span> Sending...';
                messageStatus.style.display = 'block';
                
                // Reset after form submission
                setTimeout(() => {
                    messageStatus.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> Message sent!</span>';
                    
                    setTimeout(() => {
                        messageStatus.style.display = 'none';
                    }, 3000);
                }, 1500);
            }
        });
    }
}

// Call this function to provide full calendar enhancements if needed
function enhanceCalendar() {
    // Initialize FullCalendar if it's available
    if (typeof FullCalendar !== 'undefined') {
        const calendarEl = document.getElementById('calendar');
        
        if (!calendarEl) return;
        
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            themeSystem: 'standard',
            events: calendarEvents || [], // Get event data from the page or an API
            eventClick: function(info) {
                showEventDetails(info.event);
            }
        });
        
        calendar.render();
    }
}

// Call this when the page is fully loaded
window.addEventListener('load', function() {
    // Call any additional enhancement functions here
    enhanceMessageSystem();
    
    // Performance optimization - remove preloader if exists
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        preloader.classList.add('fade-out');
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
});

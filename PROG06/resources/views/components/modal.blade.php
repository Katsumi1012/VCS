<div id="{{ $id }}" class="modal" style="display: none;">
    <div class="modal-backdrop"></div>
    
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ $title }}</h3>
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                {{ $slot }}
            </div>
            
            @if(isset($footer))
            <div class="modal-footer">
                {{ $footer }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
    display: none;
}

.modal.show {
    display: block;
}

.modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.modal-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
}

.modal-content {
    background-color: var(--white);
    border-radius: var(--rounded-lg);
    box-shadow: var(--shadow-xl);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.modal-header {
    padding: var(--spacing-4) var(--spacing-6);
    border-bottom: 1px solid var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-800);
}

.modal-close {
    background: none;
    border: none;
    color: var(--gray-500);
    cursor: pointer;
    padding: var(--spacing-2);
    border-radius: var(--rounded-md);
    transition: var(--transition-all);
}

.modal-close:hover {
    background-color: var(--gray-100);
    color: var(--gray-700);
}

.modal-body {
    padding: var(--spacing-6);
    overflow-y: auto;
}

.modal-footer {
    padding: var(--spacing-4) var(--spacing-6);
    border-top: 1px solid var(--gray-100);
    background-color: var(--gray-50);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: var(--spacing-2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize modal functionality
    initModals();
});

function initModals() {
    const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
    
    modalTriggers.forEach(trigger => {
        const targetId = trigger.getAttribute('data-target');
        const modal = document.querySelector(targetId);
        
        if (!modal) return;
        
        trigger.addEventListener('click', function(event) {
            event.preventDefault();
            showModal(modal);
        });
        
        // Close button
        const closeButtons = modal.querySelectorAll('[data-dismiss="modal"]');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                hideModal(modal);
            });
        });
        
        // Close when clicking backdrop
        const backdrop = modal.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.addEventListener('click', function() {
                hideModal(modal);
            });
        }
    });
    
    // Close modal with ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const openModals = document.querySelectorAll('.modal.show');
            openModals.forEach(modal => {
                hideModal(modal);
            });
        }
    });
}

function showModal(modal) {
    modal.classList.add('show');
    document.body.classList.add('modal-open');
    modal.style.display = 'block';
    
    // Prevent background scrolling
    document.body.style.overflow = 'hidden';
}

function hideModal(modal) {
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
    
    // Restore background scrolling
    document.body.style.overflow = '';
}
</script>

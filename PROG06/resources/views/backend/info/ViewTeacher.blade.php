@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Teachers Directory</h1>
    <div class="search-container">
        <input type="text" id="teacherSearch" class="search-input" placeholder="Search teachers...">
        <span class="search-icon">
            <i class="fas fa-search"></i>
        </span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($teachers as $teacher)
    <div class="card teacher-card">
        <div class="card-body">
            <div class="flex items-center mb-4">
                <div class="profile-avatar mr-4">
                    @if($teacher->user->profile_picture !== 'avatar.png')
                        <img src="{{ asset('images/profile/' . $teacher->user->profile_picture) }}" alt="{{ $teacher->user->name }}">
                    @else
                        {{ substr($teacher->user->name, 0, 1) }}
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $teacher->user->name }}</h3>
                    @if($teacher->subject)
                        <span class="badge badge-primary">{{ $teacher->subject }}</span>
                    @endif
                </div>
            </div>
            
            <div class="profile-info">
                <div class="profile-info-item">
                    <span class="profile-info-label">
                        <i class="fas fa-envelope text-gray-500 mr-2"></i>
                        Email:
                    </span>
                    <span class="profile-info-value">{{ $teacher->user->email }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label">
                        <i class="fas fa-phone text-gray-500 mr-2"></i>
                        Phone:
                    </span>
                    <span class="profile-info-value">{{ $teacher->phone ?: 'N/A' }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label">
                        <i class="fas fa-venus-mars text-gray-500 mr-2"></i>
                        Gender:
                    </span>
                    <span class="profile-info-value">{{ ucfirst($teacher->gender) }}</span>
                </div>
            </div>
            
            <div class="mt-4 flex justify-end">
                <a href="{{ route('info.ShowTeacher', $teacher->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye btn-icon"></i>
                    <span>View Details</span>
                </a>
                <a href="{{ route('message.sendmessage', $teacher->user->id) }}" class="btn btn-sm btn-light ml-2">
                    <i class="fas fa-paper-plane btn-icon"></i>
                    <span>Send Message</span>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($teachers->count() == 0)
<div class="alert alert-info mt-6">
    <div class="alert-content">
        <p>No teachers found.</p>
    </div>
</div>
@endif

<div class="pagination-container mt-6">
    {{ $teachers->links() }}
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Teacher search functionality
        const searchInput = document.getElementById('teacherSearch');
        const teacherCards = document.querySelectorAll('.teacher-card');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            teacherCards.forEach(card => {
                const teacherName = card.querySelector('h3').textContent.toLowerCase();
                const teacherEmail = card.querySelector('.profile-info-value').textContent.toLowerCase();
                const teacherSubject = card.querySelector('.badge') ? 
                    card.querySelector('.badge').textContent.toLowerCase() : '';
                
                if (teacherName.includes(searchTerm) || 
                    teacherEmail.includes(searchTerm) ||
                    teacherSubject.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show message when no results found
            const visibleCards = document.querySelectorAll('.teacher-card[style="display: block;"]');
            const noResultsMessage = document.getElementById('noResults');
            
            if (visibleCards.length === 0 && searchTerm !== '') {
                if (!noResultsMessage) {
                    const message = document.createElement('div');
                    message.id = 'noResults';
                    message.className = 'alert alert-info mt-6';
                    message.innerHTML = `
                        <div class="alert-content">
                            <p>No teachers found matching "${searchTerm}".</p>
                        </div>
                    `;
                    document.querySelector('.pagination-container').before(message);
                }
            } else if (noResultsMessage) {
                noResultsMessage.remove();
            }
        });
    });
</script>
@endpush


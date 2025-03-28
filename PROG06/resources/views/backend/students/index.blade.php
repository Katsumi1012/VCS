@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title">Students</h1>
    <div class="flex items-center gap-3">
        <div class="search-container">
            <input type="text" id="studentSearch" class="search-input" placeholder="Search students...">
            <span class="search-icon">
                <i class="fas fa-search"></i>
            </span>
        </div>
        <a href="{{ route('student.create') }}" class="btn btn-primary">
            <i class="fas fa-plus btn-icon"></i>
            <span>Add Student</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Student Directory</h2>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table" id="studentsTable">
                <thead>
                    <tr>
                        <th class="w-10">
                            <div class="flex items-center">
                                <span>ID</span>
                                <button class="ml-1 text-gray-500 hover:text-primary sort-btn" data-col="0">
                                    <i class="fas fa-sort"></i>
                                </button>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center">
                                <span>Name</span>
                                <button class="ml-1 text-gray-500 hover:text-primary sort-btn" data-col="1">
                                    <i class="fas fa-sort"></i>
                                </button>
                            </div>
                        </th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $index => $student)
                    <tr class="student-row">
                        <td>{{ str_pad($student->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="flex items-center">
                                <div class="profile-avatar w-8 h-8 mr-3">
                                    @if($student->user->profile_picture !== 'avatar.png')
                                        <img src="{{ asset('images/profile/' . $student->user->profile_picture) }}" alt="{{ $student->user->name }}">
                                    @else
                                        {{ substr($student->user->name, 0, 1) }}
                                    @endif
                                </div>
                                <div>{{ $student->user->name }}</div>
                            </div>
                        </td>
                        <td>{{ $student->user->email }}</td>
                        <td>{{ $student->phone ?: 'N/A' }}</td>
                        <td class="text-center">
                            <span class="badge badge-success">Active</span>
                        </td>
                        <td class="text-right">
                            <div class="action-buttons">
                                <a href="{{ route('student.show', $student->id) }}" class="action-btn view-btn" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('student.edit', $student->id) }}" class="action-btn edit-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('student.destroy', $student->id) }}" method="POST" class="inline delete-form" style="margin: 0; padding: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="action-btn delete-btn" data-name="{{ $student->user->name }}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer flex items-center justify-between">
        <div class="text-sm text-gray-600">
            Showing <span class="font-medium">{{ $students->firstItem() }}</span> to 
            <span class="font-medium">{{ $students->lastItem() }}</span> of 
            <span class="font-medium">{{ $students->total() }}</span> students
        </div>
        <div class="pagination">
            {{ $students->links() }}
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal" style="display: none;">
    <div class="modal-backdrop"></div>
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Delete</h3>
                <button type="button" class="modal-close" data-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete student <strong id="studentName"></strong>?</p>
                <p class="text-red-500 mt-2">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<style>
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 4px;
        transition: all 0.2s ease;
        color: white;
        line-height: 1; /* Fix line height alignment */
        padding: 0; /* Remove padding that could cause misalignment */
        position: relative; /* Added for absolute positioning of icons */
    }
    
    .view-btn {
        background-color: #3b82f6;
    }
    
    .view-btn:hover {
        background-color: #2563eb;
    }
    
    .edit-btn {
        background-color: #10b981;
    }
    
    .edit-btn:hover {
        background-color: #059669;
    }
    
    .delete-btn {
        background-color: #ef4444;
        border: none;
        cursor: pointer;
    }
    
    .delete-btn:hover {
        background-color: #dc2626;
    }
    
    /* New improved icon alignment */
    .action-btn i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 14px;
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('studentSearch');
        const studentRows = document.querySelectorAll('.student-row');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            studentRows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                const phone = row.cells[3].textContent.toLowerCase();
                
                if (name.includes(searchTerm) || 
                    email.includes(searchTerm) || 
                    phone.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Sort functionality
        const sortButtons = document.querySelectorAll('.sort-btn');
        sortButtons.forEach(button => {
            button.addEventListener('click', function() {
                const column = this.dataset.col;
                const table = document.getElementById('studentsTable');
                sortTable(table, parseInt(column));
            });
        });

        function sortTable(table, column) {
            const rows = Array.from(table.rows).slice(1); // Skip header row
            const isAsc = table.dataset.sortDir === 'asc' && table.dataset.sortCol === column.toString();
            
            table.dataset.sortDir = isAsc ? 'desc' : 'asc';
            table.dataset.sortCol = column;
            
            rows.sort((a, b) => {
                let valA = a.cells[column].textContent.trim();
                let valB = b.cells[column].textContent.trim();
                
                // Convert to numbers if possible
                if (!isNaN(valA) && !isNaN(valB)) {
                    return isAsc ? valB - valA : valA - valB;
                }
                
                // Otherwise compare as strings
                return isAsc ? 
                    valB.localeCompare(valA) : 
                    valA.localeCompare(valB);
            });
            
            // Append sorted rows
            const tbody = table.tBodies[0];
            rows.forEach(row => tbody.appendChild(row));
        }

        // Delete confirmation modal
        const deleteModal = document.getElementById('deleteModal');
        const studentName = document.getElementById('studentName');
        const confirmDelete = document.getElementById('confirmDelete');
        const closeBtns = deleteModal.querySelectorAll('[data-dismiss="modal"]');
        let activeForm = null;

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                activeForm = this.closest('.delete-form');
                studentName.textContent = this.dataset.name;
                deleteModal.style.display = 'block';
            });
        });

        confirmDelete.addEventListener('click', function() {
            if (activeForm) {
                activeForm.submit();
            }
            deleteModal.style.display = 'none';
        });

        closeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                deleteModal.style.display = 'none';
            });
        });

        window.addEventListener('click', function(event) {
            if (event.target === deleteModal.querySelector('.modal-backdrop')) {
                deleteModal.style.display = 'none';
            }
        });
    });
</script>
@endpush
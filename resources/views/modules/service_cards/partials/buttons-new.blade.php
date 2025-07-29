<style>
    .action-dropdown {
        position: relative;
        display: inline-block;
    }

    .action-dropdown-toggle {
        background: transparent;
        border: none;
        padding: 6px 8px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #6c757d;
    }

    .action-dropdown-toggle:hover {
        background-color: #f8f9fa;
        color: #495057;
    }

    .action-dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 160px;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: opacity 0.15s ease, visibility 0.15s ease, transform 0.15s ease;
        max-height: 300px;
        overflow-y: auto;
    }

    .action-dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .action-dropdown.dropup .action-dropdown-menu {
        top: auto;
        bottom: 100%;
        transform: translateY(10px);
    }

    .action-dropdown.dropup .action-dropdown-menu.show {
        transform: translateY(0);
    }

    .action-dropdown.dropup.closing .action-dropdown-menu {
        transform: translateY(10px);
        opacity: 0;
        visibility: hidden;
    }

    .action-dropdown-item {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        color: #495057;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        font-size: 13px;
    }

    .action-dropdown-item:hover {
        background-color: #f8f9fa;
        color: #212529;
    }

    .action-dropdown-item i {
        width: 16px;
        text-align: center;
    }

    .action-dropdown-divider {
        height: 1px;
        background-color: #dee2e6;
        margin: 2px 0;
    }

    .table-responsive {
        overflow: visible !important;
    }

    .dataTables_wrapper {
        overflow: visible !important;
    }

    .dataTables_scrollBody {
        overflow: visible !important;
    }

    .dataTables_scroll {
        overflow: visible !important;
    }

    .table td {
        overflow: visible !important;
    }

    .table tbody tr {
        overflow: visible !important;
    }

    .action-column {
        position: relative;
        z-index: 10;
        overflow: visible !important;
    }

    .action-dropdown.active {
        z-index: 99999;
    }

    .action-dropdown.active .action-dropdown-menu {
        z-index: 99999;
    }
</style>

@php
    $status = $row->status;
    $isExpired = $row->isExpired();
    $canBeRenewed = $row->canBeRenewed();
    $user = auth()->user();
@endphp

<div class="action-dropdown">
    <button type="button" class="action-dropdown-toggle" data-id="{{ $row->id }}">
        <i class="bi-three-dots-vertical bg-light border"></i>
    </button>

    <div class="action-dropdown-menu">
        {{-- View Actions --}}
        @if ($user->can('detail', $row))
            <button type="button" class="action-dropdown-item view-btn" data-id="{{ $row->id }}">
                <i class="bi-eye text-primary"></i>
                <span>View Details</span>
            </button>
            <button type="button" class="action-dropdown-item info-btn" data-id="{{ $row->id }}">
                <i class="bi-info-circle text-info"></i>
                <span>View Remarks</span>
            </button>
            <div class="action-dropdown-divider"></div>
        @endif

        {{-- Status Actions --}}
        @if ($status === 'draft' && $user->can('pending', $row))
            <button type="button" class="action-dropdown-item pending-btn" data-id="{{ $row->id }}">
                <i class="bi-hourglass text-info"></i>
                <span>Mark as Pending</span>
            </button>
        @endif

        @if ($status === 'pending' && $user->can('verify', $row))
            <button type="button" class="action-dropdown-item verify-btn" data-id="{{ $row->id }}">
                <i class="bi-check-circle text-success"></i>
                <span>Verify Card</span>
            </button>
        @endif

        @if ($status === 'pending' && $user->can('reject', $row))
            <button type="button" class="action-dropdown-item reject-btn" data-id="{{ $row->id }}">
                <i class="bi-x-circle text-danger"></i>
                <span>Reject Card</span>
            </button>
        @endif

        {{-- Print Actions --}}
        @if ($status === 'active' && $row->printed_at === null && $user->can('markPrinted', $row))
            <button type="button" class="action-dropdown-item print-btn" data-id="{{ $row->id }}">
                <i class="bi-printer text-info"></i>
                <span>Mark as Printed</span>
            </button>
        @endif

        @if ($status === 'active' && $row->printed_at !== null && $user->can('viewCard', $row))
            <button type="button" class="action-dropdown-item card-btn" data-id="{{ $row->id }}">
                <i class="bi-credit-card text-info"></i>
                <span>View Card</span>
            </button>
        @endif

        {{-- Card Management Actions --}}
        @if ($status === 'active' && !$isExpired && $user->can('markLost', $row))
            <button type="button" class="action-dropdown-item mark-lost-btn" data-id="{{ $row->id }}">
                <i class="bi-exclamation-triangle text-warning"></i>
                <span>Mark as Lost</span>
            </button>
        @endif

        @if (($status === 'active' || $status === 'expired' || $status === 'lost') && $canBeRenewed && $user->can('renew', $row))
            <button type="button" class="action-dropdown-item renew-btn" data-id="{{ $row->id }}">
                <i class="bi-arrow-clockwise text-primary"></i>
                <span>Renew Card</span>
            </button>
        @endif

        @if ($status === 'lost' && $user->can('duplicate', $row))
            <button type="button" class="action-dropdown-item duplicate-btn" data-id="{{ $row->id }}">
                <i class="bi-stack text-info"></i>
                <span>Create Duplicate</span>
            </button>
        @endif

        {{-- Duplicate Card Actions --}}
        @if ($status === 'duplicate' && $row->printed_at === null && $user->can('markPrinted', $row))
            <button type="button" class="action-dropdown-item print-btn" data-id="{{ $row->id }}">
                <i class="bi-printer text-info"></i>
                <span>Mark as Printed</span>
            </button>
        @endif

        @if ($status === 'duplicate' && $row->printed_at !== null && $user->can('viewCard', $row))
            <button type="button" class="action-dropdown-item card-btn" data-id="{{ $row->id }}">
                <i class="bi-credit-card text-info"></i>
                <span>View Card</span>
            </button>
        @endif

        {{-- Restore Action --}}
        @if ($status === 'rejected' && $user->can('restore', $row))
            <button type="button" class="action-dropdown-item restore-btn" data-id="{{ $row->id }}">
                <i class="bi-arrow-counterclockwise text-success"></i>
                <span>Restore to Draft</span>
            </button>
        @endif

        {{-- Delete Action --}}
        @if ($user->can('delete', $row))
            @if (($status === 'active' && $row->printed_at !== null) || in_array($status, ['pending', 'rejected', 'draft']))
                <div class="action-dropdown-divider"></div>
            @endif
            <button type="button" class="action-dropdown-item delete-btn" data-id="{{ $row->id }}">
                <i class="bi-trash text-danger"></i>
                <span>Delete Card</span>
            </button>
        @endif
    </div>
</div>

{{-- Code to paste in layout --}}

{{-- $(document).on('click', '.action-dropdown-toggle', function(e) {
    e.stopPropagation();
    
    const dropdown = $(this).closest('.action-dropdown');
    const menu = dropdown.find('.action-dropdown-menu');
    const isOpen = menu.hasClass('show');
    
    closeAllDropdowns();
    
    if (!isOpen) {
        dropdown.addClass('active');
        
        const dropdownRect = dropdown[0].getBoundingClientRect();
        const menuHeight = 300;
        const windowHeight = window.innerHeight;
        const spaceBelow = windowHeight - dropdownRect.bottom;
        
        if (spaceBelow < menuHeight && dropdownRect.top > menuHeight) {
            dropdown.addClass('dropup');
        }
        
        dropdown.closest('td').css({
            'position': 'relative',
            'z-index': '99999',
            'overflow': 'visible'
        });
        
        menu.addClass('show');
    } else {
        closeDropdown(dropdown);
    }
});

function closeDropdown(dropdown) {
    const menu = dropdown.find('.action-dropdown-menu');
    
    if (dropdown.hasClass('dropup')) {
        dropdown.addClass('closing');
    }
    
    menu.removeClass('show');
    
    setTimeout(() => {
        dropdown.removeClass('dropup active closing');
        dropdown.closest('td').css({
            'position': '',
            'z-index': '',
            'overflow': ''
        });
    }, 150);
}

function closeAllDropdowns() {
    $('.action-dropdown').each(function() {
        const dropdown = $(this);
        const menu = dropdown.find('.action-dropdown-menu');
        
        if (menu.hasClass('show')) {
            closeDropdown(dropdown);
        }
    });
}

$(document).on('click', function(e) {
    if (!$(e.target).closest('.action-dropdown').length) {
        closeAllDropdowns();
    }
});

$(document).on('click', '.action-dropdown-item', function() {
    const dropdown = $(this).closest('.action-dropdown');
    closeDropdown(dropdown);
});

$(document).on('click', '.action-dropdown-menu', function(e) {
    e.stopPropagation();
}); --}}
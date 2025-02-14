<x-app-layout title="User Hierarchy">
    @push('style')
    <link href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <style>
        /* TomSelect adjustments */
        .subordinate-selector .ts-wrapper {
            width: 100% !important;
            min-width: 200px;
        }
        .subordinate-selector .ts-control {
            width: 100% !important;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
        }
        .ts-dropdown {
            width: 100% !important;
        }
        .ts-dropdown-content {
            max-height: 200px;
            overflow-y: auto;
        }
        /* jKanban customizations */
        .kanban-board {
            /* We want each board to look like a card */
            background: #f1f3f5;
            border-radius: 0.25rem;
            padding: 10px;
        }
        .kanban-board-header {
            font-weight: 600;
            margin-bottom: 10px;
        }
        .kanban-item {
            cursor: move;
            margin: 8px 0;
            padding: 12px;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            user-select: none;
        }
        .kanban-item:hover {
            background-color: #f8f9fa;
        }
        .kanban-item.is-dragging {
            opacity: 0.8;
            background-color: #e9ecef;
        }
        .kanban-board.drag-target {
            background-color: rgba(0, 123, 255, 0.1);
            border: 2px dashed #007bff;
        }
        /* Footer for the subordinate selector */
        .subordinate-selector {
            margin-top: 10px;
        }
    </style>
    @endpush

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <!-- Main selector for which users’ boards to show -->
                <select id="userSelector" class="form-select" multiple placeholder="Select users to show their teams..."></select>
            </div>
        </div>
        <!-- The single global Kanban container -->
        <div id="kanbanContainer"></div>
    </div>

    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        // Global variables
        let globalKanban; // our single jKanban instance
        let subordinateSelectors = new Map(); // map of TomSelect instances by userId
        let mainSelector = null; // main TomSelect for boards
        let boardsData = {}; // cache of board data by userId

        // Initialize the main user selector
        mainSelector = new TomSelect('#userSelector', {
            valueField: 'id',
            labelField: 'name',
            searchField: ['name', 'email'],
            persist: false,
            maxOptions: null,
            plugins: ['remove_button'],
            onInitialize() {
                // Load all users from backend
                this.addOptions(@json($users->toArray()));
            },
            onChange(selected) {
                updateKanbanVisibility(selected);
            }
        });

        // Fetch full user data (including subordinates) via AJAX
        async function fetchUserData(userId) {
            const url = "{{ route('admin.users.show', ':id') }}".replace(':id', userId);
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            return await response.json();
        }

        // Update user’s boss via AJAX
        async function updateUserBoss(userId, bossId) {
            const url = "{{ route('admin.users.update-boss', ':id') }}".replace(':id', userId);
            const response = await fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ boss_id: bossId })
            });
            if (!response.ok) {
                throw new Error('Failed to update user hierarchy');
            }
            return await response.json();
        }

        // Initialize a single global jKanban instance that will hold all boards
        function initializeGlobalKanban() {
            globalKanban = new jKanban({
                element: '#kanbanContainer',
                gutter: '15px',
                boards: [],
                dragBoards: false, // we only need item dragging
                itemHandle: '.kanban-item',
                // When starting to drag an item, highlight drop targets
                dragEl: function(el, source) {
                    document.querySelectorAll('.kanban-board').forEach(board => {
                        board.style.backgroundColor = '#f8f9fa';
                    });
                    el.style.backgroundColor = '#e9ecef';
                },
                dragendEl: function(el) {
                    document.querySelectorAll('.kanban-board').forEach(board => {
                        board.style.backgroundColor = '';
                    });
                    el.style.backgroundColor = '';
                },
                // When an item is dropped into a board, update its boss
                dropEl: async function(el, target, source, sibling) {
                    const userId = el.getAttribute('data-eid');
                    const newBossId = target.closest('.kanban-board').getAttribute('data-id');
                    const sourceBossId = source.closest('.kanban-board').getAttribute('data-id');
                    try {
                        await updateUserBoss(userId, newBossId);
                        // Refresh both affected boards
                        await refreshKanbanBoard(newBossId);
                        if (sourceBossId !== newBossId) {
                            await refreshKanbanBoard(sourceBossId);
                        }
                    } catch (error) {
                        console.error('Drag failed:', error);
                        // Revert the item visually
                        source.appendChild(el);
                    }
                }
            });
        }

        // Create or update a board (column) for a given user
        async function createOrUpdateBoard(userId) {
            const userData = await fetchUserData(userId);
            boardsData[userId] = userData;

            // Prepare board object for jKanban
            const boardObj = {
                id: userData.id.toString(),
                title: `${userData.name} (Subordinates: ${userData.subordinates?.length || 0})`,
                item: (userData.subordinates || []).map(sub => ({
                    id: sub.id.toString(),
                    title: sub.name,
                    drag: true,
                    attributes: { 'data-eid': sub.id.toString() }
                }))
            };

            // If the board already exists, remove it first so we can update it
            let boardElement = document.querySelector(`.kanban-board[data-id="${userData.id}"]`);
            if (boardElement) {
                globalKanban.removeBoard(userData.id.toString());
            }

            // Add the new/updated board
            globalKanban.addBoards([boardObj]);

            // After the board is rendered, modify its header and add a subordinate selector footer.
            setTimeout(() => {
                boardElement = document.querySelector(`.kanban-board[data-id="${userData.id}"]`);
                if (boardElement) {
                    // Replace default header with custom header containing remove button
                    const header = boardElement.querySelector('.kanban-board-header');
                    if (header) {
                        header.innerHTML = `
                            <div class="d-flex justify-content-between align-items-center">
                                <span>${userData.name} (Subordinates: ${userData.subordinates?.length || 0})</span>
                                <button class="btn btn-sm btn-outline-danger remove-board" data-id="${userData.id}">&times;</button>
                            </div>
                        `;
                        header.querySelector('.remove-board').addEventListener('click', (e) => {
                            e.preventDefault();
                            removeBoard(userData.id);
                        });
                    }
                    // Append a footer (if not already present) for the subordinate selector
                    if (!boardElement.querySelector('.subordinate-selector')) {
                        const footer = document.createElement('div');
                        footer.className = 'subordinate-selector';
                        footer.innerHTML = `<select class="form-select add-subordinate" placeholder="Add team member..."></select>`;
                        boardElement.appendChild(footer);
                        // Initialize TomSelect on the subordinate selector
                        const selectEl = footer.querySelector('select.add-subordinate');
                        const subordinateSelector = new TomSelect(selectEl, {
                            valueField: 'id',
                            labelField: 'name',
                            searchField: ['name', 'email'],
                            persist: false,
                            maxItems: 1,
                            plugins: ['clear_button'],
                            render: {
                                option: function(data, escape) {
                                    return `<div class="py-2 px-3">${escape(data.name)}</div>`;
                                },
                                item: function(data, escape) {
                                    return `<div>${escape(data.name)}</div>`;
                                }
                            },
                            onInitialize: async function() {
                                const url = `/admin/users/${userData.id}/available-subordinates`;
                                const response = await fetch(url);
                                const availableUsers = await response.json();
                                this.addOptions(availableUsers);
                                if (this.control) {
                                    this.control.querySelector('.ts-control').setAttribute('placeholder', 'Add team member...');
                                }
                            },
                            onItemAdd: async (value) => {
                                try {
                                    await updateUserBoss(value, userData.id);
                                    // Refresh this board
                                    await refreshKanbanBoard(userData.id);
                                    // Refresh available subordinates
                                    const response = await fetch(`/admin/users/${userData.id}/available-subordinates`);
                                    const availableUsers = await response.json();
                                    subordinateSelector.clearOptions();
                                    subordinateSelector.addOptions(availableUsers);
                                    subordinateSelector.refreshOptions();
                                    subordinateSelector.clear();
                                } catch (error) {
                                    console.error('Failed to add subordinate:', error);
                                    subordinateSelector.clear();
                                }
                            }
                        });
                        subordinateSelectors.set(userData.id, subordinateSelector);
                    }
                }
            }, 100);
        }

        // Refresh a board by re-fetching its data and updating its contents
        async function refreshKanbanBoard(userId) {
            await createOrUpdateBoard(userId);
        }

        // Remove a board from the global Kanban (and clean up its TomSelect instance)
        function removeBoard(userId) {
            globalKanban.removeBoard(userId.toString());
            if (subordinateSelectors.has(userId)) {
                subordinateSelectors.get(userId).destroy();
                subordinateSelectors.delete(userId);
            }
            // Also update the main selector to remove this user
            const currentValue = mainSelector.getValue();
            const newValue = currentValue.filter(id => id !== userId.toString());
            mainSelector.setValue(newValue, true);
        }

        // Add/update boards according to the main selector’s chosen user IDs
        async function updateKanbanVisibility(selectedUserIds) {
            const userIds = Array.isArray(selectedUserIds) ? selectedUserIds : [selectedUserIds];
            // Remove boards that are no longer selected
            const existingBoards = Array.from(document.querySelectorAll('.kanban-board')).map(el => el.getAttribute('data-id'));
            existingBoards.forEach(id => {
                if (!userIds.includes(id)) {
                    removeBoard(parseInt(id));
                }
            });
            // Create or update boards for each selected user
            for (const userId of userIds) {
                await createOrUpdateBoard(userId);
            }
        }

        // On page load, initialize the global Kanban and set initial boards
        document.addEventListener('DOMContentLoaded', () => {
            initializeGlobalKanban();
            const initialSelection = @json($initialSelection);
            mainSelector.setValue(initialSelection);
        });
    </script>
    @endpush
</x-app-layout>

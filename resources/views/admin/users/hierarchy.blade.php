<x-app-layout title="User Hierarchy">
    @push('style')
    <link href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <style>
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

        .kanban-container {
            min-height: 200px;
            width: 100% !important;
            transition: background-color 0.3s;
            padding: 10px;
            border: 1px dashed #dee2e6;
            border-radius: 4px;
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

        .kanban-board {
            float: none !important;
            display: inline-block;
            padding: 0 15px;
            max-width: 100%;
        }

        .kanban-item:hover {
            background-color: #f8f9fa;
        }

        .kanban-item.is-dragging {
            opacity: 0.8;
            background-color: #e9ecef;
        }

        .kanban-container.drag-target {
            background-color: rgba(0, 123, 255, 0.1);
            border: 2px dashed #007bff;
        }
    </style>
    @endpush

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <select id="userSelector" class="form-select" multiple placeholder="Select users to show their teams..."></select>
            </div>
        </div>
        <div id="kanbanContainer" class="row"></div>
    </div>

    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        let kanbanInstances = new Map();
        let visibleBoards = new Set();
        let subordinateSelectors = new Map();
        let mainSelector = null;

        // Initialize main user selector
        mainSelector = new TomSelect('#userSelector', {
            valueField: 'id',
            labelField: 'name',
            searchField: ['name', 'email'],
            persist: false,
            maxOptions: null,
            plugins: ['remove_button'],
            onInitialize() {
                this.addOptions(@json($users->toArray()));
            },
            onChange(selected) {
                // Get the removed items by comparing with visibleBoards
                const currentBoards = [...visibleBoards];
                const removedIds = currentBoards.filter(id => !selected.includes(id.toString()));
                
                // Remove boards for removed users
                removedIds.forEach(id => {
                    const boardElement = document.getElementById(`board-${id}`);
                    if (boardElement) {
                        boardElement.remove();
                        kanbanInstances.delete(parseInt(id));
                        const selector = subordinateSelectors.get(parseInt(id));
                        if (selector) {
                            selector.destroy();
                            subordinateSelectors.delete(parseInt(id));
                        }
                    }
                });

                updateKanbanVisibility(selected);
            }
        });
        const container = document.getElementById('kanbanContainer');
        
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

        function getAllUsers() {
            const users = @json($users->toArray());
            console.log('All users:', users);
            return users;
        }

        async function createKanbanBoard(userId) {
            const userData = await fetchUserData(userId);
            const boardId = `board-${userData.id}`;
            
            if (document.getElementById(boardId)) {
                return document.getElementById(boardId);
            }

            const boardElement = document.createElement('div');
            boardElement.className = 'col-md-4 kanban-board';
            boardElement.id = boardId;
            boardElement.innerHTML = `
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">${userData.name}</h5>
                            <button class="btn btn-sm btn-outline-danger remove-board" data-id="${userData.id}">&times;</button>
                        </div>
                    </div>
                    <div class="card-body kanban-container" data-board-id="${userData.id}"></div>
                    <div class="card-footer subordinate-selector">
                        <select class="form-select add-subordinate" placeholder="Add team member..."></select>
                    </div>
                </div>
            `;

            // Add remove button handler
            boardElement.querySelector('.remove-board').addEventListener('click', (e) => {
                e.preventDefault();
                const boardId = e.target.dataset.id;
                
                // Remove from main selector
                const currentValue = mainSelector.getValue();
                const newValue = currentValue.filter(id => id !== boardId.toString());
                mainSelector.setValue(newValue, true);
                
                // Directly remove the board
                const boardElement = document.getElementById(`board-${boardId}`);
                if (boardElement) {
                    boardElement.remove();
                    
                    // Clean up instances
                    kanbanInstances.delete(parseInt(boardId));
                    const selector = subordinateSelectors.get(parseInt(boardId));
                    if (selector) {
                        selector.destroy();
                        subordinateSelectors.delete(parseInt(boardId));
                    }
                }
            });

            container.appendChild(boardElement);
            
            // Initialize Kanban
            const kanban = new jKanban({
                element: `#${boardId} .kanban-container`,
                boards: [{
                    id: userData.id.toString(),
                    title: `Subordinates (${userData.subordinates?.length || 0})`,
                    item: (userData.subordinates || []).map(sub => ({
                        id: sub.id.toString(),
                        title: sub.name,
                        drag: true,  // Ensure items are draggable
                        // Add custom attributes
                        attributes: {
                            'data-eid': sub.id.toString()  // Crucial: Match the data attribute
                        }
                    }))
                }],
                itemHandle: '.kanban-item',
                dragBoards: true,  // Allow moving between boards
                
                // Modified drag handlers
                dragEl: (el, source) => {
                    document.querySelectorAll('.kanban-container').forEach(board => {
                        board.style.backgroundColor = '#f8f9fa';
                    });
                    el.style.backgroundColor = '#e9ecef';
                },

                dragendEl: (el) => {
                    document.querySelectorAll('.kanban-container').forEach(board => {
                        board.style.backgroundColor = '';
                    });
                    el.style.backgroundColor = '';
                },

                // Modified drop handler
                dropEl: async (el, target, source, sibling) => {
                    const userId = el.dataset.eid;
                    const newBossId = target.closest('.kanban-board').dataset.boardId;
                    const sourceBossId = source.closest('.kanban-board').dataset.boardId;

                    try {
                        await updateUserBoss(userId, newBossId);

                        // *** KEY CHANGE: Refresh ONLY the affected Kanban boards ***
                        await refreshKanbanBoard(newBossId); // Refresh the new boss's board
                        if (sourceBossId !== newBossId) { // Only refresh source if it's different
                            await refreshKanbanBoard(sourceBossId); // Refresh the old boss's board
                        }

                        // Update the subordinates count on the board titles.
                        await updateBoardTitles([newBossId, sourceBossId]);


                    } catch (error) {
                        console.error('Drag failed:', error);
                        source.appendChild(el); // Revert visually if error
                    }
                },
            });

            // Initialize subordinate selector
            const selectElement = boardElement.querySelector('.add-subordinate');
            const subordinateSelector = new TomSelect(selectElement, {
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
                    console.log('Initializing subordinate selector');
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
                        // Refresh available users
                        const availableUsersResponse = await fetch(`/admin/users/${userData.id}/available-subordinates`);
                        const availableUsers = await availableUsersResponse.json();
                        subordinateSelector.clearOptions();
                        subordinateSelector.addOptions(availableUsers);
                        subordinateSelector.refreshOptions();
                        await updateAllBoards();
                        subordinateSelector.clear();
                    } catch (error) {
                        console.error('Failed to add subordinate:', error);
                        subordinateSelector.clear();
                    }
                }

            });

            // Force update the DOM to ensure proper rendering
            setTimeout(() => {
                subordinateSelector.refreshItems();
                subordinateSelector.refreshOptions(true);
            }, 0);

            kanbanInstances.set(userData.id, kanban);
            subordinateSelectors.set(userData.id, subordinateSelector);
            return boardElement;
        }

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

        async function updateAllBoards() {
            const selectedUserIds = mainSelector.getValue();
            await updateKanbanVisibility(selectedUserIds);
        }

        async function updateKanbanVisibility(selectedUserIds) {
            const userIds = Array.isArray(selectedUserIds) ? selectedUserIds : [selectedUserIds];
            visibleBoards = new Set(userIds);

            // Remove boards that are no longer selected
            const currentBoards = [...kanbanInstances.keys()];
            for (const boardId of currentBoards) {
                if (!userIds.includes(boardId.toString())) {
                    const boardElement = document.getElementById(`board-${boardId}`);
                    if (boardElement) {
                        boardElement.remove();
                        kanbanInstances.delete(boardId);
                        
                        // Clean up TomSelect instance
                        const selector = subordinateSelectors.get(boardId);
                        if (selector) {
                            selector.destroy();
                            subordinateSelectors.delete(boardId);
                        }
                    }
                }
            }

            async function refreshKanbanBoard(userId) {
                const userData = await fetchUserData(userId);
                const kanban = kanbanInstances.get(parseInt(userId));

                if (kanban) {
                    // Clear the board's items
                    kanban.removeBoard(userData.id.toString());
                    kanban.addBoards([{
                        id: userData.id.toString(),
                        title: `Subordinates (${userData.subordinates?.length || 0})`,
                        item: (userData.subordinates || []).map(sub => ({
                            id: sub.id,
                            title: sub.name,
                        }))
                    }]);
                }
            }

            async function updateBoardTitles(userIds) {
                for (const userId of userIds) {
                    const userData = await fetchUserData(userId);
                    const boardElement = document.getElementById(`board-${userId}`);
                    if (boardElement) {
                        const cardHeader = boardElement.querySelector('.card-header h5');
                        if (cardHeader) {
                            cardHeader.textContent = userData.name; // Update user Name
                            const kanban = kanbanInstances.get(parseInt(userId));
                            if (kanban) {
                                kanban.boards.forEach(board => {
                                    board.title = `Subordinates (${userData.subordinates?.length || 0})`;
                                });
                                kanban.refreshBoards();
                            }
                        }
                    }
                }
            }

            // Create or update boards for selected users
            for (const userId of userIds) {
                await createKanbanBoard(userId);
            }

            // Refresh all boards with latest data
            for (const userId of userIds) {
                const userData = await fetchUserData(userId);
                const kanban = kanbanInstances.get(parseInt(userId));
                if (kanban) {
                    // Remove existing board
                    kanban.removeBoard(userData.id.toString());
                    // Add updated board
                    kanban.addBoards([{
                        id: userData.id.toString(),
                        title: `Subordinates (${userData.subordinates?.length || 0})`,
                        item: (userData.subordinates || []).map(sub => ({
                            id: sub.id,
                            title: sub.name,
                        }))
                    }]);
                }
            }

            // Rearrange boards
            userIds.forEach(userId => {
                const boardElement = document.getElementById(`board-${userId}`);
                if (boardElement) {
                    container.appendChild(boardElement);
                }
            });
        }

        // Initial setup
        document.addEventListener('DOMContentLoaded', () => {
            const initialSelection = @json($initialSelection);
            mainSelector.setValue(initialSelection);
        });
    </script>
    @endpush
</x-app-layout>
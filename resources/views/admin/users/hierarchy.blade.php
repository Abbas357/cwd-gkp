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
        .kanban-board {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: .2rem;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .kanban-board .kanban-drag {
            padding: .2rem;
            height:300px;
            overflow-y: auto;
        }
        .kanban-board header {
            padding: .3rem;
            background: #ebecee;
        }
        .kanban-board-header {
            font-size: .7rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .kanban-item {
            cursor: move;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 10px 15px;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
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
        .subordinate-selector {
            margin-top: 10px;
        }
    </style>
    @endpush

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <select id="userSelector" class="form-select" multiple placeholder="Select users to show their teams..."></select>
            </div>
        </div>
        <div id="kanbanContainer"></div>
    </div>

    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        let globalKanban;
        let subordinateSelectors = new Map();
        let mainSelector = null;
        let boardsData = {};

        mainSelector = new TomSelect('#userSelector', {
            valueField: 'id',
            labelField: 'position',
            searchField: ['name', 'email', 'designation', 'position'],
            persist: false,
            maxOptions: null,
            plugins: ['remove_button'],
            onInitialize() {
                this.addOptions(@json($users->toArray()));
            },
            onChange(selected) {
                updateKanbanVisibility(selected);
            }
        });

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

        function initializeGlobalKanban() {
            globalKanban = new jKanban({
                element: '#kanbanContainer',
                gutter: '15px',
                boards: [],
                dragBoards: false,
                itemHandle: '.kanban-item',
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
                dropEl: async function(el, target, source, sibling) {
                    const userId = el.getAttribute('data-eid');
                    const newBossId = target.closest('.kanban-board').getAttribute('data-id');
                    const sourceBossId = source.closest('.kanban-board').getAttribute('data-id');
                    try {
                        await updateUserBoss(userId, newBossId);
                        await refreshKanbanBoard(newBossId);
                        if (sourceBossId !== newBossId) {
                            await refreshKanbanBoard(sourceBossId);
                        }
                        reorderBoards();
                    } catch (error) {
                        console.error('Drag failed:', error);
                        source.appendChild(el);
                    }
                }
            });
        }

        function reorderBoards() {
            requestAnimationFrame(() => {
                const container = document.querySelector('#kanbanContainer');
                const order = mainSelector.getValue(); 
                order.forEach(id => {
                    const board = container.querySelector(`.kanban-board[data-id="${id}"]`);
                    if (board) {
                        container.appendChild(board);
                    }
                });
            });
        }

        async function createOrUpdateBoard(userId) {
            const userData = await fetchUserData(userId);
            boardsData[userId] = userData;

            const boardObj = {
                id: userData.id.toString(),
                title: `${userData.position} (Subordinates: ${userData.subordinates?.length || 0})`,
                item: (userData.subordinates || []).map(sub => ({
                    id: sub.id.toString(),
                    title: sub.position,
                    drag: true,
                    attributes: { 'data-eid': sub.id.toString() }
                }))
            };

            let boardElement = document.querySelector(`.kanban-board[data-id="${userData.id}"]`);
            if (boardElement) {
                globalKanban.removeBoard(userData.id.toString());
            }

            globalKanban.addBoards([boardObj]);

            setTimeout(() => {
                boardElement = document.querySelector(`.kanban-board[data-id="${userData.id}"]`) ||
                               document.querySelector(`.kanban-board[kanban-id="${userData.id}"]`);
                if (boardElement) {
                    boardElement?.setAttribute('data-id', userData.id);
                    let header = boardElement.querySelector('.kanban-board-header');
                    if (!header) {
                        header = document.createElement('div');
                        header.className = 'kanban-board-header';
                        boardElement.prepend(header);
                    }
                    header.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center">
                            <span>${userData.position} (Subordinates: ${userData.subordinates?.length || 0})</span>
                            <i class="bi-x fs-4 p-1 cursor-pointer remove-board" data-id="${userData.id}"></i>
                        </div>
                    `;
                    header.querySelector('.remove-board').addEventListener('click', (e) => {
                        e.preventDefault();
                        removeBoard(userData.id);
                    });
                    if (!boardElement.querySelector('.subordinate-selector')) {
                        const footer = document.createElement('div');
                        footer.className = 'subordinate-selector';
                        footer.innerHTML = `<select class="form-select add-subordinate" placeholder="Add User.."></select>`;
                        boardElement.appendChild(footer);
                        const selectEl = footer.querySelector('select.add-subordinate');
                        const subordinateSelector = new TomSelect(selectEl, {
                            valueField: 'id',
                            labelField: 'position',
                            searchField: ['name', 'email', 'designation', 'position'],
                            persist: false,
                            maxItems: 1,
                            plugins: ['clear_button'],
                            render: {
                                option: function(data, escape) {
                                    return `<div class="py-2 px-3">${escape(data.position)}</div>`;
                                },
                                item: function(data, escape) {
                                    return `<div>${escape(data.position)}</div>`;
                                }
                            },
                            onInitialize: async function() {
                                const url = "{{ route('admin.users.available-subordinates', ':id') }}".replace(':id', userData.id);
                                const response = await fetch(url);
                                const availableUsers = await response.json();
                                this.addOptions(availableUsers);
                                if (this.control) {
                                    this.control.querySelector('.ts-control')?.setAttribute('placeholder', 'Add User...');
                                }
                            },
                            onItemAdd: async (value) => {
                                try {
                                    await updateUserBoss(value, userData.id);
                                    await refreshKanbanBoard(userData.id);
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
                    reorderBoards();
                }
            }, 150);
        }

        async function refreshKanbanBoard(userId) {
            await createOrUpdateBoard(userId);
        }

        function removeBoard(userId) {
            globalKanban.removeBoard(userId.toString());
            if (subordinateSelectors.has(userId)) {
                subordinateSelectors.get(userId).destroy();
                subordinateSelectors.delete(userId);
            }
            const currentValue = mainSelector.getValue();
            const newValue = currentValue.filter(id => id !== userId.toString());
            mainSelector.setValue(newValue, true);
            reorderBoards();
        }

        async function updateKanbanVisibility(selectedUserIds) {
            const userIds = Array.isArray(selectedUserIds) ? selectedUserIds : [selectedUserIds];
            const existingBoards = Array.from(document.querySelectorAll('.kanban-board')).map(el => el.getAttribute('data-id'));
            existingBoards.forEach(id => {
                if (!userIds.includes(id)) {
                    removeBoard(parseInt(id));
                }
            });
            for (const userId of userIds) {
                await createOrUpdateBoard(userId);
            }
            reorderBoards();
        }

        document.addEventListener('DOMContentLoaded', () => {
            initializeGlobalKanban();
            const initialSelection = @json($initialSelection);
            mainSelector.setValue(initialSelection);
        });
    </script>
    @endpush
</x-app-layout>

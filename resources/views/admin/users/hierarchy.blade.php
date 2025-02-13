<x-app-layout title="User Hierarchy">
    @push('style')
    <link href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css" rel="stylesheet">
    @endpush

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <select id="userSelector" multiple placeholder="Select users..."></select>
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
        const maxInitialBoards = 3;

        // Initialize multi-select
        new TomSelect('#userSelector', {
            valueField: 'id',
            labelField: 'name',
            searchField: ['name', 'email'],
            persist: false,
            maxOptions: null,
            plugins: ['remove_button'],
            onInitialize() {
                this.addOptions(@json($users->toArray()))
            },
            onChange(selected) {
                updateKanbanVisibility(selected);
            }
        });

        // Initialize Kanban container
        const container = document.getElementById('kanbanContainer');
        
        function createKanbanBoard(user) {
            const boardId = `board-${user.id}`;
            const boardElement = document.createElement('div');
            boardElement.className = 'col-md-4 kanban-board';
            boardElement.id = boardId;
            boardElement.innerHTML = `
                <div class="card">
                    <div class="card-header">${user.name}</div>
                    <div class="card-body kanban-container"></div>
                </div>
            `;

            container.appendChild(boardElement);
            
            const kanban = new jKanban({
                element: `#${boardId} .kanban-container`,
                boards: [{
                    id: user.id,
                    title: `Subordinates (${user.subordinates.length})`,
                    item: user.subordinates.map(sub => ({
                        id: sub.id,
                        title: sub.name,
                    }))
                }],
                dragEl: (el, source) => {
                    // Handle drag start
                },
                dragendEl: (el) => {
                    // Handle drag end
                },
                dropEl: (el, target, source, sibling) => {
                    const userId = el.dataset.eid;
                    const newBossId = target.parentNode.dataset.board;
                    updateUserBoss(userId, newBossId);
                }
            });

            kanbanInstances.set(user.id, kanban);
            return boardElement;
        }

        async function updateUserBoss(userId, bossId) {
            const url = "{{ route('admin.users.hierarchy', ':id') }}".replace(':id', userId);
            await fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ boss_id: bossId })
            });
        }

        function updateKanbanVisibility(selectedUserIds) {
            // Implementation to show/hide boards
        }

        // Initial setup
        document.addEventListener('DOMContentLoaded', () => {
            const initialSelection = @json($initialSelection);
            document.querySelector('#userSelector').tomselect.setValue(initialSelection);
        });
    </script>
    @endpush
</x-app-layout>
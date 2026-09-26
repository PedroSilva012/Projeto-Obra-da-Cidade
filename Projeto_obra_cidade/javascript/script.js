document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.add('hidden'));
            
            // Add active class to clicked button
            button.classList.add('active');
            
            // Show corresponding pane
            const tabId = button.getAttribute('data-tab') + '-tab';
            document.getElementById(tabId).classList.remove('hidden');
            
            // If not the "all" tab, filter the cards
            if (button.getAttribute('data-tab') !== 'all') {
                const status = button.getAttribute('data-tab').replace('completed', 'concluida').replace('ongoing', 'em andamento').replace('planned', 'planejada');
                filterObrasByStatus(status);
            } else {
                // Show all cards
                document.querySelectorAll('.obra-card').forEach(card => {
                    card.style.display = 'block';
                });
            }
        });
    });
    
    function filterObrasByStatus(status) {
        document.querySelectorAll('.obra-card').forEach(card => {
            if (card.getAttribute('data-status') === status) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    // Count obras by status
    function countObras() {
        const counts = {
            'planejada': 0,
            'em andamento': 0,
            'concluida': 0
        };
        
        document.querySelectorAll('.obra-card').forEach(card => {
            const status = card.getAttribute('data-status');
            counts[status]++;
        });
        
        document.getElementById('planned-count').textContent = counts['planejada'];
        document.getElementById('ongoing-count').textContent = counts['em andamento'];
        document.getElementById('completed-count').textContent = counts['concluida'];
    }
    
    // Initialize counts
    countObras();
});
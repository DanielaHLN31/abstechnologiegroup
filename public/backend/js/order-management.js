// Sample data
let pendingOrders = [
    { id: 1, customer: 'John Doe', address: '123 Main St, City', products: 'Product A, Product B', total: 150 },
    { id: 2, customer: 'Jane Smith', address: '456 Elm St, Town', products: 'Product C', total: 75 },
];

let processingOrders = [
    { id: 3, customer: 'Alice Johnson', products: 'Product D, Product E', total: 200, status: 'En préparation' },
    { id: 4, customer: 'Bob Brown', products: 'Product F', total: 100, status: 'Prêt pour expédition' },
];

let orderHistory = [
    { id: 5, customer: 'Charlie Davis', status: 'Livré', date: '2023-09-15', total: 180 },
    { id: 6, customer: 'Diana Evans', status: 'Annulé', date: '2023-09-10', total: 90 },
];

// Functions
function handlePrintLabel(orderId) {
    console.log(`Printing label for order ${orderId}`);
    // Implement label printing logic here
}

function handleStartProcessing(orderId) {
    console.log(`Starting processing for order ${orderId}`);
    const order = pendingOrders.find(o => o.id === orderId);
    if (order) {
        order.status = 'En préparation';
        processingOrders.push(order);
        pendingOrders = pendingOrders.filter(o => o.id !== orderId);
        updateTables();
    }
}

function handleUpdateStatus(orderId) {
    console.log(`Updating status for order ${orderId}`);
    // Set current order ID for the modal
    document.getElementById('updateStatusModal').dataset.orderId = orderId;
    const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
    modal.show();
}

function saveOrderStatus() {
    const modal = document.getElementById('updateStatusModal');
    const orderId = parseInt(modal.dataset.orderId);
    const newStatus = document.getElementById('orderStatus').value;
    const notes = document.getElementById('statusNotes').value;

    const order = processingOrders.find(o => o.id === orderId);
    if (order) {
        order.status = newStatus;
        order.notes = notes;
        if (newStatus === 'Livré' || newStatus === 'Annulé') {
            order.date = new Date().toISOString().split('T')[0];
            orderHistory.push(order);
            processingOrders = processingOrders.filter(o => o.id !== orderId);
        }
        updateTables();
    }

    bootstrap.Modal.getInstance(modal).hide();
}

function handleTrackOrder(orderId) {
    console.log(`Tracking order ${orderId}`);
    const modal = new bootstrap.Modal(document.getElementById('trackingModal'));
    modal.show();
}

function saveTracking() {
    const trackingNumber = document.getElementById('trackingNumber').value;
    const trackingLink = document.getElementById('trackingLink').value;
    console.log(`Saving tracking info: ${trackingNumber} - ${trackingLink}`);
    // Implement saving logic here
    const modal = bootstrap.Modal.getInstance(document.getElementById('trackingModal'));
    modal.hide();
}

// Update tables
function updateTables() {
    if (document.getElementById('pendingOrdersTableBody')) {
        populatePendingOrders();
    }
    if (document.getElementById('processingOrdersTableBody')) {
        populateProcessingOrders();
    }
    if (document.getElementById('orderHistoryTableBody')) {
        populateOrderHistory();
    }
}

function populatePendingOrders() {
    const tableBody = document.getElementById('pendingOrdersTableBody');
    tableBody.innerHTML = pendingOrders.map(order => `
        <tr>
            <td>${order.id}</td>
            <td>${order.customer}</td>
            <td>${order.address}</td>
            <td>${order.products}</td>
            <td>$${order.total}</td>
            <td>
                <button class="btn btn-outline-primary btn-sm me-2" onclick="handlePrintLabel(${order.id})">
                    <i data-lucide="printer" class="icon"></i> Imprimer Étiquette
                </button>
                <button class="btn btn-outline-success btn-sm" onclick="handleStartProcessing(${order.id})">
                    <i data-lucide="play" class="icon"></i> Commencer traitement
                </button>
            </td>
        </tr>
    `).join('');
    lucide.createIcons();
}

function populateProcessingOrders() {
    const tableBody = document.getElementById('processingOrdersTableBody');
    tableBody.innerHTML = processingOrders.map(order => `
        <tr>
            <td>${order.id}</td>
            <td>${order.customer}</td>
            <td>${order.products}</td>
            <td>$${order.total}</td>
            <td>${order.status}</td>
            <td>
                <button class="btn btn-outline-danger btn-sm me-2" onclick="handleUpdateStatus(${order.id})">
                    <i data-lucide="edit" class="icon"></i> Mettre à jour
                </button>
                <button class="btn btn-outline-info btn-sm" onclick="handleTrackOrder(${order.id})">
                    <i data-lucide="truck" class="icon"></i> Ajouter suivi
                </button>
            </td>
        </tr>
    `).join('');
    lucide.createIcons();
}

function populateOrderHistory() {
    const tableBody = document.getElementById('orderHistoryTableBody');
    tableBody.innerHTML = orderHistory.map(order => `
        <tr>
            <td>${order.id}</td>
            <td>${order.customer}</td>
            <td><span class="badge bg-${order.status === 'Livré' ? 'success' : 'danger'}">${order.status}</span></td>
            <td>${order.date}</td>
            <td>$${order.total}</td>
            <td>
                <button class="btn btn-outline-info btn-sm" onclick="handleTrackOrder(${order.id})">
                    <i data-lucide="eye" class="icon"></i> Voir détails
                </button>
            </td>
        </tr>
    `).join('');
    lucide.createIcons();
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateTables();
});
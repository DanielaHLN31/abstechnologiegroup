<script>
// const CSRF = '{{ csrf_token() }}';
let currentOrderNumber = null;

// ── Actualiser les tableaux ──────────────────────────────────────
function refreshTables() {
    const $btn = document.getElementById('btn-refresh');
    $btn.disabled = true;
    $btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>...';
    setTimeout(() => { window.location.reload(); }, 300);
}

// ── Commencer le traitement (pending → confirmed) ────────────────
function startProcessing(orderNumber) {
    
    Swal.fire({
        title: 'Confirmation',
        text: `Confirmer et commencer le traitement de la commande ${orderNumber} ?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, confirmer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            
            fetch(`/commandes/${orderNumber}/start-processing`, {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': CSRF, 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json' 
                },
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    Swal.fire({
                        title: 'Confirmé !',
                        text: 'La commande a été traitée avec succès',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false,
                        willClose: () => {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire('Erreur', res.message || 'Une erreur est survenue', 'error');
                }
            })
            .catch(() => Swal.fire('Erreur', 'Problème de connexion', 'error'));
        }
    });
}

// ── Ouvrir modal statut ──────────────────────────────────────────
function openStatusModal(orderNumber, currentStatus) {
    currentOrderNumber = orderNumber;
    document.getElementById('modal-order-number').textContent = orderNumber;
    document.getElementById('modal-status').value = currentStatus;
    document.getElementById('modal-notes').value = '';

    // Reset complet du formulaire
    resetRefundSection();
    resetModalWarnings();

    // Si le statut actuel est déjà "refunded", afficher le champ
    if (currentStatus === 'refunded') {
        showRefundSection();
        document.getElementById('modal-refund-warning').classList.remove('d-none');
    }

    if (typeof feather !== 'undefined') feather.replace();
    new bootstrap.Modal(document.getElementById('statusModal')).show();
}

// ── Reset helpers ────────────────────────────────────────────────
function resetRefundSection() {
    const refundInput = document.getElementById('refund-proof');
    if (refundInput) refundInput.value = '';

    const preview = document.getElementById('refund-proof-preview');
    if (preview) {
        preview.classList.add('d-none');
        const img = preview.querySelector('img');
        if (img) img.src = '';
    }

    document.getElementById('refund-proof-container').classList.add('d-none');
}

function resetModalWarnings() {
    document.getElementById('modal-cancel-warning').classList.add('d-none');
    document.getElementById('modal-refund-warning').classList.add('d-none');
}

function showRefundSection() {
    document.getElementById('refund-proof-container').classList.remove('d-none');
}

// ── DOMContentLoaded : tous les listeners ici ────────────────────
document.addEventListener('DOMContentLoaded', function () {

    // ── Listener : changement de statut dans le select ───────────
    document.getElementById('modal-status').addEventListener('change', function () {
        resetModalWarnings();
        resetRefundSection();

        if (this.value === 'cancelled') {
            document.getElementById('modal-cancel-warning').classList.remove('d-none');
        } else if (this.value === 'refunded') {
            document.getElementById('modal-refund-warning').classList.remove('d-none');
            showRefundSection();
        }
    });

    // ── Listener : prévisualisation preuve remboursement ─────────
    document.getElementById('refund-proof').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) {
            document.getElementById('refund-proof-preview').classList.add('d-none');
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            showToast("Format d'image non accepté", 'danger');
            this.value = '';
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            showToast("L'image ne doit pas dépasser 5MB", 'danger');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('refund-proof-preview');
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });

    // ── Listener : prévisualisation preuve paiement ──────────────
    document.getElementById('payment-proof').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) {
            document.getElementById('payment-proof-preview').classList.add('d-none');
            return;
        }
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('payment-proof-preview');
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });

    if (typeof feather !== 'undefined') feather.replace();
});

// ── Sauvegarder le statut ────────────────────────────────────────
function saveStatus() {
    const status     = document.getElementById('modal-status').value;
    const notes      = document.getElementById('modal-notes').value;
    const refundFile = document.getElementById('refund-proof').files[0];

    if (status === 'refunded' && !refundFile) {
        showToast('Veuillez fournir une preuve de remboursement', 'warning');
        return;
    }

    const $btn = document.getElementById('btn-save-status');
    $btn.disabled = true;
    $btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Enregistrement...';

    const formData = new FormData();
    formData.append('status', status);
    formData.append('notes', notes);
    formData.append('_method', 'PATCH');
    if (refundFile) formData.append('refund_proof', refundFile);

    fetch(`/commandes/${currentOrderNumber}/status`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: formData,
    })
    .then(r => r.json())
    .then(res => {
        $btn.disabled = false;
        $btn.innerHTML = '<i data-feather="save" style="width:14px;height:14px;margin-right:4px"></i>Enregistrer';
        if (typeof feather !== 'undefined') feather.replace();

        if (res.success) {
            const badge = document.getElementById(`status-badge-${currentOrderNumber}`);
            if (badge) {
                badge.textContent = res.order.status_label;
                badge.style.background = res.order.status_color + '22';
                badge.style.color      = res.order.status_color;
                badge.style.border     = `1px solid ${res.order.status_color}44`;
            }

            bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
            showToast(status === 'refunded' ? 'Remboursement enregistré !' : 'Statut mis à jour !', 'success');

            if (['delivered', 'cancelled', 'refunded'].includes(status)) {
                setTimeout(() => window.location.reload(), 1500);
            }
        } else {
            showToast(res.message || 'Erreur lors de la mise à jour.', 'danger');
        }
    })
    .catch(err => {
        $btn.disabled = false;
        $btn.innerHTML = '<i data-feather="save" style="width:14px;height:14px;margin-right:4px"></i>Enregistrer';
        showToast('Erreur réseau : ' + err.message, 'danger');
    });
}

// ── Paiement ─────────────────────────────────────────────────────
function markPaid(orderNumber) {
    currentOrderNumber = orderNumber;
    document.getElementById('payment-order-number').textContent = orderNumber;
    document.getElementById('payment-reference').value = '';

    const fileInput = document.getElementById('payment-proof');
    if (fileInput) fileInput.value = '';
    const preview = document.getElementById('payment-proof-preview');
    if (preview) {
        preview.classList.add('d-none');
        preview.querySelector('img').src = '';
    }

    if (typeof feather !== 'undefined') feather.replace();
    new bootstrap.Modal(document.getElementById('paymentModal')).show();
}

function confirmMarkPaid() {
    const ref  = document.getElementById('payment-reference').value;
    const file = document.getElementById('payment-proof').files[0];

    if (file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) { showToast("Format d'image non accepté", 'danger'); return; }
        if (file.size > 5 * 1024 * 1024)       { showToast("L'image ne doit pas dépasser 5MB", 'danger'); return; }
    }

    const formData = new FormData();
    formData.append('payment_reference', ref);
    if (file) formData.append('payment_proof', file);

    const $btn = document.getElementById('btn-confirm-payment');
    $btn.disabled = true;
    $btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Traitement...';

    fetch(`/commandes/${currentOrderNumber}/mark-paid`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: formData,
    })
    .then(r => r.json())
    .then(res => {
        $btn.disabled = false;
        $btn.innerHTML = '<i data-feather="check" style="width:14px;height:14px;margin-right:4px"></i>Confirmer le paiement';

        bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
        if (res.success) {
            showToast('Commande marquée comme payée !', 'success');
            setTimeout(() => window.location.reload(), 800);
        } else {
            showToast(res.message || 'Erreur lors du paiement', 'danger');
        }
    })
    .catch(() => {
        $btn.disabled = false;
        $btn.innerHTML = '<i data-feather="check" style="width:14px;height:14px;margin-right:4px"></i>Confirmer le paiement';
        showToast('Erreur réseau', 'danger');
    });
}

// ── Toast ────────────────────────────────────────────────────────
function showToast(message, type = 'success') {
    const colors = { success: '#28a745', danger: '#e65540', info: '#17a2b8', warning: '#ffc107' };
    const toast  = document.createElement('div');
    toast.style.cssText = `
        position:fixed;bottom:20px;right:20px;z-index:9999;
        background:#333;color:#fff;padding:12px 20px;
        border-radius:8px;font-size:14px;font-weight:500;
        border-left:4px solid ${colors[type] || colors.success};
        box-shadow:0 4px 16px rgba(0,0,0,.2);
        animation:slideIn .3s ease;max-width:320px;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity    = '0';
        toast.style.transition = 'opacity .3s';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
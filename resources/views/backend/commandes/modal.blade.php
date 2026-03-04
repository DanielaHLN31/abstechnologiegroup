{{-- ================================================================
     MODAL CHANGEMENT DE STATUT
     ================================================================ --}}
<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i data-feather="edit-2" style="width:18px;height:18px;margin-right:8px"></i>
                    Changer le statut
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">N° Commande</label>
                    <div id="modal-order-number" class="text-primary fw-bold fs-6"></div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nouveau statut <span class="text-danger">*</span></label>
                    <select class="form-select" id="modal-status">
                        <option value="pending">En attente</option>
                        <option value="confirmed">Confirmée</option>
                        <option value="processing">En traitement</option>
                        <option value="shipped">Expédiée</option>
                        <option value="delivered">Livrée</option>
                        <option value="cancelled">Annulée</option>
                        <option value="refunded">Remboursée</option>
                    </select>
                </div>
                
                {{-- Champ de preuve de remboursement (caché par défaut) --}}
                <div class="mb-3 d-none" id="refund-proof-container">
                    <label class="form-label fw-semibold">
                        Preuve de remboursement <span class="text-danger">*</span>
                    </label>
                    <div class="border rounded p-3 bg-light">
                        <input type="file" class="form-control" id="refund-proof" name="refund_proof" 
                               accept="image/jpeg,image/png,image/jpg,image/gif">
                        <small class="text-muted d-block mt-2">
                            <i data-feather="info" style="width:12px;height:12px"></i>
                            Formats acceptés : JPEG, PNG, JPG, GIF (Max: 5MB)
                        </small>
                    </div>
                    
                    {{-- Preview de l'image --}}
                    <div id="refund-proof-preview" class="mt-2 text-center d-none">
                        <p class="small text-muted mb-1">Aperçu :</p>
                        <img src="" alt="Aperçu" class="img-fluid rounded" style="max-height: 150px; border: 1px solid #ddd;">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Notes (optionnel)</label>
                    <textarea class="form-control" id="modal-notes" rows="3"
                              placeholder="Informations supplémentaires..."></textarea>
                </div>
                
                <div id="modal-cancel-warning" class="alert alert-danger d-none" role="alert">
                    ⚠️ Annuler cette commande remettra le stock des produits en place. Cette action est irréversible.
                </div>
                
                <div id="modal-refund-warning" class="alert alert-warning d-none" role="alert">
                    ⚠️ Vous êtes sur le point de marquer cette commande comme remboursée. 
                    Veuillez fournir une preuve de la transaction de remboursement.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="btn-save-status" onclick="saveStatus()">
                    <i data-feather="save" style="width:14px;height:14px;margin-right:4px"></i>
                    Enregistrer
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL PAIEMENT
     ================================================================ --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i data-feather="dollar-sign" style="width:18px;height:18px;margin-right:8px"></i>
                    Confirmer le paiement
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Commande : <span id="payment-order-number" class="fw-bold text-primary"></span></p>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Référence de transaction</label>
                    <input type="text" class="form-control" id="payment-reference" name="payment_reference"
                           placeholder="ex: MTN-123456789">
                    <small class="text-muted">Optionnel, mais recommandé</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Capture d'écran du paiement</label>
                    <div class="border rounded p-3 bg-light">
                        <input type="file" class="form-control" id="payment-proof" name="payment_proof" 
                               accept="image/jpeg,image/png,image/jpg,image/gif">
                        <small class="text-muted d-block mt-2">
                            <i data-feather="info" style="width:12px;height:12px"></i>
                            Formats acceptés : JPEG, PNG, JPG, GIF, PDF (Max: 5MB)
                        </small>
                    </div>
                    
                    {{-- Preview de l'image --}}
                    <div id="payment-proof-preview" class="mt-2 text-center d-none">
                        <p class="small text-muted mb-1">Aperçu :</p>
                        <img src="" alt="Aperçu" class="img-fluid rounded" style="max-height: 150px; border: 1px solid #ddd;">
                    </div>
                </div>
                
                <div class="alert alert-info mb-0">
                    <i data-feather="info" style="width:14px;height:14px;margin-right:4px"></i>
                    Cette action marquera la commande comme payée.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" onclick="confirmMarkPaid()" id="btn-confirm-payment">
                    <i data-feather="check" style="width:14px;height:14px;margin-right:4px"></i>
                    Confirmer le paiement
                </button>
            </div>
        </div>
    </div>
</div>
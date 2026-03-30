<script>
$(document).ready(function() {

    $(document).on('click', '.details-product-btn', function(e) {
        e.preventDefault();
        let productId = $(this).data('product-details-id');

        Swal.fire({
            title: 'Chargement...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            background: '#0f1117',
            color: '#fff',
            willOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: `/products/${productId}`,
            method: 'GET',
            success: function(response) {
                const product = response.product || response;
                if (!product) {
                    Swal.fire({ icon: 'error', title: 'Produit non trouvé',
                        customClass: { confirmButton: 'btn btn-primary' }, buttonsStyling: false });
                    return;
                }

                const createdAt = product.created_at
                    ? new Date(product.created_at).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })
                    : '—';

                // ── Images ──────────────────────────────────────────
                let imagesHtml = '';
                if (product.images && product.images.length > 0) {
                    const main = product.images.find(i => i.is_primary) || product.images[0];
                    const thumbs = product.images.map((img, idx) => `
                        <div class="pd-thumb ${img.is_primary ? 'pd-thumb--active' : ''}"
                             onclick="document.getElementById('pd-main-img').src='/storage/${img.image_path}';
                                      document.querySelectorAll('.pd-thumb').forEach(t=>t.classList.remove('pd-thumb--active'));
                                      this.classList.add('pd-thumb--active')">
                            <img src="/storage/${img.image_path}" alt="">
                        </div>`).join('');
                    imagesHtml = `
                        <div class="pd-gallery">
                            <div class="pd-main-image">
                                <img id="pd-main-img" src="/storage/${main.image_path}" alt="${product.name}">
                                <div class="pd-img-count">${product.images.length} photo${product.images.length > 1 ? 's' : ''}</div>
                            </div>
                            <div class="pd-thumbs">${thumbs}</div>
                        </div>`;
                } else {
                    imagesHtml = `
                        <div class="pd-gallery">
                            <div class="pd-main-image pd-main-image--empty">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                                    <path d="M21 15l-5-5L5 21"/>
                                </svg>
                                <span>Aucune image</span>
                            </div>
                        </div>`;
                }

                // ── Statut & Stock ───────────────────────────────────
                const statusMap = {
                    published: { cls: 'pd-badge--green',  label: 'Publié'    },
                    draft:     { cls: 'pd-badge--amber',  label: 'Brouillon' },
                    archived:  { cls: 'pd-badge--gray',   label: 'Archivé'   },
                };
                const s = statusMap[product.status] || statusMap.draft;
                const statusBadge = `<span class="pd-badge ${s.cls}">${s.label}</span>`;

                let stockBadge;
                if (product.stock_quantity <= 0) {
                    stockBadge = `<span class="pd-badge pd-badge--red">Rupture de stock</span>`;
                } else if (product.stock_quantity <= product.low_stock_threshold) {
                    stockBadge = `<span class="pd-badge pd-badge--amber">Stock bas — ${product.stock_quantity} u.</span>`;
                } else {
                    stockBadge = `<span class="pd-badge pd-badge--green">${product.stock_quantity} en stock</span>`;
                }

                // ── Prix ─────────────────────────────────────────────
                // let priceHtml = `<span class="pd-price">${parseFloat(product.price).toLocaleString('fr-FR')} <small>FCFA</small></span>`;
                // if (product.compare_price) {
                //     const pct = Math.round((1 - product.price / product.compare_price) * 100);
                //     priceHtml += `
                //         <span class="pd-price-old">${parseFloat(product.compare_price).toLocaleString('fr-FR')} FCFA</span>
                //         <span class="pd-discount">−${pct}%</span>`;
                // }

                // ── Couleurs ─────────────────────────────────────────
                let colorsHtml = '';
                if (product.colors && product.colors.length > 0) {
                    const dots = product.colors.map(c => `
                        <div class="pd-color-chip" title="${c.name} — ${c.pivot?.stock_quantity || 0} en stock">
                            <span class="pd-color-dot" style="background:${c.code}"></span>
                            <span class="pd-color-label">${c.name}</span>
                            <span class="pd-color-stock">${c.pivot?.stock_quantity || 0}</span>
                        </div>`).join('');
                    colorsHtml = `
                        <div class="pd-section">
                            <div class="pd-section-title">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                Couleurs disponibles
                            </div>
                            <div class="pd-colors">${dots}</div>
                        </div>`;
                }

                // ── Spécifications ───────────────────────────────────
                let specsHtml = '';
                if (product.specifications && product.specifications.length > 0) {
                    const rows = product.specifications.map(sp => `
                        <div class="pd-spec-row">
                            <span class="pd-spec-key">${sp.name}</span>
                            <span class="pd-spec-val">${sp.value || '—'}</span>
                        </div>`).join('');
                    specsHtml = `
                        <div class="pd-section">
                            <div class="pd-section-title">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                                Spécifications
                            </div>
                            <div class="pd-specs">${rows}</div>
                        </div>`;
                }

                // ── Assemblage final ─────────────────────────────────
                const content = `
                <div class="pd-root">

                    <div class="pd-left">
                        ${imagesHtml}

                        <div class="pd-meta-row">
                            <span class="pd-meta-label">Ajouté le</span>
                            <span class="pd-meta-val">${createdAt}</span>
                        </div>
                        <div class="pd-meta-row">
                            <span class="pd-meta-label">Catégorie</span>
                            <span class="pd-meta-val">${product.category?.name || '—'}</span>
                        </div>
                        <div class="pd-meta-row">
                            <span class="pd-meta-label">Marque</span>
                            <span class="pd-meta-val">${product.brand?.name || '—'}</span>
                        </div>
                        <div class="pd-meta-row">
                            <span class="pd-meta-label">Seuil stock bas</span>
                            <span class="pd-meta-val">${product.low_stock_threshold} unités</span>
                        </div>
                    </div>

                    <div class="pd-right">
                        <div class="pd-header">
                            <div class="pd-badges">${statusBadge}${stockBadge}${product.is_featured ? '<span class="pd-badge pd-badge--purple">⭐ Vedette</span>' : ''}</div>
                            <h2 class="pd-title">${product.name}</h2>
                            <div class="pd-price-row">${priceHtml}</div>
                        </div>

                        <div class="pd-divider"></div>

                        <div class="pd-section">
                            <div class="pd-section-title">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                Description
                            </div>
                            <div class="pd-description">${product.description || '<em>Aucune description</em>'}</div>
                        </div>

                        ${colorsHtml}
                        ${specsHtml}

                        ${product.meta_title || product.meta_description ? `
                        <div class="pd-section pd-seo">
                            <div class="pd-section-title">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                                SEO
                            </div>
                            ${product.meta_title ? `<div class="pd-seo-row"><b>Titre :</b> ${product.meta_title}</div>` : ''}
                            ${product.meta_description ? `<div class="pd-seo-row"><b>Description :</b> ${product.meta_description}</div>` : ''}
                        </div>` : ''}
                    </div>

                </div>`;

                Swal.close();
                Swal.fire({
                    html: content,
                    width: '1200px',
                    padding: 0,
                    background: 'transparent',
                    showConfirmButton: false,
                    showCloseButton: true,
                    closeButtonHtml: '<i class="ti ti-x" style="font-size:18px"></i>',
                    customClass: {
                        popup:       'pd-swal-popup',
                        closeButton: 'pd-swal-close',
                    }
                });
            },
            error: function(xhr) {
                Swal.close();
                const msg = xhr.responseJSON?.message || 'Impossible de charger les détails.';
                Swal.fire({ icon: 'error', title: 'Erreur', text: msg,
                    customClass: { confirmButton: 'btn btn-primary' }, buttonsStyling: false });
            }
        });
    });
});
</script>

<style>
/* ── Popup SweetAlert ───────────────────────────────────────────── */
.pd-swal-popup {
    border-radius: 20px !important;
    overflow: hidden !important;
    box-shadow: 0 32px 80px rgba(0,0,0,.5) !important;
    padding: 0 !important;
}
.pd-swal-close {
    color: #0066CC !important;
    top: 14px !important;
    right: 14px !important;
    width: 32px !important;
    height: 32px !important;
    background: rgba(255, 255, 255, 0.986) !important;
    border-radius: 20% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: background .2s !important;
    z-index: 10 !important;
}
.pd-swal-close:hover { background: rgba(255,255,255,.18) !important; color: #fff !important; }

/* ── Layout principal ───────────────────────────────────────────── */
.pd-root {
    display: flex;
    min-height: 520px;
    font-family: 'DM Sans', system-ui, sans-serif;
    color: #e2e8f0;
    background: #fbfbfc;
    border-radius: 20px;
    overflow: hidden;
}

/* ── Colonne gauche ─────────────────────────────────────────────── */
.pd-left {
    width: 450px;
    flex-shrink: 0;
    background: #eef3ff;
    border-right: 1px solid rgba(255,255,255,.06);
    padding: 24px 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* ── Galerie ────────────────────────────────────────────────────── */
.pd-gallery { display: flex; flex-direction: column; gap: 10px; }

.pd-main-image {
    position: relative;
    background: #1e213038;
    border-radius: 14px;
    overflow: hidden;
    height: 350px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pd-main-image img {
    width: 100%; height: 100%;
    object-fit: contain;
    transition: transform .4s ease;
}
.pd-main-image:hover img { transform: scale(1.04); }
.pd-main-image--empty {
    flex-direction: column;
    gap: 10px;
    color: #4b5563;
    font-size: 15px;
}
.pd-img-count {
    position: absolute;
    bottom: 10px; right: 10px;
    background: rgba(0,0,0,.6);
    color: #e2e8f0;
    font-size: 13px;
    padding: 3px 8px;
    border-radius: 20px;
    backdrop-filter: blur(4px);
}

.pd-thumbs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.pd-thumb {
    width: 52px; height: 52px;
    border-radius: 5px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid #cccfd3;
    transition: border-color .2s, transform .2s;
    /* background: #1e2130; */
}
.pd-thumb img { width: 100%; height: 100%; object-fit: cover; }
.pd-thumb:hover { transform: scale(1.05); border-color: rgba(105,108,255,.5); }
.pd-thumb--active { border-color: #0066CC !important; }

/* ── Méta-infos gauche ──────────────────────────────────────────── */
.pd-meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid rgba(255,255,255,.05);
    font-size: 15px;
}
.pd-meta-row:last-child { border-bottom: none; }
.pd-meta-label { color: #6b7280; }
.pd-meta-val { color: #0066CC; font-weight: 500; text-align: right; max-width: 60%; }

/* ── Colonne droite ─────────────────────────────────────────────── */
.pd-right {
    flex: 1;
    padding: 28px 30px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 20px;
    scrollbar-width: thin;
    scrollbar-color: #2d3148 transparent;
}
.pd-right::-webkit-scrollbar { width: 5px; }
.pd-right::-webkit-scrollbar-thumb { background: #2d3148; border-radius: 99px; }

/* ── Header ─────────────────────────────────────────────────────── */
.pd-header { display: flex; flex-direction: column; gap: 10px; }
.pd-badges { display: flex; gap: 6px; flex-wrap: wrap; }
.pd-title {
    font-size: 24px;
    font-weight: 700;
    color: #0066CC;
    line-height: 1.25;
    margin: 0;
    letter-spacing: -.3px;
}
.pd-price-row { display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap; }
.pd-price { font-size: 28px; font-weight: 700; color: #0066CC; }
.pd-price small { font-size: 15px; font-weight: 400; color: #9ca3af; }
.pd-price-old { font-size: 15px; color: #6b7280; text-decoration: line-through; }
.pd-discount {
    font-size: 15px; font-weight: 700;
    background: rgba(34,197,94,.15);
    color: #4ade80;
    padding: 2px 8px;
    border-radius: 99px;
}

/* ── Badges ─────────────────────────────────────────────────────── */
.pd-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 11px;
    border-radius: 99px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: .02em;
}
.pd-badge--green  { background: rgba(34,197,94,.15);  color: #4ade80; }
.pd-badge--amber  { background: rgba(251,191,36,.15); color: #fbbf24; }
.pd-badge--red    { background: rgba(239,68,68,.15);  color: #f87171; }
.pd-badge--gray   { background: rgba(156,163,175,.15);color: #9ca3af; }
.pd-badge--purple { background: rgba(105,108,255,.15);color: #818cf8; }

/* ── Divider ────────────────────────────────────────────────────── */
.pd-divider { height: 1px; background: rgba(255,255,255,.07); }

/* ── Section générique ──────────────────────────────────────────── */
.pd-section { display: flex; flex-direction: column; gap: 12px; }
.pd-section-title {
    display: flex; align-items: center; gap: 7px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #4b5563;
}

/* ── Description ────────────────────────────────────────────────── */
.pd-description {
    font-size: 15px;
    line-height: 1.75;
    color: #0c0c0c;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.06);
    border-radius: 10px;
    padding: 14px 16px;
    max-height: 140px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #2d3148 transparent;
}
.pd-description::-webkit-scrollbar { width: 4px; }
.pd-description::-webkit-scrollbar-thumb { background: #2d3148; border-radius: 99px; }

/* ── Couleurs ───────────────────────────────────────────────────── */
.pd-colors { display: flex; flex-wrap: wrap; gap: 8px; }
.pd-color-chip {
    display: flex; align-items: center; gap: 8px;
    padding: 6px 12px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 99px;
    font-size: 15px;
    cursor: default;
    transition: background .2s, border-color .2s;
}
.pd-color-chip:hover { background: rgba(255,255,255,.08); border-color: rgba(255,255,255,.16); }
.pd-color-dot { width: 14px; height: 14px; border-radius: 50%; border: 2px solid rgba(255,255,255,.2); flex-shrink: 0; }
.pd-color-label { color: #151616; }
.pd-color-stock {
    background: rgba(255,255,255,.1);
    color: #9ca3af;
    font-size: 13px;
    padding: 1px 6px;
    border-radius: 99px;
    min-width: 20px;
    text-align: center;
}

/* ── Spécifications ─────────────────────────────────────────────── */
.pd-specs {
    display: flex;
    flex-direction: column;
    gap: 2px;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid rgba(61, 117, 246, 0.601);
}
.pd-spec-row {
    display: flex;
    align-items: center;
    padding: 10px 14px;
    font-size: 15px;
    transition: background .15s;
    justify-content: space-between;
}
.pd-spec-row:nth-child(odd) { background: rgba(21, 91, 231, 0.03); }
.pd-spec-row:nth-child(even) { background: transparent; }
.pd-spec-row:hover { background: rgba(105,108,255,.07); }
.pd-spec-key { color: #4b5058; width: 40%; flex-shrink: 0; }
.pd-spec-val { color: #0066CC; font-weight: 500; }

/* ── SEO ────────────────────────────────────────────────────────── */
.pd-seo-row {
    font-size: 15px;
    color: #9ca3af;
    line-height: 1.6;
    padding: 3px 0;
}
.pd-seo-row b { color: #6b7280; }

/* ── Responsive ─────────────────────────────────────────────────── */
@media (max-width: 640px) {
    .pd-root { flex-direction: column; }
    .pd-left { width: 100%; border-right: none; border-bottom: 1px solid rgba(255,255,255,.06); }
}
</style>
@php
    use App\Models\Personnel;
    use App\Models\User;
    $user = Auth::user();
    $personnelId = auth()->user()->id;
    $personnel = Personnel::where('id', $personnelId)->first();
@endphp

<nav
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <ul class="navbar-nav flex-row align-items-center ms-auto">

            {{-- ── Style Switcher ─────────────────────────────────────────── --}}
            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="ti ti-md"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                            <span class="align-middle"><i class="ti ti-sun me-2"></i>Light</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                            <span class="align-middle"><i class="ti ti-moon me-2"></i>Dark</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                            <span class="align-middle"><i class="ti ti-device-desktop me-2"></i>System</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ── Notifications ───────────────────────────────────────────── --}}
            @can('view notifications')
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                <a
                    class="nav-link dropdown-toggle hide-arrow position-relative"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false"
                    id="notif-toggle"
                    onclick="loadNotifications()">
                    <i class="ti ti-bell ti-md"></i>
                    <span class="badge bg-danger rounded-pill badge-notifications d-none" id="notif-badge"></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end py-0" style="min-width: 360px; max-width: 420px;">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3 px-3">
                            <h5 class="text-body mb-0 me-auto fw-semibold">
                                Notifications
                                <span class="badge bg-danger ms-1 fs-tiny d-none" id="notif-count-badge"></span>
                            </h5>
                            @can('mark notifications read')
                            <button
                                type="button"
                                class="btn btn-sm btn-outline-secondary py-0 px-2"
                                id="btn-mark-all-read"
                                onclick="markAllRead()"
                                title="Tout marquer comme lu">
                                <i class="ti ti-checks ti-xs me-1"></i>Tout lire
                            </button>
                            @endcan
                        </div>
                    </li>

                    <li class="dropdown-notifications-list" style="max-height: 420px; overflow-y: auto;">
                        <div id="notif-loading" class="text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            Chargement…
                        </div>
                        <ul class="list-group list-group-flush" id="notif-list"></ul>
                        <div id="notif-empty" class="text-center py-5 text-muted d-none">
                            <i class="ti ti-bell-off ti-lg mb-2 d-block"></i>
                            Aucune nouvelle notification
                        </div>
                    </li>

                    <li class="dropdown-menu-footer border-top">
                        @can('view orders')
                        <a href="{{ route('commandes.index') }}"
                           class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
                            <i class="ti ti-external-link me-1"></i>
                            Voir toutes les commandes
                        </a>
                        @endcan
                    </li>
                </ul>
            </li>
            @endcan
            {{-- /Notifications ─────────────────────────────────────────────── --}}

            {{-- ── Profil utilisateur ──────────────────────────────────────── --}}
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ (!empty($personnel->photo_profil)) ? url('upload/user_images/'.$personnel->photo_profil) : url('upload/profil.png') }}"
                            alt="Photo de profil"
                            class="h-auto rounded-circle"
                            style="max-width: 2.375rem; max-height: 2.375rem; object-fit:cover"/>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ (!empty($personnel->photo_profil)) ? url('upload/user_images/'.$personnel->photo_profil) : url('upload/profil.png') }}"
                                            alt="Photo de profil"
                                            class="h-auto rounded-circle"
                                            style="max-width: 2.375rem; max-height: 2.375rem; object-fit:cover"/>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-medium d-block">{{ $user->name }}</span>
                                    <small class="text-muted">{{ $user->role->name }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li><div class="dropdown-divider"></div></li>

                    {{-- @can('view profile') --}}
                    <li>
                        <a class="dropdown-item" href="{{ route('parametre') }}">
                            <i class="ti ti-user-check me-2 ti-sm"></i>
                            <span class="align-middle">Mon Profil</span>
                        </a>
                    </li>
                    {{-- @endcan --}}

                    <li><div class="dropdown-divider"></div></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('auth.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout me-2 ti-sm"></i>
                            <span class="align-middle">Déconnexion</span>
                        </a>
                        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            {{-- /Profil ────────────────────────────────────────────────────── --}}

        </ul>
    </div>
</nav>

{{-- ══════════════════════════════════════════════════════════════
     STYLES
══════════════════════════════════════════════════════════════ --}}
<style>
    /* Badge cloche */
    #notif-badge {
        position: absolute;
        top: 2px;
        right: 2px;
        font-size: 0.65rem;
        min-width: 18px;
        height: 18px;
        line-height: 18px;
        padding: 0 4px;
        animation: pulse-badge 1.5s infinite;
    }

    @keyframes pulse-badge {
        0%, 100% { transform: scale(1);   box-shadow: 0 0 0 rgba(220,53,69,.7); }
        50%       { transform: scale(1.2); box-shadow: 0 0 8px rgba(255,0,0,.8); }
    }

    /* Items de notification */
    .notif-item {
        border-left: 3px solid transparent;
        transition: background .15s;
        cursor: pointer;
    }
    .notif-item:hover              { background: rgba(0,0,0,.04); }
    .notif-item.color-primary      { border-left-color: #696cff; }
    .notif-item.color-info         { border-left-color: #03c3ec; }
    .notif-item.color-warning      { border-left-color: #ffab00; }
    .notif-item.color-danger       { border-left-color: #ff3e1d; }
    .notif-item.color-success      { border-left-color: #71dd37; }

    .notif-icon-wrap {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .notif-icon-wrap.bg-label-primary { background: rgba(105,108,255,.16); color: #696cff; }
    .notif-icon-wrap.bg-label-info    { background: rgba(3,195,236,.16);   color: #03c3ec; }
    .notif-icon-wrap.bg-label-warning { background: rgba(255,171,0,.16);   color: #ffab00; }
    .notif-icon-wrap.bg-label-danger  { background: rgba(255,62,29,.16);   color: #ff3e1d; }
    .notif-icon-wrap.bg-label-success { background: rgba(113,221,55,.16);  color: #71dd37; }

    .notif-message {
        font-size: .8rem;
        line-height: 1.4;
        color: #6c757d;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .badge-notifications { display: none; }
    .reminder-badge { font-size: .65rem; }
</style>

{{-- ══════════════════════════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════════════════════════ --}}
<script>
    // ─── Config ────────────────────────────────────────────────────────────────
    const NOTIF_API      = '{{ route("notifications.index") }}';
    const NOTIF_COUNT_API= '{{ route("notifications.count") }}';
    const NOTIF_READ_ALL = '{{ route("notifications.read-all") }}';
    const NOTIF_READ_ONE = (id) => `/notifications/${id}/read`; // adapte si ton prefix diffère
    const CSRF           = '{{ csrf_token() }}';

    // Polling : vérification du badge toutes les 60 secondes
    let pollingInterval = null;

    // ─── Polling du badge ───────────────────────────────────────────────────────
    function startPolling() {
        updateBadge(); // appel immédiat
        pollingInterval = setInterval(updateBadge, 60_000); // toutes les 60s
    }

    async function updateBadge() {
        try {
            const res  = await fetch(NOTIF_COUNT_API, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            setBadge(data.count);
        } catch (e) {
            console.warn('Polling notifications échoué', e);
        }
    }

    function setBadge(count) {
        const badge      = document.getElementById('notif-badge');
        const countBadge = document.getElementById('notif-count-badge');
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.classList.remove('d-none');
            countBadge.textContent = count;
            countBadge.classList.remove('d-none');
        } else {
            badge.classList.add('d-none');
            countBadge.classList.add('d-none');
        }
    }

    // ─── Chargement des notifications ───────────────────────────────────────────
    async function loadNotifications() {
        const list    = document.getElementById('notif-list');
        const loading = document.getElementById('notif-loading');
        const empty   = document.getElementById('notif-empty');

        list.innerHTML = '';
        loading.classList.remove('d-none');
        empty.classList.add('d-none');

        try {
            const res  = await fetch(NOTIF_API, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();

            loading.classList.add('d-none');
            setBadge(data.count);

            if (!data.notifications || data.notifications.length === 0) {
                empty.classList.remove('d-none');
                return;
            }

            data.notifications.forEach(n => {
                list.insertAdjacentHTML('beforeend', renderNotification(n));
            });

        } catch (e) {
            loading.classList.add('d-none');
            list.innerHTML = `<li class="list-group-item text-center text-danger py-3">
                <i class="ti ti-wifi-off me-1"></i>Erreur de chargement
            </li>`;
        }
    }

    // ─── Rendu HTML d'une notification ─────────────────────────────────────────
    function renderNotification(n) {
        const reminderBadge = n.reminder_count > 0
            ? `<span class="badge bg-label-warning reminder-badge ms-1">Rappel ×${n.reminder_count}</span>`
            : '';

        return `
        <li class="list-group-item list-group-item-action notif-item color-${n.color} px-3 py-2"
            onclick="handleNotifClick(${n.id}, '${n.url}')">
            <div class="d-flex align-items-start gap-2">
                <div class="notif-icon-wrap bg-label-${n.color}">
                    <i class="ti ${n.icon} ti-sm"></i>
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-semibold text-body" style="font-size:.82rem;">
                            ${n.title} ${reminderBadge}
                        </span>
                        <small class="text-muted text-nowrap ms-2">${n.time_ago}</small>
                    </div>
                    <p class="notif-message mb-0">${n.message}</p>
                </div>
            </div>
        </li>`;
    }

    // ─── Clic sur une notification ─────────────────────────────────────────────
    async function handleNotifClick(id, url) {
        // Marquer comme lue en arrière-plan
        try {
            await fetch(NOTIF_READ_ONE(id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });
        } catch (e) { /* silencieux */ }

        // Rediriger
        if (url && url !== '#') {
            window.location.href = url;
        } else {
            // Juste retirer l'item de la liste
            updateBadge();
            loadNotifications();
        }
    }

    // ─── Tout marquer comme lu ──────────────────────────────────────────────────
    async function markAllRead() {
        try {
            await fetch(NOTIF_READ_ALL, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });
            setBadge(0);
            document.getElementById('notif-list').innerHTML = '';
            document.getElementById('notif-empty').classList.remove('d-none');
        } catch (e) {
            console.error('Erreur markAllRead', e);
        }
    }

    // ─── Démarrage ─────────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        startPolling();
    });
</script>

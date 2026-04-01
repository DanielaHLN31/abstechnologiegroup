<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CommandController extends Controller
{

    public function dashboardVendors()
    {


        if (request('debug') == 1) {

            $debug = [];

            // ── 1. Toutes les commandes ────────────────────────────────────────────
            $allOrders = \App\Models\Order::select('id','status','payment_status','payment_method','total','created_at')->get();
            $debug['total_orders'] = $allOrders->count();
            $debug['orders'] = $allOrders->map(fn($o) => [
                'id'             => $o->id,
                'status'         => $o->status,
                'payment_status' => $o->payment_status,
                'payment_method' => $o->payment_method,
                'total'          => $o->total,
                'created_at'     => $o->created_at?->format('Y-m-d H:i'),
            ]);

            // ── 2. Revenus 12 mois (commandes payées uniquement) ──────────────────
            $paidOrders = \App\Models\Order::where('payment_status', 'paid')->get();
            $debug['paid_orders_count']  = $paidOrders->count();
            $debug['paid_orders_total']  = $paidOrders->sum('total');

            // ── 3. Ce que voit le graphique revenue ───────────────────────────────
            $revenueByMonth = \App\Models\Order::where('payment_status', 'paid')
                ->where('created_at', '>=', now()->subMonths(12)->startOfMonth())
                ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as revenue')
                ->groupByRaw('YEAR(created_at), MONTH(created_at)')
                ->orderByRaw('YEAR(created_at), MONTH(created_at)')
                ->get();
            $debug['revenue_by_month'] = $revenueByMonth;

            // ── 4. Distribution des statuts ───────────────────────────────────────
            $statusDist = \App\Models\Order::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status');
            $debug['status_distribution'] = $statusDist;

            // ── 5. Méthodes de paiement ───────────────────────────────────────────
            $paymentMethods = \App\Models\Order::selectRaw('payment_method, COUNT(*) as count')
                ->groupBy('payment_method')
                ->pluck('count', 'payment_method');
            $debug['payment_methods'] = $paymentMethods;

            // ── 6. Commandes cette semaine ────────────────────────────────────────
            $thisWeek = \App\Models\Order::where('created_at', '>=', now()->startOfWeek())->get();
            $debug['this_week_orders'] = $thisWeek->count();
            $debug['this_week_details'] = $thisWeek->map(fn($o) => [
                'id'         => $o->id,
                'total'      => $o->total,
                'created_at' => $o->created_at?->format('Y-m-d H:i'),
            ]);

            // ── 7. Valeurs réelles du champ payment_status ────────────────────────
            $debug['distinct_payment_status'] = \App\Models\Order::distinct()->pluck('payment_status');
            $debug['distinct_status']         = \App\Models\Order::distinct()->pluck('status');
            $debug['distinct_payment_method'] = \App\Models\Order::distinct()->pluck('payment_method');

            dd($debug);
        }
        $now   = Carbon::now();
        $today = Carbon::today();

        // ── Période courante vs période précédente ────────────────────────
        $startThisWeek = $now->copy()->startOfWeek();
        $startLastWeek = $now->copy()->subWeek()->startOfWeek();
        $endLastWeek   = $now->copy()->subWeek()->endOfWeek();

        $startThisMonth = $now->copy()->startOfMonth();
        $startLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endLastMonth   = $now->copy()->subMonth()->endOfMonth();

        // ════════════════════════════════════════════════════════════════
        // 1. CARTES KPI DU HAUT
        // ════════════════════════════════════════════════════════════════

        // Chiffre d'affaires ce mois-ci
        $revThisMonth = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startThisMonth, $now])
            ->sum('total');

        $revLastMonth = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->sum('total');

        $revGrowth = $revLastMonth > 0
            ? round((($revThisMonth - $revLastMonth) / $revLastMonth) * 100, 1)
            : 0;

        // Commandes ce mois
        $ordersThisMonth = Order::whereBetween('created_at', [$startThisMonth, $now])->count();
        $ordersLastMonth = Order::whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        $ordersGrowth    = $ordersLastMonth > 0
            ? round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100, 1)
            : 0;

        // Nouveaux clients ce mois
        $newClientsThisMonth = Client::whereBetween('created_at', [$startThisMonth, $now])->count();
        $newClientsLastMonth = Client::whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        $clientsGrowth       = $newClientsLastMonth > 0
            ? round((($newClientsThisMonth - $newClientsLastMonth) / $newClientsLastMonth) * 100, 1)
            : 0;
        // dd($newClientsThisMonth);
        // Produits en stock faible ou rupture
        $lowStockCount  = Product::where('status', 'published')
            ->whereRaw('stock_quantity <= low_stock_threshold')
            ->where('stock_quantity', '>', 0)
            ->count();
        $outStockCount  = Product::where('status', 'published')
            ->where('stock_quantity', '<=', 0)
            ->count();

        // ════════════════════════════════════════════════════════════════
        // 2. STATISTIQUES COMMANDES (pour les cards de statut)
        // ════════════════════════════════════════════════════════════════
        $stats = [
            'pending'    => Order::where('status', 'pending')->count(),
            'processing' => Order::whereIn('status', ['confirmed', 'processing'])->count(),
            'shipped'    => Order::where('status', 'shipped')->count(),
            'delivered'  => Order::where('status', 'delivered')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
            'refunded'   => Order::where('status', 'refunded')->count(),
            'total'      => Order::count(),
            'revenue'    => Order::where('payment_status', 'paid')->sum('total'),
        ];

        // ════════════════════════════════════════════════════════════════
        // 3. GRAPHIQUE REVENUS 12 DERNIERS MOIS (pour le line chart)
        // ════════════════════════════════════════════════════════════════
        $revenueByMonth = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', $now->copy()->subMonths(11)->startOfMonth())
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $revenueLabels = [];
        $revenueData   = [];
        for ($i = 11; $i >= 0; $i--) {
            $key = $now->copy()->subMonths($i)->format('Y-m');
            $revenueLabels[] = $now->copy()->subMonths($i)->translatedFormat('M Y');
            $revenueData[]   = (float) ($revenueByMonth[$key] ?? 0);
        }

        // ════════════════════════════════════════════════════════════════
        // 4. GRAPHIQUE COMMANDES PAR SEMAINE (7 derniers jours)
        // ════════════════════════════════════════════════════════════════
        $ordersByDay = Order::where('created_at', '>=', $now->copy()->subDays(6)->startOfDay())
            ->selectRaw("DATE(created_at) as day, COUNT(*) as total")
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        $weekLabels = [];
        $weekData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $key = $now->copy()->subDays($i)->format('Y-m-d');
            $weekLabels[] = $now->copy()->subDays($i)->translatedFormat('D d/m');
            $weekData[]   = (int) ($ordersByDay[$key] ?? 0);
        }

        // ════════════════════════════════════════════════════════════════
        // 5. RÉPARTITION COMMANDES PAR STATUT (pour le donut chart)
        // ════════════════════════════════════════════════════════════════
        $statusDistribution = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // ════════════════════════════════════════════════════════════════
        // 6. TOP 5 PRODUITS LES PLUS VENDUS
        // ════════════════════════════════════════════════════════════════
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->selectRaw('products.id, products.name, SUM(order_items.quantity) as total_qty, SUM(order_items.quantity * order_items.unit_price) as total_revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // ════════════════════════════════════════════════════════════════
        // 7. DERNIÈRES COMMANDES (tableau récent)
        // ════════════════════════════════════════════════════════════════
        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->limit(7)
            ->get();

        // ════════════════════════════════════════════════════════════════
        // 8. RÉPARTITION MÉTHODES DE PAIEMENT (pour le pie chart)
        // ════════════════════════════════════════════════════════════════
        $paymentMethods = Order::selectRaw('payment_method, COUNT(*) as total')
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        // ════════════════════════════════════════════════════════════════
        // 9. CLIENTS LES PLUS ACTIFS
        // ════════════════════════════════════════════════════════════════
        $topClients = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.status', '!=', 'cancelled')
            ->selectRaw('users.id, users.name, users.email, COUNT(orders.id) as orders_count, SUM(orders.total) as total_spent')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        // ════════════════════════════════════════════════════════════════
        // 10. REVENUS CETTE SEMAINE VS SEMAINE DERNIÈRE (bar chart)
        // ════════════════════════════════════════════════════════════════
        $revenueThisWeekByDay = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', $startThisWeek)
            ->selectRaw("DAYOFWEEK(created_at) as dow, SUM(total) as total")
            ->groupBy('dow')
            ->pluck('total', 'dow');

        $revenueLastWeekByDay = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startLastWeek, $endLastWeek])
            ->selectRaw("DAYOFWEEK(created_at) as dow, SUM(total) as total")
            ->groupBy('dow')
            ->pluck('total', 'dow');

        $weekDays       = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
        $thisWeekData   = [];
        $lastWeekData   = [];
        for ($d = 1; $d <= 7; $d++) {
            $thisWeekData[] = (float) ($revenueThisWeekByDay[$d] ?? 0);
            $lastWeekData[] = (float) ($revenueLastWeekByDay[$d] ?? 0);
        }

        // ════════════════════════════════════════════════════════════════
        // 11. TOTAUX GLOBAUX POUR LES MINI STATS
        // ════════════════════════════════════════════════════════════════
        $totalClients  = Client::count();
        $totalProducts = Product::where('status', 'published')->count();
        $totalRevenue  = Order::where('payment_status', 'paid')->sum('total');

        return view('admin.index', compact(
            // KPI
            'revThisMonth', 'revGrowth',
            'ordersThisMonth', 'ordersGrowth',
            'newClientsThisMonth', 'clientsGrowth',
            'lowStockCount', 'outStockCount',
            // Stats commandes
            'stats',
            // Graphiques
            'revenueLabels', 'revenueData',
            'weekLabels', 'weekData',
            'statusDistribution',
            'paymentMethods',
            'weekDays', 'thisWeekData', 'lastWeekData',
            // Tableaux
            'topProducts', 'recentOrders', 'topClients',
            // Totaux
            'totalClients', 'totalProducts', 'totalRevenue',
        ));
    }
    // ================================================================
    // GESTION DES COMMANDES 
    // ================================================================

    public function index()
    {
        $pendingOrders = Order::with(['user', 'items'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $processingOrders = Order::with(['user', 'items'])
            ->whereIn('status', ['confirmed', 'processing', 'shipped'])
            ->latest()
            ->get();

        // Statistiques rapides
        $stats = [
            'pending'    => Order::where('status', 'pending')->count(),
            'processing' => Order::whereIn('status', ['confirmed', 'processing'])->count(),
            'shipped'    => Order::where('status', 'shipped')->count(),
            'delivered'  => Order::where('status', 'delivered')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
            'revenue'    => Order::where('payment_status', 'paid')->sum('total'),
        ];

        return view('backend.commandes.index', compact('pendingOrders', 'processingOrders', 'stats'));
    }

    // ================================================================
    // HISTORIQUE DES COMMANDES
    // ================================================================

    public function historique(Request $request)
    {
        $query = Order::with(['user', 'items'])
            ->whereIn('status', ['delivered', 'cancelled', 'refunded']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('order_number', 'LIKE', "%{$s}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'LIKE', "%{$s}%")
                      ->orWhere('email', 'LIKE', "%{$s}%"));
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        return view('backend.commandes.historique', compact('orders'));
    }

    // ================================================================
    // DÉTAIL D'UNE COMMANDE
    // ================================================================

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['user', 'items.product.images', 'items.color'])
            ->firstOrFail();

        return view('backend.commandes.show', compact('order'));
    }

    // ================================================================
    // CHANGER LE STATUT D'UNE COMMANDE
    // ================================================================

    public function updateStatus(Request $request, $orderNumber)
    {
        try {
            DB::beginTransaction();
            
            Log::info('Tentative de mise à jour de statut', [
                'order_number' => $orderNumber,
                'new_status' => $request->status,
                'user_id' => Auth::id()
            ]);
            
            $order = Order::where('order_number', $orderNumber)->firstOrFail();
            
            // Validation spécifique pour le remboursement
            $rules = [
                'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded',
                'notes' => 'nullable|string|max:500',
            ];
            
            $messages = [];
            
            // Si le statut est "refunded", ajouter la validation pour la preuve
            if ($request->status === 'refunded') {
                $rules['refund_proof'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
                $messages = [
                    'refund_proof.required' => 'La preuve de remboursement est obligatoire',
                    'refund_proof.image' => 'Le fichier doit être une image',
                    'refund_proof.mimes' => 'Le format doit être JPEG, PNG, JPG ou GIF',
                    'refund_proof.max' => 'La taille de l\'image ne doit pas dépasser 5MB'
                ];
            }
            
            $request->validate($rules, $messages);
            
            // Gestion de l'upload de la preuve de remboursement
            $refundProofPath = null;
            if ($request->status === 'refunded' && $request->hasFile('refund_proof')) {
                try {
                    $image = $request->file('refund_proof');
                    $fileName = 'refund_' . $orderNumber . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $refundProofPath = $image->storeAs('refund_proofs', $fileName, 'public');
                    
                    Log::info('Preuve de remboursement uploadée', [
                        'order_number' => $orderNumber,
                        'file' => $fileName,
                        'path' => $refundProofPath
                    ]);
                } catch (\Exception $e) {
                    Log::error('Erreur upload preuve remboursement: ' . $e->getMessage());
                    throw new \Exception('Erreur lors de l\'upload de la preuve de remboursement');
                }
            }
            
            // Si le statut passe à "refunded", on remet le stock
            if ($request->status === 'refunded' && $order->status !== 'refunded') {
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product) {
                        $product->increment('stock_quantity', $item->quantity);
                        Log::info('Stock remis pour remboursement', [
                            'product_id' => $product->id,
                            'quantity' => $item->quantity
                        ]);
                    }
                }
            }
            
            // Préparer les données de mise à jour
            $updateData = [
                'status' => $request->status,
                'notes' => $request->notes,
            ];
            
            // Si c'est un remboursement, ajouter les informations
            if ($request->status === 'refunded') {
                $updateData['refund_proof'] = $refundProofPath;
                $updateData['refunded_at'] = now();
                $updateData['payment_status'] = 'refunded'; // Optionnel
            }
            
            $order->update($updateData);
            
            DB::commit();
            
            // Recharger la commande pour avoir les dernières données
            $order->refresh();
            
            Log::info('Statut mis à jour avec succès', [
                'order_number' => $orderNumber,
                'new_status' => $request->status,
                'has_refund_proof' => !is_null($refundProofPath)
            ]);
            
            return response()->json([
                'success' => true,
                'message' => $request->status === 'refunded' 
                    ? 'Remboursement enregistré avec succès.' 
                    : 'Statut mis à jour avec succès.',
                'order' => [
                    'status_label' => $order->status_label,
                    'status_color' => $order->status_color,
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur updateStatus: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    // ================================================================
    // MARQUER COMME PAYÉE
    // ================================================================
    public function markPaid(Request $request, $orderNumber)
    {
        try {
            DB::beginTransaction();
            
            Log::info('Tentative de marquage de paiement', [
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'user_name' => Auth::user() ? Auth::user()->name : 'Inconnu',
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString()
            ]);
            
            $order = Order::where('order_number', $orderNumber)->firstOrFail();
            
            Log::info('Commande trouvée', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'current_payment_status' => $order->payment_status,
                'current_payment_reference' => $order->payment_reference,
                'order_total' => $order->total,
                'client' => $order->user->name ?? $order->shipping_fullname
            ]);
            
            // Validation
            $request->validate([
                'payment_reference' => 'nullable|string|max:255',
                'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ], [
                'payment_proof.image' => 'Le fichier doit être une image',
                'payment_proof.mimes' => 'Le format doit être JPEG, PNG, JPG ou GIF',
                'payment_proof.max' => 'La taille de l\'image ne doit pas dépasser 5MB'
            ]);

            Log::debug('Données de paiement reçues', [
                'payment_reference' => $request->payment_reference,
                'has_file' => $request->hasFile('payment_proof'),
                'file_original_name' => $request->hasFile('payment_proof') ? $request->file('payment_proof')->getClientOriginalName() : null,
                'file_size' => $request->hasFile('payment_proof') ? $request->file('payment_proof')->getSize() : null,
                'file_mime' => $request->hasFile('payment_proof') ? $request->file('payment_proof')->getMimeType() : null
            ]);
            
            // Gestion de l'upload
            $proofPath = null;
            if ($request->hasFile('payment_proof')) {
                try {
                    $image = $request->file('payment_proof');
                    
                    // Vérifier que le fichier est valide
                    if (!$image->isValid()) {
                        throw new \Exception('Le fichier uploadé n\'est pas valide');
                    }
                    
                    // Créer le dossier s'il n'existe pas
                    $uploadPath = storage_path('app/public/payment_proofs');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    
                    $fileName = 'payment_' . $orderNumber . '_' . time() . '.' . $image->getClientOriginalExtension();
                    
                    // Méthode 1: Utiliser storeAs (retourne le chemin relatif)
                    $proofPath = $image->storeAs('payment_proofs', $fileName, 'public');
                    
                    // Vérifier que le fichier a bien été créé
                    $fullPath = storage_path('app/public/' . $proofPath);
                    if (file_exists($fullPath)) {
                        Log::info('Fichier vérifié physiquement', [
                            'full_path' => $fullPath,
                            'file_exists' => true,
                            'file_size' => filesize($fullPath)
                        ]);
                    } else {
                        Log::warning('Fichier non trouvé après upload', [
                            'full_path' => $fullPath
                        ]);
                    }
                    
                    Log::info('Fichier de preuve de paiement uploadé avec succès', [
                        'original_name' => $image->getClientOriginalName(),
                        'stored_name' => $fileName,
                        'path' => $proofPath,
                        'full_storage_path' => storage_path('app/public/' . $proofPath),
                        'public_url' => asset('storage/' . $proofPath),
                        'size' => $image->getSize(),
                        'mime' => $image->getMimeType()
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error('Erreur lors de l\'upload de la preuve de paiement', [
                        'order_number' => $orderNumber,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw new \Exception('Impossible d\'uploader la preuve de paiement: ' . $e->getMessage());
                }
            }
            
            // Mise à jour de la commande
            $oldStatus = $order->payment_status;
            $oldReference = $order->payment_reference;
            
            Log::info('Avant mise à jour BDD', [
                'payment_proof_value' => $proofPath
            ]);
            
            $updateData = [
                'payment_status' => 'paid',
                'payment_reference' => $request->payment_reference,
            ];
            
            // N'ajouter payment_proof que s'il n'est pas null
            if ($proofPath !== null) {
                $updateData['payment_proof'] = $proofPath;
            }
            
            $order->update($updateData);
            
            // Rafraîchir le modèle pour voir les données mises à jour
            $order->refresh();
            
            Log::info('Paiement marqué avec succès', [
                'order_number' => $orderNumber,
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => 'paid',
                'old_reference' => $oldReference,
                'new_reference' => $request->payment_reference,
                'proof_path_in_db' => $order->payment_proof, // Vérifier ce qui est en BDD
                'proof_path_saved' => $proofPath,
                'updated_by' => Auth::id()
            ]);
            
            DB::commit();
            
            // Vérification finale
            $finalCheck = Order::where('order_number', $orderNumber)->first();
            Log::info('Vérification après commit', [
                'order_number' => $orderNumber,
                'payment_proof_in_db' => $finalCheck->payment_proof
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Commande marquée comme payée avec succès.',
                'alert-type' => 'Succès',
                'data' => [
                    'order_number' => $order->order_number,
                    'payment_reference' => $order->payment_reference,
                    'has_proof' => !is_null($order->payment_proof),
                    'proof_url' => $order->payment_proof ? asset('storage/' . $order->payment_proof) : null
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur lors du marquage de paiement', [
                'order_number' => $orderNumber,
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'request_data' => $request->except('payment_proof')
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du marquage du paiement: ' . $e->getMessage()
            ], 500);
        }
    }

    // ================================================================
    // COMMENCER LE TRAITEMENT (pending → confirmed)
    // ================================================================

    public function startProcessing($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('status', 'pending')
            ->firstOrFail();

        $order->update(['status' => 'confirmed']);

        return response()->json([
            'success' => true,
            'message' => "Commande {$orderNumber} confirmée.",
            'alert-type' => 'Succès',
        ]);
    }

    // ================================================================
    // AJAX — données pour les tableaux (rechargement sans reload page)
    // ================================================================

    public function getPendingOrders()
    {
        $orders = Order::with(['user', 'items'])
            ->where('status', 'pending')
            ->latest()
            ->get()
            ->map(fn($o) => $this->formatOrder($o));

        return response()->json($orders);
    }

    public function getProcessingOrders()
    {
        $orders = Order::with(['user', 'items'])
            ->whereIn('status', ['confirmed', 'processing', 'shipped'])
            ->latest()
            ->get()
            ->map(fn($o) => $this->formatOrder($o));

        return response()->json($orders);
    }

    // ── Formatage commun ─────────────────────────────────────────────
    private function formatOrder(Order $order): array
    {
        return [
            'id'             => $order->id,
            'order_number'   => $order->order_number,
            'customer_name'  => $order->user->name ?? $order->shipping_fullname,
            'customer_email' => $order->user->email ?? $order->shipping_email,
            'phone'          => $order->shipping_phone,
            'address'        => $order->shipping_address . ', ' . $order->shipping_city,
            'products'       => $order->items->map(fn($i) => $i->product_name . ' (×' . $i->quantity . ')')->join(', '),
            'items_count'    => $order->items->sum('quantity'),
            'total'          => $order->total,
            'total_fmt'      => number_format($order->total, 0, ',', ' ') . ' FCFA',
            'status'         => $order->status,
            'status_label'   => $order->status_label,
            'status_color'   => $order->status_color,
            'payment_method' => $order->payment_label,
            'payment_status' => $order->payment_status,
            'created_at'     => $order->created_at->format('d/m/Y à H:i'),
            'detail_url'     => route('backend.commandes.show', $order->order_number),
        ];
    }
}
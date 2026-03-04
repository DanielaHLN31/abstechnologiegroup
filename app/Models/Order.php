<?php
// ══════════════════════════════════════════════════════════════════
// app/Models/Order.php
// ══════════════════════════════════════════════════════════════════
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    
    protected $guarded = [''];
    protected $casts = [
        'refunded_at' => 'datetime',
    ];

    // ── Labels lisibles ──────────────────────────────────────────

    const STATUS_LABELS = [
        'pending'    => 'En attente',
        'confirmed'  => 'Confirmée',
        'processing' => 'En traitement',
        'shipped'    => 'Expédiée',
        'delivered'  => 'Livrée',
        'cancelled'  => 'Annulée',
        'refunded'   => 'Remboursée',
    ];

    const STATUS_COLORS = [
        'pending'    => '#f0ad4e',
        'confirmed'  => '#5bc0de',
        'processing' => '#717fe0',
        'shipped'    => '#5cb85c',
        'delivered'  => '#28a745',
        'cancelled'  => '#e65540',
        'refunded'   => '#868e96',
    ];

    // Dans app/Models/Order.php

    const PAYMENT_METHOD_CASH = 'cash_on_delivery';
    const PAYMENT_METHOD_BANK = 'bank_transfer';
    const PAYMENT_METHOD_MTN = 'mtn_benin';
    const PAYMENT_METHOD_MOOV = 'moov_benin';
    const PAYMENT_METHOD_CELTIIS = 'celtiis_bj';
    
    public static function getPaymentMethods()
    {
        return [
            self::PAYMENT_METHOD_CASH,
            self::PAYMENT_METHOD_BANK,
            self::PAYMENT_METHOD_MTN,
            self::PAYMENT_METHOD_MOOV,
            self::PAYMENT_METHOD_CELTIIS,
        ];
    }
    
    public static function getMobileMethods()
    {
        return [
            self::PAYMENT_METHOD_MTN,
            self::PAYMENT_METHOD_MOOV,
            self::PAYMENT_METHOD_CELTIIS,
        ];
    }

    const PAYMENT_LABELS = [
        'cash_on_delivery' => 'Paiement à la livraison',
        'mobile_money'     => 'Mobile Money',
        'bank_transfer'    => 'Virement bancaire',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? '#aaa';
    }

    public function getPaymentLabelAttribute(): string
    {
        return self::PAYMENT_LABELS[$this->payment_method] ?? $this->payment_method;
    }

    // ── Relations ────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Génération du numéro de commande ─────────────────────────

    public static function generateOrderNumber(): string
    {
        $date  = now()->format('Ymd');
        $last  = self::whereDate('created_at', today())->count() + 1;
        return 'ORD-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}
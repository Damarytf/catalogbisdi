<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_contact',
        'notes',
        'total_amount',
        'status',
        'admin_notes',
        'completed_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'INV-' . date('Ym') . '-';
        $latest = self::where('order_number', 'like', $prefix . '%')->latest('id')->first();
        $sequence = $latest ? ((int) substr($latest->order_number, -4)) + 1 : 1;

        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Menunggu Chat / Baru',
            'in_chat'   => 'Proses Chat / Transfer',
            'completed' => 'Berhasil / Selesai',
            'cancelled' => 'Batal / Tidak Ada Respon',
            default     => $this->status,
        };
    }
}

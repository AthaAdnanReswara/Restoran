<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi mass assignment
     */
    protected $fillable = [
        'table_id',
        'menu_id',
        'guest_token',
        'quantity',
        'customer_name',
        'payment_method',
        'total_price',
        'status',
        'notes',
        'receipt',
    ];

    /**
     * Relasi ke tabel (meja)
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Relasi ke menu
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}

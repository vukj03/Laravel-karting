<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kart_id',
        'reservation_date',
        'package',
        'time_slot',
        'participants',
        'helmet',
        'insurance',
        'video',
        'instructions',
        'total_price',
        'status'
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'helmet' => 'boolean',
        'insurance' => 'boolean',
        'video' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Veza sa User-om
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Veza sa Kart-om
    public function kart()
    {
        return $this->belongsTo(Kart::class);
    }
}
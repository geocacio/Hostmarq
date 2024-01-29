<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmmunitionHabituality extends Model
{
    use HasFactory;

    protected $fillable = [
        'habituality_id',
        'quantity',
        'origin',
        'type',
    ];

    public function habituality()
    {
        return $this->belongsTo(Habituality::class);
    }
}

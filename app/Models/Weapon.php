<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_sigma',
        'origin',
        'user_id',
        'caliber_id',
        'model_id',
        'type_id',
    ];

    public function caliber()
    {
        return $this->belongsTo(Caliber::class);
    }

    public function model()
    {
        return $this->belongsTo(WeaponModel::class);
    }

    public function type()
    {
        return $this->belongsTo(WeaponType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

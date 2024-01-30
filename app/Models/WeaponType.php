<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponType extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'name',
    ];

    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}

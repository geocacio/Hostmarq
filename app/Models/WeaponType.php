<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponModel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'club_id'];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}

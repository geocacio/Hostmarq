<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Habituality extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'weapon_id',
        'date_time',
        'location',
        'event',
        'slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function weapon()
    {
        return $this->belongsTo(Weapon::class);
    }

    public function ammunitionHabitualities()
    {
        return $this->hasMany(AmmunitionHabituality::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public static function uniqSlug($name)
    {
        $slug = Str::slug($name);

        $count = self::where('slug', $slug)->count();

        if ($count > 0) {
            $newSlug = $slug . '-' . ($count + 1);

            while (self::where('slug', $newSlug)->count() > 0) {
                $count++;
                $newSlug = $slug . '-' . ($count + 1);
            }

            return $newSlug;
        }

        return $slug;
    }
}

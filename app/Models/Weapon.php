<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

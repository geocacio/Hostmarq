<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'acronym',
        'cnpj',
        'address',
        'phone',
        'email',
        'email_om',
        'url',
        'app_url',
        'logo',
        'favicon',
        'logo_rodape',
        'country',
        'city',
        'slug',
    ];

    public function ownedClubs()
    {
        return $this->hasOne(User::class, 'owner_id');
    }

    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }

    public function weaponTypes()
    {
        return $this->hasMany(WeaponType::class);
    }

    public function weaponModels()
    {
        return $this->hasMany(WeaponModel::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function calibers()
    {
        return $this->hasMany(Caliber::class);
    }

    public function habitualities()
    {
        return $this->hasMany(Habituality::class);
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

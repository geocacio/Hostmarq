<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'club_id',
        'name',
        'email',
        'password',
        'registration',
        'cnh',
        'cnh_issue_date',
        'cnh_expiration_date',
        'sisgcorp_password',
        'blood_type',
        'dispatcher',
        'status',
        'gender',
        'marital_status',
        'birthplace',
        'nationality',
        'birth_date',
        'profession',
        'instagram',
        'phone',
        'father',
        'mother',
        'cpf',
        'identity',
        'issuing_authority',
        'identity_issue_date',
        'voter_registration',
        'image',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function club()
    {
        return $this->hasOne(Club::class, 'owner_id');
    }

    public function clubUsers()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }

    public function owner()
    {
        return $this->hasOne(Club::class, 'owner_id');
    }

    public function habitualities()
    {
        return $this->hasMany(Habituality::class);
    }

    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }

    public function hasPermission($permission)
    {
        // Carrega as relações de roles e permissions
        $this->load('roles.permissions');

        if ($this->roles->contains('name', 'Master')) {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }

        return false;
    }

    // Função que retorna todas as roles do usuário
    public function getRoles()
    {
        $this->load('roles');
        return $this->roles;
    }

    // Função que verifica se o usuário tem uma role específica
    public function hasRole($roleName)
    {
        foreach ($this->getRoles() as $role) {
            if ($role->name == $roleName) {
                return true;
            }
        }

        return false;
    }
}

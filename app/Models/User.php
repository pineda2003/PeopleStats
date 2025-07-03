<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get user initials for avatar
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        
        return substr($initials, 0, 2);
    }

    /**
     * Get role badge information
     */
    public function getRoleBadgeAttribute()
    {
        $badges = [
            'admin' => ['icon' => '🛡️', 'text' => 'Admin', 'class' => 'success'],
            'moderator' => ['icon' => '⚖️', 'text' => 'Moderador', 'class' => 'info'],
            'user' => ['icon' => '👤', 'text' => 'Usuario', 'class' => 'secondary'],
        ];

        return $badges[$this->role] ?? $badges['user'];
    }

    /**
     * Get status badge information
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => ['icon' => '✅', 'text' => 'Activo', 'class' => 'success'],
            'inactive' => ['icon' => '❌', 'text' => 'Inactivo', 'class' => 'danger'],
            'pending' => ['icon' => '⏳', 'text' => 'Pendiente', 'class' => 'warning'],
        ];

        return $badges[$this->status] ?? $badges['pending'];
    }

    /**
     * Get formatted last login time
     */
    public function getLastLoginFormattedAttribute()
    {
        if (!$this->last_login_at) {
            return ['icon' => '❓', 'text' => 'Nunca', 'class' => 'secondary'];
        }

        $diffInHours = $this->last_login_at->diffInHours(now());
        
        if ($diffInHours < 24) {
            return ['icon' => '🟢', 'text' => 'Hace ' . $this->last_login_at->diffForHumans(), 'class' => 'light text-dark'];
        } elseif ($diffInHours < 168) { // 1 semana
            return ['icon' => '🟡', 'text' => $this->last_login_at->diffForHumans(), 'class' => 'light text-dark'];
        } else {
            return ['icon' => '🔴', 'text' => $this->last_login_at->diffForHumans(), 'class' => 'light text-dark'];
        }
    }
}
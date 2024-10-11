<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    // Fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Hidden attributes for serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts for attribute conversion
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 8.0+ supports hashed passwords directly
    ];

    // Optional: Add a method to check if the user has a specific role
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    // Optional: Customize the way a user is represented as a string
    public function __toString()
    {
        return $this->name;
    }
}

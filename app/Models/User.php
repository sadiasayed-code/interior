<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];


    /*
    |--------------------------------------------------------------------------
    | HIDDEN FIELDS
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | USER → CLIENT
    |--------------------------------------------------------------------------
    |
    | A customer user has one client profile.
    |
    */

    public function client()
    {
        return $this->hasOne(Client::class);
    }


    /*
    |--------------------------------------------------------------------------
    | USER → PROJECTS
    |--------------------------------------------------------------------------
    |
    | An admin/project manager can be responsible for many projects.
    |
    */

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
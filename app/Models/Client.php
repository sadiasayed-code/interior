<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'address',
    ];


    /*
    |--------------------------------------------------------------------------
    | CLIENT → USER
    |--------------------------------------------------------------------------
    |
    | A client profile belongs to one user account.
    |
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | CLIENT → PROJECTS
    |--------------------------------------------------------------------------
    |
    | One client can have multiple projects.
    |
    */

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
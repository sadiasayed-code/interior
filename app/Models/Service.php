<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'name',

        'slug',

        'short_description',

        'description',

        'starting_budget',

        'estimated_duration_days',

        'image',

        'status',

    ];


    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'starting_budget' => 'decimal:2',

    ];


    /*
    |--------------------------------------------------------------------------
    | SERVICE → PROJECTS
    |--------------------------------------------------------------------------
    */

    public function projects()
    {
        return $this->hasMany(
            Project::class
        );
    }
}
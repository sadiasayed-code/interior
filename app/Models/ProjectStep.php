<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStep extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'project_id',

        'step_number',

        'title',

        'description',

        'estimated_days',

        'estimated_cost',

        'status',

    ];


    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'estimated_cost' => 'decimal:2',

    ];


    /*
    |--------------------------------------------------------------------------
    | PROJECT RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function project()
    {
        return $this->belongsTo(
            Project::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENTS
    |--------------------------------------------------------------------------
    |
    | A project step can have payment milestones.
    |
    */

    public function payments()
    {
        return $this->hasMany(
            Payment::class
        );
    }
}
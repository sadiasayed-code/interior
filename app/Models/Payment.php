<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'project_id',
        'project_step_id',
        'milestone',
        'amount',
        'due_date',
        'payment_date',
        'status',
        'payment_method',
        'transaction_reference',
        'note',
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'payment_date' => 'date',
    ];


    /*
    |--------------------------------------------------------------------------
    | Project Relationship
    |--------------------------------------------------------------------------
    */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Project Step Relationship
    |--------------------------------------------------------------------------
    */

    public function projectStep()
    {
        return $this->belongsTo(ProjectStep::class);
    }
}
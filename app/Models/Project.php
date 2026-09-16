<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'client_id',

        'service_id',

        'user_id',

        'location',

        'description',

        'approximate_budget',

        'customer_note',

        'start_date',

        'end_date',

        'approval_status',

        'status',

        'customer_approved_at',

        'customer_rejected_at',

        'cancelled_at',

        'cancellation_reason',

    ];


    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'approximate_budget' => 'decimal:2',

        'start_date' => 'date',

        'end_date' => 'date',

        'customer_approved_at' => 'datetime',

        'customer_rejected_at' => 'datetime',

        'cancelled_at' => 'datetime',

    ];


    /*
    |--------------------------------------------------------------------------
    | PROJECT → CLIENT
    |--------------------------------------------------------------------------
    */

    public function client()
    {
        return $this->belongsTo(
            Client::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → SERVICE
    |--------------------------------------------------------------------------
    */

    public function service()
    {
        return $this->belongsTo(
            Service::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → ADMIN
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → BUDGET
    |--------------------------------------------------------------------------
    */

    public function budget()
    {
        return $this->hasOne(
            Budget::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → PAYMENTS
    |--------------------------------------------------------------------------
    */

    public function payments()
    {
        return $this->hasMany(
            Payment::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → PROJECT STEPS
    |--------------------------------------------------------------------------
    */

    public function projectSteps()
    {
        return $this->hasMany(
            ProjectStep::class
        )->orderBy(
            'step_number'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → PROGRESS REPORTS
    |--------------------------------------------------------------------------
    */

    public function progressReports()
    {
        return $this->hasMany(
            ProgressReport::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → PROJECT MATERIALS
    |--------------------------------------------------------------------------
    |
    | Internal admin information.
    | Never expose directly to customer.
    |
    */

    public function projectMaterials()
    {
        return $this->hasMany(
            ProjectMaterial::class
        );
    }
}
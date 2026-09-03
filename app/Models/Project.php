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
        'user_id',
        'project_name',
        'location',
        'start_date',
        'end_date',
        'approval_status',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];


    /*
    |--------------------------------------------------------------------------
    | PROJECT → CLIENT
    |--------------------------------------------------------------------------
    |
    | Every project belongs to one client.
    |
    */

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → USER
    |--------------------------------------------------------------------------
    |
    | This is the Admin / Project Manager responsible for the project.
    |
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → BUDGET
    |--------------------------------------------------------------------------
    |
    | One project has one budget.
    |
    */

    public function budget()
    {
        return $this->hasOne(Budget::class);
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → PAYMENTS
    |--------------------------------------------------------------------------
    |
    | One project can have multiple payments.
    |
    */

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → PROGRESS REPORTS
    |--------------------------------------------------------------------------
    |
    | One project can have multiple progress reports.
    |
    */

    public function progressReports()
    {
        return $this->hasMany(ProgressReport::class);
    }


    /*
    |--------------------------------------------------------------------------
    | PROJECT → PROJECT MATERIALS
    |--------------------------------------------------------------------------
    |
    | One project can have multiple project-material records.
    |
    */

    public function projectMaterials()
    {
        return $this->hasMany(ProjectMaterial::class);
    }
}
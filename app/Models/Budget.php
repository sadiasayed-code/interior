<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'project_id',
        'estimated_cost',
        'contract_amount',
        'actual_cost',
    ];


    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'contract_amount' => 'decimal:2',
        'actual_cost' => 'decimal:2',
    ];


    /*
    |--------------------------------------------------------------------------
    | BUDGET → PROJECT
    |--------------------------------------------------------------------------
    |
    | Every budget belongs to one project.
    |
    */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    /*
    |--------------------------------------------------------------------------
    | PROFIT / LOSS
    |--------------------------------------------------------------------------
    |
    | Profit/Loss = Contract Amount - Actual Cost
    |
    */

    public function getProfitLossAttribute()
    {
        if ($this->contract_amount === null) {
            return null;
        }

        return (float) $this->contract_amount - (float) $this->actual_cost;
    }


    /*
    |--------------------------------------------------------------------------
    | FINANCIAL STATUS
    |--------------------------------------------------------------------------
    |
    | PROFIT
    | LOSS
    | BREAK-EVEN
    | PENDING
    |
    */

    public function getFinancialStatusAttribute()
    {
        if ($this->contract_amount === null) {
            return 'pending';
        }

        $profitLoss = $this->profit_loss;

        if ($profitLoss > 0) {
            return 'profit';
        }

        if ($profitLoss < 0) {
            return 'loss';
        }

        return 'break-even';
    }
}
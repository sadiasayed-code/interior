<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | PROJECT
            |--------------------------------------------------------------------------
            |
            | Every budget belongs to one project.
            |
            */

            $table->foreignId('project_id')
                ->constrained('projects')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | ESTIMATED COST
            |--------------------------------------------------------------------------
            |
            | Estimated internal cost of completing the project.
            |
            */

            $table->decimal('estimated_cost', 10, 2);


            /*
            |--------------------------------------------------------------------------
            | CONTRACT AMOUNT
            |--------------------------------------------------------------------------
            |
            | Amount agreed with / charged to the customer.
            |
            | This will be used to calculate Profit or Loss.
            |
            */

            $table->decimal('contract_amount', 10, 2);


            /*
            |--------------------------------------------------------------------------
            | ACTUAL COST
            |--------------------------------------------------------------------------
            |
            | Actual amount spent on the project.
            |
            */

            $table->decimal('actual_cost', 10, 2)->default(0);


            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
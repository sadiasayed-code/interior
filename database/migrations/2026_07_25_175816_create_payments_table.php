<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | PROJECT
            |--------------------------------------------------------------------------
            */

            $table->foreignId('project_id')
                ->constrained()
                ->onDelete('cascade');


            /*
            |--------------------------------------------------------------------------
            | PAYMENT MILESTONE
            |--------------------------------------------------------------------------
            |
            | Example:
            | Advance
            | 1st Installment
            | 2nd Installment
            | Final Payment
            |
            */

            $table->string('milestone');


            /*
            |--------------------------------------------------------------------------
            | AMOUNT
            |--------------------------------------------------------------------------
            */

            $table->decimal(
                'amount',
                10,
                2
            );


            /*
            |--------------------------------------------------------------------------
            | DUE DATE
            |--------------------------------------------------------------------------
            */

            $table->date('due_date')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | PAYMENT DATE
            |--------------------------------------------------------------------------
            |
            | Only required when status = paid.
            |
            */

            $table->date('payment_date')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | PAYMENT STATUS
            |--------------------------------------------------------------------------
            |
            | paid
            | pending
            | upcoming
            | overdue
            |
            */

            $table->enum(
                'status',
                [
                    'paid',
                    'pending',
                    'upcoming',
                    'overdue',
                ]
            )
            ->default('pending');


            /*
            |--------------------------------------------------------------------------
            | PAYMENT METHOD
            |--------------------------------------------------------------------------
            |
            | Cash
            | Bank
            | Mobile Banking
            | etc.
            |
            | Only necessary when payment is actually paid.
            |
            */

            $table->string('payment_method')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | NOTE
            |--------------------------------------------------------------------------
            */

            $table->text('note')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | CUSTOMER
            |--------------------------------------------------------------------------
            */

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | SELECTED SERVICE
            |--------------------------------------------------------------------------
            |
            | Customer request
            |
            */

            $table->foreignId('service_id')
                ->constrained('services')
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | ADMIN
            |--------------------------------------------------------------------------
            |
            | 
            | 
            |
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | PROJECT BASIC INFORMATION
            |--------------------------------------------------------------------------
            */

            $table->string('location')
                ->nullable();

            $table->text('description')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | CUSTOMER APPROXIMATE BUDGET
            |--------------------------------------------------------------------------
            |
            | 
            |
            | 
            |
            */

            $table->decimal(
                'approximate_budget',
                12,
                2
            )->nullable();


            /*
            |--------------------------------------------------------------------------
            | CUSTOMER NOTE
            |--------------------------------------------------------------------------
            */

            $table->text('customer_note')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | PROJECT DATES
            |--------------------------------------------------------------------------
            */

            $table->date('start_date')
                ->nullable();

            $table->date('end_date')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | ADMIN REQUEST REVIEW
            |--------------------------------------------------------------------------
            */

            $table->enum(
                'approval_status',
                [
                    'pending',
                    'approved',
                    'rejected',
                ]
            )->default('pending');


            /*
            |--------------------------------------------------------------------------
            | PROJECT WORKFLOW STATUS
            |--------------------------------------------------------------------------
            |
            | request_pending
            | admin_review
            | proposal_sent
            | customer_approved
            | customer_rejected
            | ongoing
            | paused
            | completed
            | cancelled
            |
            */

            $table->enum(
                'status',
                [
                    'request_pending',
                    'admin_review',
                    'proposal_sent',
                    'customer_approved',
                    'customer_rejected',
                    'ongoing',
                    'paused',
                    'completed',
                    'cancelled',
                ]
            )->default('request_pending');


            /*
            |--------------------------------------------------------------------------
            | CUSTOMER RESPONSE
            |--------------------------------------------------------------------------
            */

            $table->timestamp(
                'customer_approved_at'
            )->nullable();

            $table->timestamp(
                'customer_rejected_at'
            )->nullable();


            /*
            |--------------------------------------------------------------------------
            | CANCELLATION
            |--------------------------------------------------------------------------
            */

            $table->timestamp(
                'cancelled_at'
            )->nullable();

            $table->text(
                'cancellation_reason'
            )->nullable();


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
        Schema::dropIfExists('projects');
    }
};
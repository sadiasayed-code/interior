<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | BASIC INFORMATION
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('slug')
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | SHORT DESCRIPTION
            |--------------------------------------------------------------------------
            |
            | TEXT ব্যবহার করা হয়েছে যাতে 255 character-এর বেশি
            | content রাখা যায়।
            |
            */

            $table->text('short_description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | FULL / LONG DESCRIPTION
            |--------------------------------------------------------------------------
            |
            | LONGTEXT ব্যবহার করা হয়েছে যাতে অনেক বড় description
            | রাখা যায়।
            |
            */

            $table->longText('description')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | APPROXIMATE / STARTING BUDGET
            |--------------------------------------------------------------------------
            |
            | This is only an approximate budget shown
            | on the public frontend.
            |
            | This is NOT the final contract amount.
            |
            */

            $table->decimal(
                'starting_budget',
                12,
                2
            )
            ->nullable();


            /*
            |--------------------------------------------------------------------------
            | ESTIMATED DURATION
            |--------------------------------------------------------------------------
            |
            | Example:
            | 15 Days
            | 30 Days
            | 45 Days
            |
            */

            $table->unsignedInteger(
                'estimated_duration_days'
            )
            ->nullable();


            /*
            |--------------------------------------------------------------------------
            | SERVICE IMAGE
            |--------------------------------------------------------------------------
            */

            $table->string('image')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum(
                'status',
                [
                    'active',
                    'inactive',
                ]
            )
            ->default('active');


            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
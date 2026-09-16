<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'project_steps',
            function (Blueprint $table) {

                $table->id();


                /*
                |--------------------------------------------------------------------------
                | PROJECT
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'project_id'
                )
                ->constrained()
                ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | STEP ORDER
                |--------------------------------------------------------------------------
                |
                | Example:
                |
                | 1 = Design
                | 2 = Material Selection
                | 3 = Civil Work
                | 4 = Installation
                |
                */

                $table->unsignedInteger(
                    'step_number'
                );


                /*
                |--------------------------------------------------------------------------
                | STEP TITLE
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'title'
                );


                /*
                |--------------------------------------------------------------------------
                | DESCRIPTION
                |--------------------------------------------------------------------------
                */

                $table->text(
                    'description'
                )
                ->nullable();


                /*
                |--------------------------------------------------------------------------
                | ESTIMATED DAYS
                |--------------------------------------------------------------------------
                */

                $table->unsignedInteger(
                    'estimated_days'
                )
                ->nullable();


                /*
                |--------------------------------------------------------------------------
                | ESTIMATED COST
                |--------------------------------------------------------------------------
                */

                $table->decimal(
                    'estimated_cost',
                    12,
                    2
                )
                ->nullable();


                /*
                |--------------------------------------------------------------------------
                | STEP STATUS
                |--------------------------------------------------------------------------
                */

                $table->enum(
                    'status',
                    [

                        'pending',

                        'running',

                        'completed',

                    ]
                )
                ->default(
                    'pending'
                );


                /*
                |--------------------------------------------------------------------------
                | TIMESTAMPS
                |--------------------------------------------------------------------------
                */

                $table->timestamps();


                /*
                |--------------------------------------------------------------------------
                | UNIQUE STEP NUMBER
                |--------------------------------------------------------------------------
                */

                $table->unique(
                    [

                        'project_id',

                        'step_number',

                    ]
                );

            }
        );
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'project_steps'
        );
    }
};
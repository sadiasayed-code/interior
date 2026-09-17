<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('previous_work_images', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('previous_work_id');

            $table->string('image');

            $table->unsignedTinyInteger('sort_order')
                ->default(1);

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Foreign Key
            |--------------------------------------------------------------------------
            */

            $table->foreign('previous_work_id')
                ->references('id')
                ->on('previous_works')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | One Position Per Previous Work
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'previous_work_id',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('previous_work_images');
    }
};
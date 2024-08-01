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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('responsible_id');
            $table->unsignedBigInteger('stage_id');
            $table->unsignedBigInteger('order')->nullable();
            $table->string('name');
            $table->text('description');
            $table->text('details');
            $table->date('start_date');
            $table->date('finish_date');
            $table->string('status')->nullable();
            $table->string('progress')->nullable();
            $table->string('priority')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

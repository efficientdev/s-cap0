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
        Schema::create('capture_logs', function (Blueprint $table) {
            $table->id();
            //$table->integer('user_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('subject_id');
            $table->text('capture_path');
            $table->text('status')->nullable();//->default('pending');
            $table->longText('notes')->nullable();//->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capture_logs');
    }
};

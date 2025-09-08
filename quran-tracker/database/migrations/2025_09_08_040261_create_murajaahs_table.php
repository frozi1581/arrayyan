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
        Schema::create('murajaahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->string('surah_name');
            $table->integer('start_ayah');
            $table->integer('end_ayah');
            $table->enum('status', ['pending', 'completed', 'reviewed'])->default('pending');
            $table->date('target_date');
            $table->date('completed_date')->nullable();
            $table->text('notes')->nullable();
            $table->integer('score')->nullable(); // Skor dari ustadz
            $table->text('feedback')->nullable(); // Feedback dari ustadz
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('murajaahs');
    }
};

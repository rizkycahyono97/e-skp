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
        Schema::create('performance_feedback', function (Blueprint $table) {
            $table->id('feedback_id')->primary();
            $table->foreignId('evaluation_id')->constrained('skp_evaluations', 'evaluation_id')->onDelete('cascade');
            $table->foreignId('work_result_id')->constrained('work_results', 'work_result_id')->onDelete('cascade');
            $table->foreignId('provided_by_id')->nullable()->constrained('users', 'user_id')->onDelete('set null');
            $table->text('feedback_note');
            $table->enum('rating', ['dibawah_ekspektasi', 'sesuai_ekspektasi', 'diatas_ekspektasi']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_feedback');
    }
};

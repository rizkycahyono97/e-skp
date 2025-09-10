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
            $table->id();
            $table->foreignId('evaluation_id')->constrained('skp_evaluations')->onDelete('cascade');
            $table->foreignId('work_result_id')->constrained('work_results')->onDelete('cascade');
            $table->foreignId('provided_by_id')->nullable()->constrained('users')->onDelete('set null');
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

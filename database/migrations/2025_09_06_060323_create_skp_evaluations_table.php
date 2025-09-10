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
        Schema::create('skp_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skp_id')->nullable()->constrained('skp_plans')->onDelete('set null');
            $table->foreignId('evaluated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('organizational_performance_score', ['sangat_kurang', 'kurang', 'cukup', 'baik', 'sangat_baik', 'sempurna']);
            $table->enum('final_rating_work', ['dibawah_ekspektasi', 'sesuai_ekspektasi', 'diatas_ekspektasi']);
            $table->enum('final_rating_behavior', ['dibawah_ekspektasi', 'sesuai_ekspektasi', 'diatas_ekspektasi']);
            $table->enum('final_predicate', ['sangat_kurang', 'kurang', 'butuh_perbaikan', 'baik', 'sangat_baik', 'sempurna']);
            $table->text('evaluation_note')->nullable();
            $table->timestamp('evaluated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skp_evaluations');
    }
};

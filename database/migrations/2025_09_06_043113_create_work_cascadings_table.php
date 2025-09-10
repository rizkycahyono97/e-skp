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
        Schema::create('work_cascadings', function (Blueprint $table) {
            $table->id('cascading_id')->primary();
            $table->foreignId('parent_work_result_id')->constrained('work_results', 'work_result_id')->onDelete('cascade');
            $table->foreignId('child_skp_id')->constrained('skp_plans', 'skp_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_cascadings');
    }
};

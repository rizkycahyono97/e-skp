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
            $table->id();
            $table->foreignId('parent_work_result_id')->nullable()->constrained('work_results')->onDelete('cascade');
            $table->foreignId('child_skp_id')->nullable()->constrained('skp_plans')->onDelete('cascade');
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

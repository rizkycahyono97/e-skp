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
        Schema::create('work_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skp_id')->nullable()->constrained('skp_plans')->onDelete('set null');
            $table->foreignId('pa_id')->nullable()->constrained('performance_agreements')->onDelete('set null');
            $table->text('description');
            $table->string('penugasan_dari')->nullable();
            $table->boolean('is_from_cascading');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_results');
    }
};

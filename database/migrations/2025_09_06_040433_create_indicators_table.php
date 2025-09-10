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
        Schema::create('indicators', function (Blueprint $table) {
            $table->id('indicator_id')->primary();
            $table->foreignId('work_result_id')->nullable()->constrained('work_results', 'work_result_id')->onDelete('set null');
            $table->text('description');
            $table->string('target', length:100);
            $table->string('perspektif');
            // $table->boolean('is_manual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};

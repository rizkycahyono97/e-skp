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
        Schema::create('work_realizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_result_id')->nullable()->constrained('work_results')->onDelete('set null');
            $table->text('realization_desc');
            $table->dateTime('submitted_at');
            $table->enum('status', ['draft', 'submitted', 'evaluated']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_realizations');
    }
};

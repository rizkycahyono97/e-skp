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
        Schema::create('skp_plans', function (Blueprint $table) {
            $table->id('skp_id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id')->onDelete('set null');
            $table->foreignId('pa_id')->nullable()->constrained('performance_agreements', 'pa_id')->onDelete('set null');
            $table->foreignId('approver_id')->nullable()->constrained('users', 'user_id')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('categories', 'category_id')->onDelete('set null');
            $table->year('year');
            $table->date('duration_start');
            $table->date('duration_end');
            $table->enum('status', ['draft', 'submitted', 'reverted', 'approved']);
            $table->text('rejection_reason');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skp_plans');
    }
};

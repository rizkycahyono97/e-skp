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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pa_id')->nullable()->constrained('performance_agreements')->onDelete('set null');
            $table->foreignId('skp_id')->nullable()->constrained('skp_plans')->onDelete('set null');
            $table->enum('type', ['dokumen_perjanjian_kinerja', 'laporan_bulanan', 'laporan_akhir_tahun', 'sertifikat_pelatihan', 'jurnal_ilmiah', 'laporan_pelatihan', 'bukti_keuangan', 'lainya']);
            $table->string('file_path');
            $table->string('file_name');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};

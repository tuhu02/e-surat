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
        Schema::rename('table_pengajuan_ttd', 'pengajuan_ttd');

        Schema::table('pengajuan_ttd', function (Blueprint $table){
            $table->enum('status', ['pending','selesai','ditolak'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_ttd', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    
        Schema::rename('pengajuan_ttd', 'table_pengajuan_ttd');
    }
};

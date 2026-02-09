<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_surat')->insert([
            ['nama_surat' => 'Surat Keterangan Aktif'],
            ['nama_surat' => 'Surat Tidak Sedang Menerima Beasiswa Lain'],
            ['nama_surat' => 'Surat Pengantar Magang'],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\TempUpload;
use Illuminate\Database\Seeder;

class TempUploadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TempUpload::insert(['id' => null, 'created_at' => now(), 'updated_at' => now()]);
    }
}

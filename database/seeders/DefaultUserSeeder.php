<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Company;
use App\Modules\Shared\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = bcrypt('P@ssword!');

        $companyUser = Company::create([
            'id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $companyUser->user()->create([
            'username' => 'employee1',
            'email' => 'employee1@houssist.me',
            'email_verified_at' => now(),
            'password' => $password,
            'remember_token' => null,
            'address' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $adminUser = Admin::create([
            'id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $adminUser->user()->create([
            'username' => 'admin',
            'email' => 'admin@houssist.me',
            'email_verified_at' => now(),
            'password' => $password,
            'remember_token' => null,
            'address' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

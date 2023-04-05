<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade;

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

        $companyUserModel = $companyUser->user()->create([
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

        $adminUserModel = $adminUser->user()->create([
            'username' => 'admin',
            'email' => 'admin@houssist.me',
            'email_verified_at' => now(),
            'password' => $password,
            'remember_token' => null,
            'address' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        BouncerFacade::assign('admin')->to($adminUserModel);
        BouncerFacade::assign('company')->to($companyUserModel);
    }
}

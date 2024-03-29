<?php

namespace Database\Seeders;

use App\Modules\Shared\Models\Advertisement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

class InitialPermissionSeeder extends Seeder
{
    private Role $homeOwnerRole;
    private Role $serviceProviderRole;
    private Role $companyRole;
    private Role $adminRole;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->truncateTables();
        $this->addRoles();
        $this->addAbilities();
        $this->ownedModels();

        Bouncer::refresh(null);
    }

    private function addRoles()
    {
        $roles = [
            [
                'name' => 'home-owner',
                'Title' => 'Home Owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'service-provider',
                'Title' => 'Service Provider',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company',
                'Title' => 'Company Employee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'admin',
                'Title' => 'Back Office',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Role::insert($roles);
    }

    private function addAbilities()
    {
        $homeOwnerAbilities = [
            [
                'name' => 'home-owner-dashboard',
                'title' => 'Home Owner Dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'home-owner-tasks',
                'title' => 'Home Owner Tasks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'home-owner-advertisements',
                'title' => 'Home Owner Advertisements',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'home-owner-calendar',
                'title' => 'Home Owner Calendar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $serviceProviderAbilities = [
            [
                'name' => 'service-provider-dashboard',
                'title' => 'Service Provider Dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'service-provider-tasks',
                'title' => 'Service Provider Tasks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'service-provider-advertisements',
                'title' => 'Service Provider Advertisements',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'service-provider-advertisement-offers',
                'title' => 'Service Provider Advertisement Offers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'service-provider-kyc-create',
                'title' => 'Service Provider KYC Create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'service-provider-kyc-waiting',
                'title' => 'Service Provider KYC Waiting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'service-provider-calendar',
                'title' => 'Service Provider Calendar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $companyAbilities = [
            [
                'name' => 'company-dashboard',
                'title' => 'Company Dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company-tasks',
                'title' => 'Company Tasks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company-advertisements',
                'title' => 'Company Advertisements',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company-deposits',
                'title' => 'Company Deposits',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company-withdrawals',
                'title' => 'Company Withdrawals',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company-kyc',
                'title' => 'Company KYC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company-support-tickets',
                'title' => 'Company Support Tickets',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company-advertisements',
                'title' => 'Company Advertisements',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company-tasks',
                'title' => 'Company Tasks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $sharedAbilities = [
            [
                'name' => 'deposits',
                'title' => 'Deposits',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'withdrawals',
                'title' => 'Withdrawals',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'wallet-transactions',
                'title' => 'Wallet Transactions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'support-tickets',
                'title' => 'Support Tickets',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Ability::insert($homeOwnerAbilities);
        Ability::insert($serviceProviderAbilities);
        Ability::insert($companyAbilities);
        Ability::insert($sharedAbilities);

        $this->homeOwnerRole = Role::where('name', 'home-owner')->first();
        $this->serviceProviderRole = Role::where('name', 'service-provider')->first();
        $this->adminRole = Role::where('name', 'admin')->first();
        $this->companyRole = Role::where('name', 'company')->first();

        foreach (Arr::pluck($homeOwnerAbilities, 'name') as $name) {
            Bouncer::allow($this->homeOwnerRole)->to($name);
            Bouncer::allow($this->adminRole)->to($name);
        }

        foreach (Arr::pluck($serviceProviderAbilities, 'name') as $name) {
            Bouncer::allow($this->serviceProviderRole)->to($name);
            Bouncer::allow($this->adminRole)->to($name);
        }

        foreach (Arr::pluck($companyAbilities, 'name') as $name) {
            Bouncer::allow($this->companyRole)->to($name);
            Bouncer::allow($this->adminRole)->to($name);
        }

        foreach (Arr::pluck($sharedAbilities, 'name') as $name) {
            Bouncer::allow($this->homeOwnerRole)->to($name);
            Bouncer::allow($this->serviceProviderRole)->to($name);
            Bouncer::allow($this->adminRole)->to($name);
        }
    }

    private function truncateTables()
    {
        DB::statement('SET foreign_key_checks = 0;');
        Role::truncate();
        Ability::truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET foreign_key_checks = 1;');
    }

    private function ownedModels()
    {
        Bouncer::allow($this->homeOwnerRole)->toOwn(Advertisement::class);
        Bouncer::allow($this->companyRole)->toOwnEverything();
        Bouncer::allow($this->adminRole)->toOwnEverything();
    }
}

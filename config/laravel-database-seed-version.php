<?php

use Database\Seeders\DefaultUserSeeder;
use Database\Seeders\InitialPermissionSeeder;
use Database\Seeders\TempUploadTableSeeder;

return [
    'seeders' => [
        TempUploadTableSeeder::class,
        InitialPermissionSeeder::class,
        DefaultUserSeeder::class,
    ],
];

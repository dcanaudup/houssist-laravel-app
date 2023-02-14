<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:dcanaudup/houssist-laravel-app.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('staging')
    ->setHostname('167.172.87.201')
    ->set('remote_user', 'webuser')
    ->set('branch', 'main')
    ->set('deploy_path', '/var/www/houssist.me/staging');

host('production')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/houssist-laravel-app');

// Hooks

after('deploy:failed', 'deploy:unlock');

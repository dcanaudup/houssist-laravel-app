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
    ->setHostname('159.89.194.103')
    ->set('remote_user', 'houssist')
    ->set('branch', 'main')
    ->set('deploy_path', '/var/www/houssist.me/staging');

host('production')
    ->setHostname('159.89.194.103')
    ->set('remote_user', 'houssist')
    ->set('branch', 'main')
    ->set('deploy_path', '/var/www/houssist.me/production');

// Functions

set('php_fpm', 'php8.2-fpm');
desc('Restart php fpm service');
task(
    'restart:php-fpm',
    function () {
        run('sudo systemctl restart {{php_fpm}}');
    }
);

task(
    'deploy:assets',
    function () {
        run('cd {{release_path}} && yarn && yarn run build');
    }
);

// Hooks

after('deploy:failed', 'deploy:unlock');
after('deploy:vendors', 'deploy:assets');
after('deploy:publish', 'restart:php-fpm');

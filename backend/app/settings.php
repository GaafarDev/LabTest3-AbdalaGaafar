<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true,
                'logError'            => false,
                'logErrorDetails'     => false,
                'db' => [
                    'driver' => 'mysql',
                    'host' => 'localhost',
                    'database' => 'crud_app',
                    'username' => 'root',
                    'password' => '1234',
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
                ],
            ]);
        }
    ]);
};

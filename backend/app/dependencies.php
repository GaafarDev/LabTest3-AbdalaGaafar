<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Application\Settings\SettingsInterface;

return function ($containerBuilder) {
    $containerBuilder->addDefinitions([
        'db' => function ($container) {
            $settings = $container->get(SettingsInterface::class)->get('db');
            $capsule = new Capsule;
            $capsule->addConnection($settings);

            $capsule->setAsGlobal();

            $capsule->bootEloquent();

            return $capsule;
        },
    ]);
};

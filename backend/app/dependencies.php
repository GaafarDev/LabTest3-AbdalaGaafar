<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Application\Settings\SettingsInterface;

return function ($containerBuilder) {
    $containerBuilder->addDefinitions([
        'db' => function ($container) {
            $settings = $container->get(SettingsInterface::class)->get('db');
            $capsule = new Capsule;
            $capsule->addConnection($settings);

            // Make this Capsule instance available globally via static methods... (optional)
            $capsule->setAsGlobal();

            // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
            $capsule->bootEloquent();

            return $capsule;
        },
    ]);
};

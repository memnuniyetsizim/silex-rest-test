<?php

namespace App;

use App\Models\TokenModel;
use App\Models\UserModel;
use Silex\Application;


class ServicesLoader
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bindServicesIntoContainer()
    {
        $this->app['user.model'] = $this->app->share(function () {
            return new UserModel($this->app["db"]);
        });
        $this->app['token.model'] = $this->app->share(function () {
            return new TokenModel($this->app["db"]);
        });
    }
}
<?php

namespace App;


use App\Controllers\HomeController;
use App\Controllers\TokenController;
use App\Controllers\UserController;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RoutesLoader
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->instantiateControllers();
    }

    private function instantiateControllers()
    {
        $this->app['user.controller'] = $this->app->share(function () {
            return new UserController($this->app['user.model'], $this->app['token.model'], $this->app['request']);
        });
        $this->app['home.controller'] = $this->app->share(function () {
            return new HomeController();
        });
        $this->app['token.controller'] = $this->app->share(function () {
            return new TokenController($this->app['token.model']);
        });
    }

    public function bindRoutesToControllers()
    {

        $beforeAuth = function (Request $request) {
            $tokenModel = $this->app['token.model'];
            $token = $request->get('token');

            if (!$tokenModel->check($token)) {
                throw new UnauthorizedHttpException($token, "Unauthorized token: $token!");
            }
        };

        $api = $this->app["controllers_factory"];
        $api->get('/', "home.controller:welcome");
        $api->post('/', "home.controller:welcome");
        $api->put('/', "home.controller:welcome");
        $api->delete('/', "home.controller:welcome");

        $api->get('/login', "token.controller:login");

        $api->get('/user', "user.controller:getAll")->before($beforeAuth);
        $api->post('/user', "user.controller:save")->before($beforeAuth);
        $api->put('/user/{id}', "user.controller:update")->before($beforeAuth);
        $api->delete('/user/{id}', "user.controller:delete")->before($beforeAuth);
        $this->app->mount($this->app["api.endpoint"] . '/' . $this->app["api.version"], $api);
    }
}
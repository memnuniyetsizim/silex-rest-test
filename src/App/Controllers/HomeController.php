<?php

namespace App\Controllers;


use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController
{
    public function welcome()
    {
        return new JsonResponse(['welcome']);
    }
}
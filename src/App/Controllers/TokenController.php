<?php


namespace App\Controllers;

use App\Models\TokenModel;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;



class TokenController
{
    private $tokenModel;

    function __construct(TokenModel $token)
    {
        $this->tokenModel = $token;
    }

    public function login(Request $request) {
        $token = $this->tokenModel->generate();
        return new JsonResponse($token);
    }
}
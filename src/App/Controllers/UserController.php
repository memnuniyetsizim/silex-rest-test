<?php

namespace App\Controllers;

use App\Models\TokenModel;
use App\Models\UserModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    private $userModel;
    private $request;

    function __construct(UserModel $user, TokenModel $tokenModel, Request $request)
    {
        $this->userModel = $user;
        $this->request = $request;
    }

    public function save()
    {
        $username = $this->request->request->get("username");
        $description = $this->request->request->get("description");

        return new JsonResponse($this->userModel->save($username, $description));
    }

    public function update($id)
    {
        $username = $this->request->request->get("username");
        $description = $this->request->request->get("description");

        return new JsonResponse($this->userModel->update($id, $username, $description));
    }

    public function delete($id)
    {
        return new JsonResponse($this->userModel->delete($id));
    }

    public function getAll()
    {
        return new JsonResponse($this->userModel->getAll());
    }
}
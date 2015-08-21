<?php 
$I = new ApiTester($scenario);
$I->wantTo('Delete an user');

$I->sendDELETE('/api/user/1');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();

$I->sendGET('/api/login');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(200);
$loginResponse = $I->grabResponse();

$I->sendPOST('/api/user',
    ['username' => 'test1242', 'description' => 'desc test', 'token' => json_decode($loginResponse)]);
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$userId = $I->grabResponse();

$I->sendDELETE('/api/user/'.json_decode($userId), ['token' => json_decode($loginResponse)]);
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(200);


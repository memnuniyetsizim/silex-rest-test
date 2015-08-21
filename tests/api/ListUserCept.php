<?php 
$I = new ApiTester($scenario);
$I->wantTo('List users');

$I->sendGET('/api/user');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();

$I->sendGET('/api/login');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(200);
$loginResponse = $I->grabResponse();

$I->sendGET('/api/user', ['token' => json_decode($loginResponse)]);
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
<?php 
$I = new ApiTester($scenario);
$I->wantTo('Get token');

$I->sendGET('/api/login');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(200);

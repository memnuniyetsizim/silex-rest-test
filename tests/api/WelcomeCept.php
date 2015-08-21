<?php 
$I = new ApiTester($scenario);
$I->wantTo('Check welcome');

$I->sendGET('/api/');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseIsJson();
$I->seeResponseCodeIs(200);
$I->seeResponseEquals('["welcome"]');
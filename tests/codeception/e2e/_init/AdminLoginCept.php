<?php

// @group mandatory



$I = new E2eTester($scenario);
$I->wantTo('login as admin');

$I->amGoingTo('try to login as admin');
$I->login('admin', 'admin1');

$I->see('admin','#link-user-menu');
$I->makeScreenshot('admin-login-frontend');

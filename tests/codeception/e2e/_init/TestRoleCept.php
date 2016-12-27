<?php

// @group mandatory



$I = new E2eTester($scenario);
$I->wantTo('create a preview RBAC role');



$I->amGoingTo('try to login as admin');
$I->login('admin', 'admin1');

$I->amGoingTo('try to view and create pages');
$I->amOnPage('/rbac/role/create');


$I->fillField('#role-name', uniqid('Test'));
$I->fillField('#role-description', 'Test Role');

$I->click('Save');

$I->wait(2);


$I->see('Test Role', 'td');
<?php

// @group mandatory

$I = new FunctionalTester($scenario);
$I->wantTo('Click backend links');

$I->amGoingTo('start in the backend');
$I->login('admin', 'admin1');
$url = '/backend';
$I->amOnPage($url);

$links = $I->grabMultiple('section.content a[href^="/"]', 'href');

foreach ($links as $i => $url) {

    switch ($url) {
        case '/debug':
        case '/treemanager':
            continue 2;
            break;
    }

    $I->amGoingTo('check '.$url);
    $I->amOnPage($url);

    $I->cantSeeElement('.site-error');
    $I->cantSeeElement('.alert-warning .alert');
}

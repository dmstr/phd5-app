<?php

// @group mandatory

$I = new E2eTester($scenario);

$I->wantTo('ensure that there is no horizontal scrollbar');

$I->amOnPage('/');

$I->assertFalse(
    $I->executeJS("return document.getElementsByTagName(\"html\")[0].scrollWidth > document.getElementsByTagName(\"html\")[0].clientWidth"),
    'Horizontal scrollbar'
);

$I->makeScreenshot('home-no-scrollbars');

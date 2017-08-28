<?php

// @group essential

$I = new CliTester($scenario);

$I->runShellCommand('yii translate/scan');
$I->seeInShellOutput('Detect Twig - BEGIN');
$I->seeShellOutputMatches('/Detected language element(.)/');

$I->runShellCommand('yii translate/optimize');
$I->seeInShellOutput('removed from database.');
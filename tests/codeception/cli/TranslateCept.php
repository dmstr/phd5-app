<?php

// @group essential

$I = new CliTester($scenario);

$I->runShellCommand('yii translate/scan');
$I->seeInShellOutput('Detect PhpFunction - BEGIN');
$I->seeShellOutputMatches('/Detected language element(.)/');
$I->seeShellOutputMatches('/Extracting messages from(.*)twig_template/');

$I->runShellCommand('yii translate/optimize');
$I->seeInShellOutput('removed from database.');
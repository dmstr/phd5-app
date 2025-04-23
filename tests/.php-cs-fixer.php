<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude(['views','tests','web','config', 'migrations'])
    ->in(__DIR__.'/../')
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
    ])
    ->setFinder($finder)
;

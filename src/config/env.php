<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

// Load default settings via dotenv from file, load local environment first, if available
if (is_file(__DIR__.'/../local.env')) {
    $dotenvLocal = new Dotenv\Dotenv(__DIR__.'/..', 'local.env');
    $dotenvLocal->load();
}

// Load application environment configuration
$dotenv = new Dotenv\Dotenv(__DIR__.'/..', 'app.env');
$dotenv->load();

// Basic checks & validation
$dotenv->required('YII_DEBUG', ['', '0', '1', 'true', true]);
$dotenv->required('YII_ENV', ['dev', 'prod', 'test']);
$dotenv->required([
    'YII_TRACE_LEVEL',
    'APP_NAME',
    'APP_LANGUAGES',
    'APP_COOKIE_VALIDATION_KEY',
]);

// Additional validations
if (!preg_match('/^[a-z0-9_-]{2,16}$/', getenv('APP_NAME'))) {
    throw new \Dotenv\Exception\ValidationException(
        'APP_NAME must only be lowercase, dash or underscore and 2-16 characters long.'
    );
}
if (!preg_match('/([a-z]{2}(-[A-Z]{2})?),?/', getenv('APP_LANGUAGES'))) {
    throw new \Dotenv\Exception\ValidationException(
        'APP_LANGUAGES must be comma separated list of language identifiers.'
    );
}

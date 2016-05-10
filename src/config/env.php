<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Version check
$version = is_file(__DIR__.'/../version') ? file_get_contents(__DIR__.'/../version') : 'dev';
defined('APP_VERSION') or define('APP_VERSION', $version);

// Load default settings via dotenv from file
$dotenv = new Dotenv\Dotenv(__DIR__.'/..', 'app.env');
$dotenv->load();

// Checks & validation
$dotenv->required('YII_DEBUG', ['', '0', '1', 'true', true]);
$dotenv->required('YII_ENV', ['dev', 'prod', 'test']);
$dotenv->required([
    'YII_TRACE_LEVEL',
    'APP_NAME',
    'APP_COOKIE_VALIDATION_KEY',
]);

// Additional Validations
if (!preg_match('/^[a-z0-9_-]{3,16}$/', getenv('APP_NAME'))) {
    throw new \Dotenv\Exception\ValidationException(
        'APP_NAME must only be lowercase, dash or underscore and 3-16 characters long.'
    );
}

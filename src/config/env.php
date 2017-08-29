<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

$srcPath = __DIR__.'/..';

// Load default settings via dotenv from file, load local environment first, if available
if (getenv('ENV_LOCAL_FILE')) {
    if (is_file($srcPath.'/'.getenv('ENV_LOCAL_FILE'))) {
        $dotenvLocal = new Dotenv\Dotenv($srcPath, getenv('ENV_LOCAL_FILE'));
        $dotenvLocal->load();
    } else {
        exit('ENV_LOCAL_FILE not found');
    }
}

// Load application environment configuration
$dotenv = new Dotenv\Dotenv($srcPath, 'app.env');
$dotenv->load();

// Basic checks & validation
$dotenv->required('YII_DEBUG', ['', '0', '1', 'true', true]);
$dotenv->required('YII_ENV', ['dev', 'prod', 'test']);
$dotenv->required([
    'YII_TRACE_LEVEL',
    'APP_NAME',
    'APP_TITLE',
    'APP_ADMIN_EMAIL',
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

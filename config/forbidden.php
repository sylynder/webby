<?php

/**
 * A list of forbidden routes 
 */
$config['forbidden_routes'] = [
    '.git',
    '.env',
    'env',
    'wp-admin',
    'wp-login',
    'wp-login.php',
    'wp-admin.php',
    'composer.lock',
    'yarn.lock',
    'package-lock.json',
    'xmlrpc.php',
    'typo3',
];

/**
 * A default route to use
 */
$config['default_outside_route'] = 'app/outside';

/**
 * The outside url to route to 
 */
$config['send_to_outside'] = 'https://google.com';

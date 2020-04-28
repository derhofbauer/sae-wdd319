<?php

/**
 * [x] Bootstrap file laden & anstarten
 * [x] Autoloader starten
 */

spl_autoload_register(function ($namespaceAndClassname) {
    // Core\Bootstrap => core/Bootstrap.php
    // App\Models\User => app/Models/User.php
    $namespaceAndClassname = str_replace('Core', 'core', $namespaceAndClassname);
    $namespaceAndClassname = str_replace('App', 'app', $namespaceAndClassname);
    $filepath = str_replace('\\', '/', $namespaceAndClassname);

    require_once __DIR__ . "/{$filepath}.php";
});

$app = new \Core\Bootstrap();

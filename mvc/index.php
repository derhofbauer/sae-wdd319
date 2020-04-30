<?php

/**
 * [x] Bootstrap file laden & anstarten
 * [x] Autoloader starten
 */

/**
 * spl_autoload_register Funktion akzeptiert einen Parameter, eine Funktion. Diese Funktion wird aufgerufen, wenn eine
 * Klasse verwendet werden soll, die noch nicht importiert wurde. Diese Funktion erhält den kompletten Klassennamen
 * inkl. Namespace übergeben.
 */
spl_autoload_register(function ($namespaceAndClassname) {
    /**
     * Hier versuchen wir den Namespace in einen validen Dateipfad umzuwandeln. Daher ist es wichtig, dass der
     * Klassenname und der Dateiname ident sind.
     *
     * z.B.:
     * + Core\Bootstrap => core/Bootstrap.php
     * + App\Models\User => app/Models/User.php
     */
    $namespaceAndClassname = str_replace('Core', 'core', $namespaceAndClassname);
    $namespaceAndClassname = str_replace('App', 'app', $namespaceAndClassname);
    $filepath = str_replace('\\', '/', $namespaceAndClassname);

    require_once __DIR__ . "/{$filepath}.php";
});

/**
 * MVC "anstarten"
 */
$app = new \Core\Bootstrap();

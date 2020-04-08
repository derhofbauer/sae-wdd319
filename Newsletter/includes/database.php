<?php

/**
 * In der config/db.php trägt die Config-Variable einen relativ allgemeinen Namen, der leicht überschrieben werden
 * würde. Daher öffnen wir durch diese anonyme Funktion eine neuen Scope und importieren in diesem Scope die
 * $db-Variable.
 */
$link = function () {
    require_once __DIR__ . '/../config/db.php';

    return mysqli_connect($db['host'], $db['username'], $db['password'], $db['dbname'], $db['port']);
};
$link = $link();

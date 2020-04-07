<?php

/**
 * Wir lagern $countries von der index.php in ein eigenes File aus, damit wir es sowohl in der index.php für die
 * Generierung des Dropdowns verwenden können, als auch in der validate.php, um zu prüfen, ob der Wert, den wir aus dem
 * Formular erhalten haben für das countries-Dropdown, tatsächlich auch ein erlaubter Wert ist und nicht jemand uns
 * bspw. über die DevTools einen falschen Wert unterjubeln möchte.
 *
 * Es kann beispielsweise zu MySQL-Injections kommen, wenn wir den Wert aus Dropdowns nicht auch validieren und prüfen
 * ob der Wert, den wir aus dem Formular bekommen haben, erlaubt ist.
 */
return [
    'AT' => 'Österreich',
    'S' => 'Schweiz',
    'D' => 'Deutschland',
    'L' => 'Liechtenstein'
];

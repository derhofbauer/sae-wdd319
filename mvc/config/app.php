<?php

/**
 * Die baseUrl brauchen wir, damit wir den <base>-Tag im HTML Head setzen können und alle relativen URLs von diesem Pfad
 * aus berechnet werden. Wenn die Anwendung in den Produktivbetrieb überführt wird, dann ändert sich die URL, unter der
 * sie erreichbar ist.
 */
return [
    'baseUrl' => 'http://localhost:8080/mvc/' // bei euch (vermutlich): http://localhost:8888/mvc/
];

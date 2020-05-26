<h1>404 Not Found</h1>

<div>
    <?php

    /**
     * Die 404 Fehlermeldung soll dynamisch gesetzt werden können. Das hiert ist der Standardwert.
     */
    $_message = "Oh no :( This page does not exists.";

    /**
     * Wenn der Controller, in dem der 404 View geladen wird, eine 'message' übergibt, überschreibt sie die standard
     * Fehlermeldung.
     */
    if (isset($message)) {
        $_message = $message;
    }

    /**
     * Zum Schluss geben wir die Fehlermeldung aus.
     */
    echo $_message;

    ?>
</div>

<?php

/**
 * Wenn Code mehr als einmal mehr oder weniger ident verwendet wird, dann sollte dieser Code nach Möglichkeit in eine
 * Funktion ausgelagert werden. Wenn sich einzelne Werte in diesem Code verändern, die Befehle aber die selben sind,
 * können Funktionsparameter verwendet werden. Funktionen haben den Vorteil, dass Code einfach wiederverwendet werden
 * und zentral verändert werden kann.
 */

/**
 * Prüfen, ob ein User eingeloggt ist
 *
 * @return bool
 */
function isLoggedIn ()
{
    /**
     * Wir könnten hier die gesamte logische Aussage (Expression) auch in einen if-else Block erweitern, aber nachdem
     * wir auch dann nur true und false zurück geben würden, können wir auch einfach gleich den Wahrheitswert der
     * Expression zurückgeben.
     */
    return (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true);
}

/**
 * @param string $redirect
 */
function redirectIfNotLoggedIn ($redirect = 'index.php')
{
    if (isLoggedIn() === false) {
        header("Location: $redirect");
        exit;
    }
}

<?php
/**
 * URL über GET erhalten
 * URL in die Session eintragen
 * Redirect zur URL
 */

/**
 * Prüfen, ob eine URL übergeben wurde
 */
if (isset($_GET['url'])) {
    /**
     * `urldecode()` "entschlüsselt" eine URL, die mit `urlencode` "verschlüsselt" wurde. Dadurch können wir Zeichen,
     * die in URLs eine besondere Bedeutung haben, beispielsweise : oder /, so maskieren, dass sie in URLs problemlos
     * übertragen werden können.
     */
    $url = urldecode($_GET['url']);

    /**
     * Session starten
     */
    session_start();

    /**
     * URL validieren
     *
     * Die Funktion `filter_var()` filter Werte anhang gewisser Filter-Konstanten und gibt false zurück, wenn die
     * Variable nicht auf den Filter zutrifft.
     */
    if (filter_var($url, FILTER_VALIDATE_URL) !== false) {

        /**
         * Klick-Status in die Session schreiben
         */
        $_SESSION['url-tracker'][$url] = true;

        /**
         * Klick-COunt in die Session schreiben
         */
        if (!isset($_SESSION['url-counter'][$url])) {
            $_SESSION['url-counter'][$url] = 1;
        } else {
            $_SESSION['url-counter'][$url] += 1;
        }

        /**
         * Redirect
         */
        header("Location: $url");

    } else {
        echo "Bitte verwende eine valide URL";
    }
}
?>

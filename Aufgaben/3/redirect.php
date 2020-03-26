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
    $url = urldecode($_GET['url']);

    /**
     * Session starten
     */
    session_start();

    /**
     * URL validieren
     */
    if (filter_var($url, FILTER_VALIDATE_URL) !== false) {

        /**
         * Klick-Status in die Session schreiben
         */
        $_SESSION['url-tracker'][$url] = true;

        /**
         * Redirect
         */
        header("Location: $url");

    } else {
        echo "Bitte verwende eine valide URL";
    }
}
?>

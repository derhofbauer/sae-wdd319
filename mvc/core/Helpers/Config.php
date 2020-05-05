<?php

namespace Core\Helpers;

class Config
{

    /**
     * @param string $configString z.b. "database.host"
     * @param null   $default
     *
     * @return mixed
     */
    public static function get ($configString = '', $default = null)
    {
        /**
         * Der $configString muss mindestens 3 Zeichen haben, 1 Zeichen Dateiname, 1 Punkt als Trenner und 1 Zeichen für
         * den Namen der Konfigurationsoption.
         */
        if (strlen($configString) >= 3) {
            /**
             * Dateiname und Config-Key aus dem $configString auslesen
             */
            $filename = explode('.', $configString)[0];
            $key = explode('.', $configString)[1];

            /**
             * Config file dynamisch laden
             */
            $config = require __DIR__ . "/../../config/$filename.php";

            /**
             * Wenn der Config-Key in dem entsprechenden File existiert, dann geben wir den Wert davon zurück, sonst
             * geben wir den Wert von $default zurück.
             */
            if (array_key_exists($key, $config)) {
                return $config[$key];
            } else {
                return $default;
            }
        }
    }

}

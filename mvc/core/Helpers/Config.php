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
        if (strlen($configString) >= 3) {
            $filename = explode('.', $configString)[0];
            $key = explode('.', $configString)[1];

            /**
             * Config file dynamisch laden
             */
            $config = require __DIR__ . "/../../config/$filename.php";

            if (array_key_exists($key, $config)) {
                return $config[$key];
            } else {
                return $default;
            }
        }
    }

}

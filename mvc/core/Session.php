<?php

namespace Core;

class Session
{
    const LOGGED_IN_KEY = 'logged_in';
    const LOGGED_IN_ID = 'logged_in_user_id';

    /**
     * Sesstion starten
     */
    public static function init ()
    {
        session_start();
    }

    /**
     * Wert in die Session schreiben
     *
     * @param $key
     * @param $value
     */
    public static function set ($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Wert aus der Session abfragen
     *
     * @param      $key
     * @param null $default
     * @param bool $forgetAfterReturn
     *
     * @return mixed|null
     */
    public static function get ($key, $default = null, $forgetAfterReturn = false)
    {
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];

            /**
             * Der $forgetAfterReturn Parameter dient dazu, dass Werte aus der Session gelöscht werden können, wenn sie
             * einmal zurückgegeben wurden. Das bietet sich für sog. Flash Messages sehr gut an. Fehlermeldungen oder
             * Erfolgsmeldungen bspw. sollen nur von einer Action zur anderen über einen Redirect hinweg übergeben werden.
             * Normalerweise wäre nach einem Redirect jegliche Information aus dem PHP Script weg, durch Sessions können
             * Daten aber persistent gespeichert werden. Login Infors sollten dauerhaft gespeichert werden, manchmal,
             * eben bei Fehlermeldungen, möchte man aber Daten nur für bis zur nächsten Ausgabe oder für den nächsten
             * Request speichern.
             */
            if ($forgetAfterReturn === true) {
                self::forget($key);
            }

            return $value;
        }
        return $default;
    }

    /**
     * Wert in der Session löschen
     *
     * @param $key
     */
    public static function forget ($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Gesamte Session löschen
     */
    public static function destroy ()
    {
        session_destroy();
    }
}

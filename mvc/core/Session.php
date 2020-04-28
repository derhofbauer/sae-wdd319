<?php

namespace Core;

class Session
{
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
     *
     * @return mixed|null
     */
    public static function get ($key, $default = null)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
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

<?php

namespace Core;

class View
{

    /**
     * Diese Methode erlaubt es uns innerhalb der Controller der App (s. HomeController), einen View in nur einer
     * einzigen Zeile zu laden und auch Parameter an den View zu übergeben. Die View Parameter dienen dazu, dass Werte,
     * die in den Controllern berechnert wurden, an den View zur Darstellung übergeben werden können.
     *
     * Aufruf: View::load('ProductSingle', $productValues)
     *
     * @param string $view
     * @param array  $params
     * @param string $layout
     */
    public static function load (string $view, array $params = [], string $layout = 'main')
    {
        /**
         * extract() erstellt aus jedem Wert in einem Array eine eigene Variable. Das brauchen wir aber nur zu tun, wenn
         * überhaupt $params vorhanden sind.
         */
        if (count($params) >= 1) {
            extract($params);
        }

        /**
         * View Path vorbereiten, damit im Layout file der View geladen werden kann
         */
        $viewPath = __DIR__ . "/../resources/views/$view.view.php";

        /**
         * Hier laden wir das View-File anhand des $view Funktionsparameters.
         */
        require_once __DIR__ . "/../resources/views/layouts/$layout.php";
    }

}

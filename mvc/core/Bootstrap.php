<?php

namespace Core;

class Bootstrap
{
    private $routes = [];

    public function __construct ()
    {
        /**
         * [x] Routing starten
         * [x] Session starten
         * [x] Datenbankverbindung herstellen
         */
        \Core\Session::init();

        $this->routes = $this->getPreparedRoutes();
        $this->getControllerAndAction();
    }

    /**
     * Routen laden
     *
     * @return mixed
     */
    private function getPreparedRoutes ()
    {
        return require_once __DIR__ . '/../app/routes.php';
    }

    private function getControllerAndAction ()
    {
        /**
         * $_GET['path'] so umformen, dass immer ein führendes Slash dran steht unten am Ende keines.
         */
        $path = '';
        if (isset($_GET['path'])) {
            $path = $_GET['path'];
        }
        /**
         * `rtrim()` entfernt eine Liste an Zeichen vom Ende eines Strings.
         *
         * Wenn kein Pfad übergeben wurde, ist unsere Standarroute "/"
         */
        $path = "/" . rtrim($path, '/');

        /**
         * Variablen initialisieren, damit wir sie später befüllen können
         */
        $controller = '';
        $action = '';
        $params = [];

        /**
         * Prüfen, ob der angefragte Pfad als Route in unserer routes.php vorkommt oder nicht
         */
        if (array_key_exists($path, $this->routes)) {
            /**
             * Path existiert 1:1 so in unserem Routes Array, weil die Route keinen Parameter akzeptiert
             */

            /**
             * Abfragen des zugehörigen "Controller.action" Strings zur angefragten Route
             */
            $controllerAndAction = $this->routes[$path];

            /**
             * Aufspalten des oben angefragten "Controller.action" Strings in Controller und Action
             */
            $controller = explode('.', $controllerAndAction)[0];
            $action = explode('.', $controllerAndAction)[1];

        } else {

            /**
             * Wir müssen schauen, ob die Route möglicherweise einen Parameter beinhaltet
             *
             * Dazu gehen wir alle Routen durch.
             */
            foreach ($this->routes as $route => $controllerAndAction) {

                /**
                 * Wenn eine Route eine geschwungene Klammer beinhaltet, gibt es einen Parameter und wir formen sie in
                 * eine valide Regular Expression um. Wenn Sie keine geschwungene Klammer beinhaltet, dann wurde sie im
                 * oben stehenden `if` bereits abgedeckt und braucht nicht umgeformt zu werden.
                 */
                if (strpos($route, '{') !== false) {

                    /**
                     * Route mit Parameter in Regular Expression umformen:
                     * - Slashes escapen (/ => \/)
                     * - {param] mit einer Capture Group ersetzen
                     * - Anfang und Ende des String setzen
                     */
                    $regex = str_replace('/', '\/', $route);
                    $regex = preg_replace('/\{[a-zA-Z]+\}/', '([^\/]+)', $regex);
                    $regex = "/^{$regex}$/";

                    /**
                     * Wird die einzelnen Treffer der Regular Expression beinhalten
                     *
                     * s. https://www.php.net/manual/en/function.preg-match-all.php
                     */
                    $matches = [];

                    /**
                     * Hier prüfen wir, ob der angefragte Pfad auf die Route im aktuellen Schleifendurchlauf zutrifft.
                     *
                     * preg_match_all() gibt bei einem Treffer 1 zurück.
                     */
                    if (preg_match_all($regex, $path, $matches) === 1) {

                        /**
                         * "Controller.action" kommt diesmal aus der `foreach`-Schleife. Wir spalten es hier daher nur
                         * wieder genauso wie oben auf.
                         */
                        $controller = explode('.', $controllerAndAction)[0];
                        $action = explode('.', $controllerAndAction)[1];

                        /**
                         * Ersten Treffer der Regular Expression weg werfen, weil das der Gesamttreffer ist
                         *
                         * s. https://www.php.net/manual/en/function.preg-match-all.php
                         * s. https://www.php.net/manual/en/function.array-shift.php
                         */
                        array_shift($matches);

                        /**
                         * Jeder weitere Treffer wird so umgeformt, dass wir ein Array haben in dem die Werte der
                         * {params} in der Reihenfolge ihres Vorkommens in der URL angeordnet sind.
                         *
                         * `array_map()` führt dabei eine Funktion auf jedes Element in dem angegebenen Array aus.
                         *
                         * s. https://www.php.net/manual/en/function.array-map.php
                         */
                        $params = array_map(function ($captureGroupMatch) {
                            /**
                             * `preg_match_all()` erzeugt ein sehr seltsames mehrdimensionales Array, wir wollen aber
                             * immer nur ein bestimmes Element in der zweiten Ebene des Arrays.
                             *
                             * Das Array wird mehrdimensdional definiert, weil potenziell mehrer Strings gleichzeitig
                             * geprüft werden können.
                             */
                            return $captureGroupMatch[0];
                        }, $matches);

                        /**
                         * Zu diesem Zeitpunkt wurde ein Treffer in den Routen gefunden und Controller, Action und
                         * Parameter aufgelöst. `break` beendet nun die aktuelle Schleife, weil wir nur einen Treffer
                         * brauchen.
                         *
                         *  s. https://www.php.net/manual/en/control-structures.break.php
                         */
                        break;
                    }
                }
            }
        }

        /**
         * Wenn kein Controller gefunden wurde, zeigen wir das an. Eigentlich sollten wir hier eine 404 Seite laden.
         */
        if ($controller === '') {
            exit('404 Seite - @todo: hübsche 404 Seite bauen ;)');
        } else {
            /**
             * Wenn oben ein Controller gefunden wurde, dann erstellen wir nun den vollständigen Namen der Klasse mit
             * dem Namespace.
             */
            $classAndNamespace = "App\\Controllers\\$controller";

            /**
             * Instanzieren (erzeugen) eines Controller Objects
             */
            $controller = new $classAndNamespace();

            /**
             * Aufrufen der Methode $action aus dem Objekt $controller mit den Funktionsparametern $params.
             * Wir verwenden call_user_func_array, weil die Methode $action mit einer dynamischen Anzahl an Parametern
             * aufrufen müssen.
             *
             * s. https://www.php.net/manual/en/function.call-user-func-array.php
             */
            call_user_func_array([$controller, $action], $params); // $contoller->$action($params[0], $params[1], ...)
        }

    }
}

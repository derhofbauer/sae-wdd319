<?php

namespace Core;

use Core\Helpers\Config;

class Database
{
    private $link;
    private $stmt;

    public function __construct ()
    {
        /**
         * Datenbankverbindung aufbauen
         */
        $this->link = new \mysqli(
            Config::get('database.host'),
            Config::get('database.username'),
            Config::get('database.password'),
            Config::get('database.dbname'),
            Config::get('database.port', 3306)
        );

        /**
         * Charset für dei Daten setzen. Umlaute und sprachspezifische Sonderzeichen werden so relativ problemlos
         * gespeichert und übertragen.
         */
        $this->link->set_charset('utf8');
    }

    public function __destruct ()
    {
        $this->link->close();
    }

    /**
     * Aufruf: $db->query("SELECT * FROM users WHERE id = ? AND deleted = ?", ['i:id' => 1, 'i:deleted' => 0]);
     *
     * @param string $sql
     * @param array  $params
     */
    public function query (string $sql, array $params = [])
    {
        /**
         * Prepared Statement initialisieren
         */
        $this->stmt = $this->link->prepare($sql);

        if (count($params) >= 1) {
            /**
             * Variablen vorbereiten
             */
            $paramTypes = [];
            $paramValues = [];

            /**
             * Funktionsparameter $params durchgehen und die obenstehenden Variablen befüllen.
             */
            foreach ($params as $key => $value) {
                $paramTypes[] = explode(':', $key)[0];

                /**
                 * $stmt->bind_param() erwartet eine Referenz als Werte und nicht eine normale Variable, daher müssen
                 * wir in unseren $paramValues Array Referenzen pushen. Das ist eine seltsame aber begründete Eigenheit
                 * von bind_param().
                 */
                unset($_value);
                $_value = $value;
                $paramValues[] = &$_value;
                /**
                 * $paramTypes:  ['i', 'i']
                 * $paramValues: [&1, &0]
                 */
            }
            /**
             * $stmt->bind_param() verlangt als ersten Parameter einen String mit den Typen aller folgenden Parameter.
             * Wir müssen also aus dem Array $paramTypes einen String erstellen.
             */
            $paramString = implode('', $paramTypes); // ii

            /**
             * Gemeinsames Array aus $paramString und $paramValues erstellen, weil $stmt->bind_param() als ersten
             * Parameter einen String aller Typen und als folgende Parameter die einzelnen Werte erwartet.
             *
             * s. https://www.php.net/manual/en/mysqli-stmt.bind-param.php
             */
            array_unshift($paramValues, $paramString);

            /**
             * Query fertig "preparen": $stmt->bind_param() mit den entsprechenden Werten ausführen; aber nur, wenn es
             * sich um einen MySQL Query mit Parametern handelt (s. if-Statement).
             */
            call_user_func_array([$this->stmt, 'bind_param'], $paramValues);
        }

        /**
         * Query an den MySQL Server schicken.
         */
        $this->stmt->execute();

        /**
         * Ergebnis aus dem Query holen.
         */
        $result = $this->stmt->get_result();

        /**
         * Das Ergebnis ist idR. nur dann ein bool'scher Wert, wenn ein Fehler auftritt oder ein Query ohne Ergebnis
         * ausgeführt wird.
         */
        if (is_bool($result)) {
            return $result;
        }

        /**
         * Tritt kein Fehler auf, erstellen wir ein assoziatives Array und geben es zurück.
         */
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * $this->link ist private, damit nur die Database Klasse selbst diese Property verändern kann. Es kann aber
     * passieren, dass wir Funktionalitäten des \mysqli Objekts außerhalb der Database Klasse brauchen, daher bieten
     * wir für unsere Framework Anwender*innen hier die Möglichkeit sich das \mysqli Objekt aus der Database Klasse
     * abzurufen. Eine Veränderung des Rückgabewerts von $this->getLink() verändert aber nicht $this->link, wodurch
     * $this->link weiterhin nur von der Database Klasse selbst veränderbar ist.
     *
     * @return \mysqli
     */
    public function getLink ()
    {
        return $this->link;
    }

    /**
     * Gibt die von MySQL generierte ID aus dem letzten INSERT Query zurück. War der letzte Query kein INSERT Query,
     * wird 0 zurück gegeben.
     *
     * s. https://www.php.net/mysqli.insert_id
     *
     * @return mixed
     */
    public function getInsertId ()
    {
        /**
         * $this->link ist ein \mysqli Objekt und hat daher eine insert_id Property. $mysqli->insert_id beinhaltet also
         * die ID, die bei einem INSERT Query von MySQL generiert wurde.
         */
        return $this->link->insert_id;
    }

}

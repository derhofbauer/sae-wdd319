<?php

namespace App\Models;

use Core\Database;
use Core\Models\ModelTrait;

class Address
{
    /**
     * Wir verwenden ein paar grundlegende Methoden aus dem MVC Core, die jedes Model brauchen kann, aber nicht
     * verwenden muss.
     */
    use ModelTrait;

    /**
     * Damit die Methoden aus dem ModelTrait funktionieren, müssen wir angeben, auf welche Tabelle sich diese Klasse
     * bezieht.
     *
     * @var string
     */
    public static $tableName = 'addresses';

    /**
     * Wir definieren alle Spalten aus der Tabelle. Hier initialisieren wir die Variablen auch mit den entsprechenden
     * Datentypen, das ist aber nicht nötig.
     */
    public $id = 0;
    public $user_id = 0;
    public $address = '';

    /**
     * Die fill-Methode soll uns helfen, alle Properties der Klasse möglichst einfach und schnell aus einem Datenbank-
     * Ergebniss befüllen zu können.
     *
     * @param array $data
     */
    public function fill (array $data = [])
    {
        $this->id = $data['id'];
        $this->user_id = $data['user_id'];
        $this->address = $data['address'];
    }

    /**
     * Die save-Methode soll uns helfen, geänderte Daten in die Datenbank zu speichern oder eine neue Zeile in der
     * Datenbank anzulegen, je nachdem, ob das aktuelle Objekt bereits existiert in der Datenbank oder nicht.
     */
    public function save ()
    {
        /**
         * Neue Datenbankverbindung herstellen
         */
        $db = new Database();

        /**
         * Wenn die Adresse schon eine ID hat und somit in der Datenbank bereits existiert, dann aktualisieren wir es
         * mit einem UPDATE Query, andernfalls legen wir mit einem INSERT Query eine neue Adresse an.
         */
        if ($this->id > 0) {
            $result = $db->query('UPDATE ' . self::$tableName . ' SET user_id = ?, address = ? WHERE id = ?', [
                'i:user_id' => $this->user_id,
                's:address' => $this->address,
                'i:id' => $this->id
            ]);
        } else {
            $result = $db->query('INSERT INTO ' . self::$tableName . ' SET user_id = ?, address = ?', [
                'i:user_id' => $this->user_id,
                's:address' => $this->address
            ]);
            /**
             * Bei einem INSERT Query wird von MySQL eine neue ID generiert (sofern eine AUTO_INCREMENT Spalte
             * existiert). Diese ID lesen wir hier aus und setzen sie ins aktuelle Objekt.
             */
            $this->id = $db->getInsertId();
        }

        /**
         * Ergebnis zurückgeben, damit wir in den Controllern, wo wir die save() Methode verwenden, prüfen können, ob
         * der Query erfolgreich war oder nicht. MySQL gibt nämlich im Erfolgsfall true zurück, im Fehlerfall false.
         */
        return $result;
    }
}

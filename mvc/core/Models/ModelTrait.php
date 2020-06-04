<?php

namespace Core\Models;

use Core\Database;

/**
 * Ein Trait ist eine Sammlung von Methoden, die in mehreren Klassen verwendet werden können.
 * s. https://www.php.net/manual/en/language.oop5.traits.php
 *
 * Wir stellen den Anwender*innen unseres MVC Frameworks ein Trait bereit, dass grundlegende aber praktische Methoden
 * für Models bereitstellt. Dieses Trait muss nicht verwendet werden, genauso müssen nicht alle Methoden aus dem Trait
 * in der App verwendet werden, aber sie sind praktisch und die Funktionalitäten, die über die Methoden in dem Trait
 * abgebildet werden, werden mit sehr hoher Wahrscheinlichkeit in den meisten Models benötigt werden.
 */
trait ModelTrait
{
    /**
     * Der Konstruktor bietet uns die Möglichkeit ein Objekt direkt bei der Erstellung zu befüllen.
     *
     * @param array $data
     */
    public function __construct (array $data = [])
    {
        if (count($data) > 0 && method_exists($this, 'fill')) {
            $this->fill($data);
        }
    }

    /**
     * Die all-Methode gibt alle Datensätze aus einer bestimmten Tabelle zurück. Wichtig dabei ist, dass die Klasse, die
     * dieses Trait verwendet, eine statische Eigenschaft $tableName haben muss, da die Methode sonst nicht weiß, aus
     * welcher Tabelle alle Datensätze abgefragt werden sollen.
     *
     * @return array
     */
    public static function all ()
    {
        /**
         * Datenbankverbindung herstellen über die Core/Database.php Klasse
         */
        $db = new Database();

        /**
         * Alias für die in der Klasse definierte static property $tableName
         */
        $tableName = self::$tableName;

        /**
         * Query definieren, im Hintergrund (Database-Klasse) in ein Prepared Statement umformen und abschicken.
         * Unterstützt das Model, in dem der ModelTrait verwendet wird, Soft Deletes, so werden hier alle nicht
         * gelöschten Datensätze geladen. Ein Datensatz ist dann gelöscht, wenn die is_deleted Spalte in der Datenbank
         * 1 ist. Werden Soft Deletes nicht unterstützt, so werden alle Datensätze geladen, weil gelöschte Datensätze
         * auch tatsächlich einfach weg sind.
         */
        if (property_exists(self::class, 'softDelete') && self::$softDelete === true) {
            $result = $db->query("SELECT * FROM $tableName WHERE is_deleted IS NOT TRUE");
        } else {
            $result = $db->query("SELECT * FROM $tableName");
        }

        /**
         * Hier gehen wir alle Ergebnisse des Query's durch und erstellen ein neues Objekt aus jeder Zeile und befüllen
         * die Objekte durch die im Konstruktor aufgerufene fill-Methode, die in der Klasse definiert werden muss, die
         * dieses Trait verwendet.
         */
        $data = [];
        foreach ($result as $resultItem) {
            $date = new self($resultItem);
            $data[] = $date;
        }

        /**
         * Array an Objekten zurückgeben, die die Werte aus dem Query beinhalten
         */
        return $data;
    }

    /**
     * Die find-Methode soll uns helfen einen einzelnen Datensatz anhand der ID aus der Datenbank auszulesen. Wie auch
     * für die all-Methode muss $tableName von der Klasse definiert werden.
     *
     * Für weitere Erklärungen s. ModelTrait::all()
     *
     * @param int $id
     *
     * @return object
     */
    public static function find (int $id)
    {
        $db = new Database();

        $tableName = self::$tableName;
        $result = $db->query("SELECT * FROM {$tableName} WHERE id = ?", [
            'i:id' => $id
        ]);

        /**
         * Das Resultat eines SELECT-Query's ist immer ein Array an Ergebnissen. Hier haben wir aber nur ein Ergebnis,
         * da der Primary Key id eindeutig ist. Wir haben also maximal ein Ergebnis und kriegen daher ein Array mit 0
         * oder einem Ergebnis zurück und können daher direkt die erste Stelle davon verwenden ohne in einer Schleife
         * alles durchzugehen.
         */
        $data = new self($result[0]);

        return $data;
    }

    /**
     * Datensatz aus der Datenbank löschen.
     *
     * @param int $id
     *
     * @return bool|mixed
     */
    public static function delete (int $id)
    {
        $db = new Database();

        $tableName = self::$tableName;

        /**
         * Unterstützt das Model, in dem der ModelTrait verwendet wird, Soft Deletes, so wird der Datensatz nicht
         * gelöscht sondern lediglich is_deleted auf 1 gesetzt. Andernfalls wird der Datensatz unwiederbringlich
         * gelöscht.
         */
        if (property_exists(self::class, 'softDelete') && self::$softDelete === true) {
            $result = $db->query("UPDATE {$tableName} SET is_deleted = 1 WHERE id = ?", [
                'i:id' => $id
            ]);
        } else {
            $result = $db->query("DELETE FROM {$tableName} WHERE id = ?", [
                'i:id' => $id
            ]);
        }

        return $result;
    }

}

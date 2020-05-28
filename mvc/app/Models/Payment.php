<?php

namespace App\Models;

use Core\Database;
use Core\Models\ModelTrait;

class Payment
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
    public static $tableName = 'payments';

    /**
     * Wir definieren alle Spalten aus der Tabelle. Hier initialisieren wir die Variablen auch mit den entsprechenden
     * Datentypen, das ist aber nicht nötig.
     */
    public $id = 0;
    public $user_id = 0;
    public $name = '';
    public $number = 0;
    public $expires = '';
    public $ccv = 0;

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
        $this->name = $data['name'];
        $this->number = $data['number'];
        $this->expires = $data['expires'];
        $this->ccv = $data['ccv'];
    }

    /**
     * Die save-Methode soll uns helfen, geänderte Daten in die Datenbank zu speichern oder eine neue Zeile in der
     * Datenbank anzulegen, je nachdem, ob das aktuelle Objekt bereits existiert in der Datenbank oder nicht.
     */
    public function save ()
    {
        $db = new Database();

        if ($this->id > 0) {
            $result = $db->query('UPDATE ' . self::$tableName . ' SET name = ?, number = ?, expires = ?, ccv = ?, user_id = ? WHERE id = ?', [
                's:name' => $this->name,
                's:number' => $this->number,
                's:expires' => $this->expires,
                'i:ccv' => $this->ccv,
                'i:user_id' => $this->user_id,
                'i:id' => $this->id
            ]);
        } else {
            $result = $db->query('INSERT INTO ' . self::$tableName . ' SET name = ?, number = ?, expires = ?, ccv = ?, user_id = ?', [
                's:name' => $this->name,
                's:number' => $this->number,
                's:expires' => $this->expires,
                'i:ccv' => $this->ccv,
                'i:user_id' => $this->user_id,
            ]);
            $this->id = $db->getInsertId();
        }

        return $result;
    }

    /**
     * Methode, die im ModelTrait nicht implementiert ist, weil sie einen Use-Case abdeckt, der nicht allgemein genug
     * ist. Wir möchten Zahlungsmethoden nämlich auch für nur einen einzigen User finden können. Diese Methode ist von
     * der Logik her eine Mischung zwischen den Methoden all() und find(). Erklärungen können daher im ModelTrait bei
     * den entsprechenden Methoden gefunden werden.
     *
     * @param int $userId
     *
     * @return array
     */
    public static function findByUser (int $userId)
    {
        $db = new Database();

        $tableName = self::$tableName;
        $result = $db->query("SELECT * FROM {$tableName} WHERE user_id = ?", [
            'i:user_id' => $userId
        ]);

        $data = [];
        foreach ($result as $resultItem) {
            $date = new self($resultItem);
            $data[] = $date;
        }

        return $data;
    }
}

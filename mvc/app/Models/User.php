<?php

namespace App\Models;

use Core\Database;
use Core\Models\BaseUser;
use Core\Models\ModelTrait;

/**
 * Für Erklärungen s. app/Models/Product.php
 */
class User
{
    use ModelTrait;
    use BaseUser;

    public static $tableName = 'users';

    public $id = 0;
    public $firstname = '';
    public $lastname = '';
    public $email = '';
    protected $password = '';
    public $is_admin = false;

    public function fill (array $data = [])
    {
        $this->id = $data['id'];
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->is_admin = (bool)$data['is_admin'];
    }

    /**
     * Die save-Methode soll uns helfen, geänderte Daten in die Datenbank zu speichern oder eine neue Zeile in der
     * Datenbank anzulegen, je nachdem, ob das aktuelle Objekt bereits existiert in der Datenbank oder nicht.
     */
    public function save ()
    {
        $db = new Database();

        if ($this->id > 0) {
            $result = $db->query('UPDATE ' . self::$tableName . ' SET firstname = ?, lastname = ?, email = ?, password = ?, is_admin = ? WHERE id = ?', [
                's:firstname' => $this->firstname,
                's:lastname' => $this->lastname,
                's:email' => $this->email,
                's:password' => $this->password,
                'i:is_admin' => $this->is_admin,
                'i:id' => $this->id
            ]);
        } else {
            $result = $db->query('INSERT INTO ' . self::$tableName . ' SET firstname = ?, lastname = ?, email = ?, password = ?, is_admin = ?', [
                's:firstname' => $this->firstname,
                's:lastname' => $this->lastname,
                's:email' => $this->email,
                's:password' => $this->password,
                'i:is_admin' => $this->is_admin
            ]);
            /**
             * Bei einem INSERT Query wird von MySQL eine neue ID generiert (sofern eine AUTO_INCREMENT Spalte
             * existiert). Diese ID lesen wir hier aus und setzen sie ins aktuelle Objekt.
             */
            $this->id = $db->getInsertId();
        }

        return $result;
    }
}

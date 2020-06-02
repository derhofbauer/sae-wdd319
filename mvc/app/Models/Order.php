<?php

namespace App\Models;

use Core\Database;
use Core\Models\ModelTrait;

class Order
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
    public static $tableName = 'orders';

    /**
     * Wir definieren alle Spalten aus der Tabelle. Hier initialisieren wir die Variablen auch mit den entsprechenden
     * Datentypen, das ist aber nicht nötig.
     */
    public $id = 0;
    public $crdate = 0;
    public $user_id = 0;
    protected $products = '';
    public $delivery_address_id = 0;
    public $invoice_address_id = 0;
    public $payment_id = 0;
    public $status = 'open';

    /**
     * Die fill-Methode soll uns helfen, alle Properties der Klasse möglichst einfach und schnell aus einem Datenbank-
     * Ergebniss befüllen zu können.
     *
     * @param array $data
     */
    public function fill (array $data = [])
    {
        $this->id = $data['id'];
        $this->crdate = $data['crdate'];
        $this->user_id = $data['user_id'];
        $this->products = $data['products'];
        $this->delivery_address_id = $data['delivery_address_id'];
        $this->invoice_address_id = $data['invoice_address_id'];
        $this->payment_id = $data['payment_id'];
        $this->status = $data['status'];
    }

    /**
     * Die save-Methode soll uns helfen, geänderte Daten in die Datenbank zu speichern oder eine neue Zeile in der
     * Datenbank anzulegen, je nachdem, ob das aktuelle Objekt bereits existiert in der Datenbank oder nicht.
     *
     * weitere Erklärung s. App\Models\Address::save()
     */
    public function save ()
    {
        $db = new Database();

        if ($this->id > 0) {
            $result = $db->query('UPDATE ' . self::$tableName . ' SET user_id = ?, products = ?, delivery_address_id = ?, invoice_address_id = ?, payment_id = ?, status = ? WHERE id = ?', [
                'i:user_id' => $this->user_id,
                's:products' => $this->products,
                'i:delivery_address_id' => $this->delivery_address_id,
                'i:invoice_address_id' => $this->invoice_address_id,
                'i:payment_id' => $this->payment_id,
                's:status' => $this->status,
                'i:id' => $this->id
            ]);
        } else {
            $result = $db->query('INSERT INTO ' . self::$tableName . ' SET user_id = ?, products = ?, delivery_address_id = ?, invoice_address_id = ?, payment_id = ?, status = ?', [
                'i:user_id' => $this->user_id,
                's:products' => $this->products,
                'i:delivery_address_id' => $this->delivery_address_id,
                'i:invoice_address_id' => $this->invoice_address_id,
                'i:payment_id' => $this->payment_id,
                's:status' => $this->status
            ]);
            $this->id = $db->getInsertId();
        }

        return $result;
    }

    /**
     * Erklärungen s. ModelTrait::all()
     *
     * @param string $status
     *
     * @return array
     */
    public static function findByStatus (string $status = 'open')
    {
        $db = new Database();
        $tableName = self::$tableName;

        $result = $db->query("SELECT * FROM $tableName WHERE status = ?", [
            's:status' => $status
        ]);

        $data = [];
        foreach ($result as $resultItem) {
            $date = new self($resultItem);
            $data[] = $date;
        }

        return $data;
    }

    /**
     * Nachdem wir in einer Order einen Snapshot der bestellten Produkte zum Zeitpunkt der Bestellung speichern möchten,
     * haben wir uns für das Format JSON entschieden. Das bedeutet wir haben in der Order Tabelle eine Spalte products,
     * in welcher für jede Order ein JSON String mit den Werten der bestellten Produkte gespeichert ist. Nachdem es aber
     * ein JSON String ist, wandeln wir den JSON String hier in PHP Objekte um.
     *
     * s. https://www.php.net/manual/de/function.json-decode.php
     *
     * @return mixed
     */
    public function getProducts ()
    {
        return json_decode($this->products);
    }

    /**
     * In der Datenbank soll ein JSON-String aller Produkte der Order gespeichert werden. Wenn wir die Produkte des
     * Models setzen, serialisieren wir sie also direkt, damit wir sie dann einfach speichern können.
     *
     * @param $products
     */
    public function setProducts ($products)
    {
        $this->products = json_encode($products);
    }

    /**
     * Um den Gesamtpreis einer Order berechnen zu können, müssen alle Produkte aus der Order unter Berücksichtigung der
     * jeweiligen Stückzahl durchgegangen und zusammengerechnet werden.
     *
     * @return float|int
     */
    public function getPrice ()
    {
        $price = 0;

        /**
         * Wir verwenden hier die getProducts()-Methode und nicht die $products-Property, weil die Property ein JSON-
         * String ist und die Methode aber einen de-serialisierten Array an Objekten zurück gibt.
         */
        foreach ($this->getProducts() as $product) {
            $price += $product->price * $product->quantity;
        }

        return $price;
    }

    /**
     * Daten der Lieferadresse aus der Datenbank laden.
     *
     * @return Address
     */
    public function getDeliveryAddress ()
    {
        $address = Address::find($this->delivery_address_id);
        return $address;
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

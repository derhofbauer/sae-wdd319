<?php

namespace App\Models;

use Core\Models\ModelTrait;

class Product
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
    public static $tableName = 'products';

    /**
     * Wir definieren alle Spalten aus der Tabelle. Hier initialisieren wir die Variablen auch mit den entsprechenden
     * Datentypen, das ist aber nicht nötig.
     */
    public $id = 0;
    public $name = '';
    public $description = null;
    public $price = 0.0;
    public $stock = 0;
    public $images = [];

    /**
     * Die fill-Methode soll uns helfen, alle Properties der Klasse möglichst einfach und schnell aus einem Datenbank-
     * Ergebniss befüllen zu können.
     *
     * @param array $data
     */
    public function fill (array $data = [])
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->price = $data['price'];
        $this->stock = $data['stock'];
        $this->images = $data['images'];
    }

    /**
     * Die save-Methode soll uns helfen, geänderte Daten in die Datenbank zu speichern oder eine neue Zeile in der
     * Datenbank anzulegen, je nachdem, ob das aktuelle Objekt bereits existiert in der Datenbank oder nicht.
     */
    public function save ()
    {

    }

    /**
     * Möglichkeit, den Preis direkt formatiert zurück zu bekommen
     *
     * @return string
     */
    public function getPrice ()
    {
        return self::formatPrice($this->price);
    }

    /**
     * Um für das Produkt Edit Formular den Preis im richtigen Format zu erhalten, damit wir das Input Feld für den
     * Preis entsprechend vorbefüllen können, wollen wir den Preis hier in einen numerischen String mit 2 Nachkomma-
     * Stellen formatieren.
     *
     * @return string
     */
    public function getPriceFloat ()
    {
        return sprintf('%.2f', $this->price);
    }

    /**
     * @param $price
     *
     * @return string
     */
    public static function formatPrice ($price)
    {
        return sprintf('&euro; %.2f ,-', $price);
    }
}

<?php

namespace App\Models;

use Core\Database;
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

    public static $imagesDelimiter = ';';

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

        /**
         * @todo: comment
         */
        if (!empty($data['images'])) {
            if (strpos($data['images'], self::$imagesDelimiter) >= 0) {
                $this->images = explode(self::$imagesDelimiter, $data['images']);
            } else {
                $this->images[] = $data['images'];
            }
        }
    }

    /**
     * Die save-Methode soll uns helfen, geänderte Daten in die Datenbank zu speichern oder eine neue Zeile in der
     * Datenbank anzulegen, je nachdem, ob das aktuelle Objekt bereits existiert in der Datenbank oder nicht.
     *
     * explode: 'a-b-c' => Delimiter '-' => ['a', 'b', 'c']
     * implode: ['a', 'b', 'c'] => Glue ';' => 'a;b;c'
     */
    public function save ()
    {
        $db = new Database();

        $_images = implode(self::$imagesDelimiter, $this->images);

        if ($this->id > 0) {
            $result = $db->query('UPDATE ' . self::$tableName . ' SET name = ?, description = ?, price = ?, stock = ?, images = ? WHERE id = ?', [
                's:name' => $this->name,
                's:description' => $this->description,
                'd:price' => $this->price,
                'i:stock' => $this->stock,
                's:images' => $_images,
                'i:id' => $this->id
            ]);
        } else {
            $result = $db->query('INSERT INTO ' . self::$tableName . ' SET name = ?, description = ?, price = ?, stock = ?, images = ?', [
                's:name' => $this->name,
                's:description' => $this->description,
                'd:price' => $this->price,
                'i:stock' => $this->stock,
                's:images' => $_images
            ]);
            /**
             * Bei einem INSERT Query wird von MySQL eine neue ID generiert (sofern eine AUTO_INCREMENT Spalte
             * existiert). Diese ID lesen wir hier aus und setzen sie ins aktuelle Objekt.
             */
            $this->id = $db->getInsertId();
        }

        return $result;
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

    /**
     * Übergebenen Pfad in $this->images einfügen, sofern er nicht schon drin ist.
     *
     * @param string $filepath
     */
    public function addImage (string $filepath)
    {
        if (!in_array($filepath, $this->images)) {
            $this->images[] = $filepath;
        }
    }

    /**
     * Übergebenen Pfad aus $this->images löschen
     *
     * @param string $filepath
     */
    public function removeImage (string $filepath)
    {
        $indexForFilepath = array_search($filepath, $this->images);
        if ($indexForFilepath !== false) {
            unset($this->images[$indexForFilepath]);
        }
    }
}

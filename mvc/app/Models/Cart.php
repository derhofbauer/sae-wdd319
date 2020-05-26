<?php

namespace App\Models;

use Core\Models\ModelTrait;
use Core\Session;

/**
 * Das Cart unterscheidet sich fundamental von allen anderen Models, die wir bisher gebaut haben, weil es seine eigenen
 * Daten nicht in die Datenbank, sondern in die Session speichert.
 */
class Cart
{

    /**
     * $products wir ein Array von ProductIDs und Anzahl enthalten. Der Array Key wird die ProductID sein und der
     * zugehörige Value die Anzahl, wie oft das Produkt im Warenkorb ist:
     *
     * [
     *  4 => 2,
     *  3 => 100
     * ]
     *
     * In dem Beispiel ist Produkt#4 zweimal und Produkt#3 hundertmal im Warenkorb.
     */
    protected $products = [];

    /**
     * Wie auch schon in der Session Klasse selbst definieren wir uns hier eine Konstante, die wir dann später verwenden
     * können. Das hat den Vorteil, dass der tatsächlich verwendete Wert relativ egal ist, weil wir immer die Konstante
     * verwenden, wenn wir auf $_SESSION['cart'] zugreifen möchten.
     */
    const CART_KEY = 'cart';

    /**
     * Der Konstruktor lädt das Cart aus der Session und speichert es in $this->product.
     */
    public function __construct ()
    {
        $this->products = Session::get(self::CART_KEY, []);
    }

    /**
     * Der Destruktur nimmt $this->product und speichert es zurück in die Session. Wir verwenden deshalb den Destruktor,
     * weil wir dadurch nicht manuell speichern müssen, sondern automatisch spätestens am Skript-Ende das Cart in die
     * Session gespeichert wird.
     */
    public function __destruct ()
    {
        Session::set(self::CART_KEY, $this->products);
    }

    /**
     * Wir bieten die Möglichkeit, dass die Anzahl eines Produktes im Warenkorb direkt aktualisiert werden kann. Sinkt
     * die Quantity auf 0 oder darunter, so wird das Produkt aus dem Warenkorb gelöscht.
     *
     * @param int $productId
     * @param int $quantity
     */
    public function updateProduct (int $productId, int $quantity = 1)
    {
        if ($quantity <= 0) {
            unset($this->products[$productId]);
        } else {
            $this->products[$productId] = $quantity;
        }
    }

    /**
     * Hier fügen wir ein Produkt zum Warenkorb hinzu. Wenn es bereits im Cart existiert, dann erhöhen wir die Anzahl.
     *
     * @param int $productId
     * @param int $quantity
     */
    public function addProduct (int $productId, int $quantity = 1)
    {
        if (array_key_exists($productId, $this->products)) {
            $this->updateProduct($productId, $this->products[$productId] + $quantity);
        } else {
            $this->updateProduct($productId, $quantity);
        }
    }

    /**
     * Hier entfernen wir ein Produkt aus dem Warenkorb. Wenn die neue $quantity, die an $this->updateProduct()
     * übergeben wird unter 0 sinkt, dann löscht $this->updateProduct() das Produkt aus dem Warenkorb. Wir können hier
     * aber auch nur bspw. eines von drei Exemplaren aus dem Warenkorb nehmen.
     *
     * @param int $productId
     * @param int $quantity
     */
    public function removeProduct (int $productId, int $quantity = 0)
    {
        if (array_key_exists($productId, $this->products)) {
            $this->updateProduct($productId, $this->products[$productId] - $quantity);
        }
    }

    /**
     * Nachdem im in der Session gespeicherten Cart nur die Produkt ID und die Anzahl stehen, holt die getProducts()
     * Methode die zugehörigen Produkt-Informationen aus der Datenbank und gibt sie als Array an Products zurück.
     *
     * @return array
     */
    public function getProducts ()
    {
        $_products = [];

        /**
         * Warenkorb durchgehen
         */
        foreach ($this->products as $productId => $quantity) {
            /**
             * Produkt anhand der $productId aus der Datenbank laden
             */
            $product = Product::find($productId);

            /**
             * PHP erlaubt es uns Objekten Eigenschaften hinzuzufügen, die in der Klasse nicht definiert sind. $product
             * ist vom Typ Product, die Product Klasse definiert aber keine Eigenschaft $quantity. Wir setzen $quantity
             * hier aber dennoch zur Laufzeit, weil wir die Information später noch verwenden möchten. Am Datenbestand
             * in der Datenbank wird dabei nichts verändert und die dynamisch hinzugefügte $quantity Eigenschaft wird
             * auch nicht in die Datenbank gespeichert, weil die save() Methode der Product Klasse die $quantity nicht
             * kennt.
             */
            $product->quantity = $quantity;

            /**
             * $product zu Rückgabe-Array hinzufügen
             */
            $_products[] = $product;
        }

        return $_products;
    }

}

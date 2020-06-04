<?php

namespace App\Controllers;

use App\Models\Cart;
use Core\Helpers\Config;
use Core\Session;
use Core\View;

class CartController
{

    /**
     * Inhalt aus dem Cart laden und an einen View zur Auflistung übergeben.
     */
    public function index ()
    {
        $cart = new Cart();

        View::load('cart', [
            'cartContent' => $cart->getProducts()
        ]);
    }

    /**
     * Nimmt eine ProductId entgegen und fügt ein Exemplar dieses Produkts in den Warenkorb hinzu.
     *
     * @param int $productId
     */
    public function addProductToCart (int $productId)
    {
        /**
         * Cart laden
         */
        $cart = new Cart();

        /**
         * Anzahl der hinzuzufügenden Produkte aus dem Formular auslesen. Wir prüfen ob der Wert numerisch ist, weil es
         * sehr einfach ist die HTML Frontend-Validierung zu umgehen. Es handelt sich hier also um eine sehr sehr
         * rudimentäre Validierung.
         */
        if (isset($_POST['quantity']) && is_numeric($_POST['quantity'])) {
            /**
             * Produkte in der angegebenen Anzahl ins Cart legen. Der 2. Parameter der addProduct()-Methode wurde von
             * uns vorbereitet und kann hier nun verwendet werden.
             */
            $cart->addProduct($productId, $_POST['quantity']);
        } else {
            /**
             * 1 Stück von $productId hinzufügen
             */
            $cart->addProduct($productId);
        }

        /**
         * Auf die vorherige URL zurück leiten.
         */
        $referrer = Session::get('referrer');
        header("Location: $referrer");
        exit;
    }

    /**
     * Nimmt eine ProductId entgegen und entfernt ein Exemplar dieses Produkts aus dem Warenkorb.
     *
     * @param int $productId
     */
    public function removeProductFromCart (int $productId)
    {
        /**
         * Cart laden
         */
        $cart = new Cart();

        /**
         * 1 Stück von $productId entfernen
         */
        $cart->removeProduct($productId);

        /**
         * Auf die vorherige URL zurück leiten.
         */
        $referrer = Session::get('referrer');
        header("Location: $referrer");
    }

    /**
     * Nimmt eine ProductId entgegen und entfernt alle Exemplare dieses Produkts aus dem Warenkorb.
     *
     * @param int $productId
     */
    public function deleteProductFromCart (int $productId)
    {
        /**
         * Cart laden
         */
        $cart = new Cart();

        /**
         * Der 2. Parameter von Cart::updateProduct ist die absolute Quantity, die gesetzt werden soll. Ist dieser Wert
         * kleiner oder gleich 0, so wird das Produkt aus dem Warenkorb gelöscht.
         */
        $cart->updateProduct($productId, 0);

        /**
         * Auf die vorherige URL zurück leiten.
         */
        $referrer = Session::get('referrer');
        header("Location: $referrer");
    }

    /**
     * Nimmt eine ProductId entgegen und setzt eine neue Anzahl dieses Produkts im Warenkorb.
     *
     * @param int $productId
     */
    public function updateProductInCart (int $productId)
    {
        /**
         * Neue Anzahl aus dem Formular abfragen.
         */
        $newQuantity = (int)$_POST['quantity'];

        /**
         * Cart laden
         */
        $cart = new Cart();

        /**
         * Der 2. Parameter von Cart::updateProduct ist die absolute Quantity, die gesetzt werden soll. Ist dieser Wert
         * kleiner oder gleich 0, so wird das Produkt aus dem Warenkorb gelöscht.
         */
        $cart->updateProduct($productId, $newQuantity);

        /**
         * Auf die vorherige URL zurück leiten.
         */
        $referrer = Session::get('referrer');
        header("Location: $referrer");
    }

}

<?php

namespace App\Controllers;

use App\Models\Cart;
use Core\View;

class CartController
{

    /**
     * [ ] Cart Inhalt in einer Liste darstellen
     * [ ] Produkte aus dem Cart löschen
     * [ ] Cart Stückzahl verändern
     */
    public function index ()
    {
        $cart = new Cart();

        View::load('cart', [
            'cartContent' => $cart->getProducts()
        ]);
    }

}

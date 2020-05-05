<?php

namespace App\Controllers;

use App\Models\Product;
use Core\View;

class ProductController
{

    public function list ()
    {

        /**
         * [x] Alle Produkte aus Datenbank abfragen
         * [x] Produkte an View übergeben
         */
        $products = Product::all();

        /**
         * Um hier nicht den Header und den Footer und dann den View laden zu müssen, haben wir uns eine View Klasse
         * gebaut.
         */
        View::load('home', [
            'products' => $products
        ]);

    }

    public function showProduct (int $productIdFromUrl)
    {
        $id = $productIdFromUrl;

        $product = Product::find($id);

        View::load('product', [
            'product' => $product
        ]);
    }

}

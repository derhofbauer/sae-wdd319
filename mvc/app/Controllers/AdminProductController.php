<?php

namespace App\Controllers;

use App\Models\Product;
use Core\View;

class AdminProductController
{

    /**
     * Edit Formular für eine Order anzeigen
     *
     * @param int $id
     */
    public function editForm (int $id)
    {
        /**
         * Product anhand des Route Parameters $id aus der DB abfragen
         */
        $product = Product::find($id);

        /**
         * View laden und Produkt übergeben
         */
        View::load('admin/productForm', [
            'product' => $product
        ]);
    }

    /**
     * Daten aus dem Edit Formular eines Produkts entgegen nehmen und speichern
     *
     * @param int $id
     */
    public function edit (int $id)
    {
        /**
         * Product aus der DB abfragen
         */
        $product = Product::find($id);

        /**
         * @todo: CONTINUE HERE!
         */

        var_dump($_POST, $_FILES);
    }

}

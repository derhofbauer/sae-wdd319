<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Helpers\Config;
use Core\Helpers\Validator;
use Core\Session;
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
            'product' => $product,
            'errors' => Session::get('errors', [], true)
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
         * Validator Klasse verwenden. Diese Klasse wurde von meinem Vorgänger programmiert. Genauere Erklärung in
         * core/Helpers/Validator.php.
         */
        $validator = new Validator();
        $validator->validate($_POST['name'], 'Name', true, 'textnum', 2, 255);
        $validator->validate($_POST['stock'], 'Stock', true, 'num');
        /**
         * Potentiell aufgetretene Fehler aus dem Validator abfragen.
         */
        $errors = $validator->getErrors();

        /**
         * $baseUrl abfragen, damit wir danach Redirects machen können
         */
        $baseUrl = Config::get('app.baseUrl');

        /**
         * Wenn im Validator Fehler aufgetreten sind, dann schreiben wir sie in die Session und leiten zurück zum
         * Formular, von dem wir gekommen sind.
         */
        if ($errors !== false) {
            Session::set('errors', $errors);
            header("Location: $baseUrl/products/$id/edit");
            exit;
        }

        /**
         * Product aus der DB abfragen
         */
        $product = Product::find($id);
        /**
         * Eigenschafen des Products überschreiben. Die Daten werden dabei nicht direkt in die Datenbank geschpeichert
         * sondern nur in dem PHP Objekt.
         */
        $product->name = $_POST['name'];
        $product->description = $_POST['description'];
        $product->price = (float)$_POST['price'];
        $product->stock = (int)$_POST['stock'];

        /**
         * Hochgeladene Dateien aus dem Formular entgegennehmen
         *
         * @todo: comment
         */
        foreach ($_FILES['images']['error'] as $index => $error) {
            if ($error === 0) {
                $type = $_FILES['images']['type'][$index]; // image/jpeg, image/gif, application/pdf, ...
                $type = explode('/', $type)[0];
                if ($type === 'image') {
                    $tmp_name = $_FILES['images']['tmp_name'][$index];
                    $filename = basename($_FILES['images']['name'][$index]);
                    $filename = time() . "_" . $filename;
                    $destination = __DIR__ . "/../../storage/uploads/$filename";
                    move_uploaded_file($tmp_name, $destination);

                    $product->addImage("uploads/$filename");
                }
            }
        }

        /**
         * Im Formular angehakerlte Dateien löschen
         */
        if (isset($_POST['delete-images'])) {
            foreach ($_POST['delete-images'] as $imagePath => $unusedValue) {
                $product->removeImage($imagePath);

                /**
                 * @todo: comment (Inkonsistenz zwischen DB und Storage kann entstehen)
                 */
                unlink(__DIR__ . "/../../storage/$imagePath");
            }
        }

        /**
         * Aktualisierte Eigenschaften in die Datenbank speichern.
         */
        $product->save();

        /**
         * Redirect
         */
         header("Location: $baseUrl/dashboard");
         exit;
    }

}

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
     * Edit Formular für ein Produkt anzeigen
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
         * View laden und Produkt und mögliche Validierungsfehler übergeben
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
         * Eigenschafen des Products überschreiben. Die Daten werden dabei nicht direkt in die Datenbank gespeichert
         * sondern nur in dem PHP Objekt.
         */
        $product->name = $_POST['name'];
        $product->description = $_POST['description'];
        $product->price = (float)$_POST['price'];
        $product->stock = (int)$_POST['stock'];

        /**
         * Hochgeladene Dateien aus dem Formular entgegennehmen. Die Dateien werden als Array übergeben, weil wir
         * mehrere Dateien hochladen könnten. S. dazu auch das Beispiele/1-file-upload.php
         *
         * Nachdem es sich um einen Array handelt, gehen wir mit einer Schleife alle Dateien in dem Array durch.
         */
        foreach ($_FILES['images']['error'] as $index => $error) {
            /**
             * Wenn kein Fehler beim Upload der aktuellen Datei aufgetreten ist, dann verarbeiten wir die Datei weiter.
             */
            if ($error === 0) {
                /**
                 * Wir akzeptieren nur Bilder. Über den MIME-Type können wir relative leicht herausfinden, ob eine Datei
                 * ein Bild ist oder nicht. MIME-Types schauen wie folgt aus: image/jpeg, image/gif, application/pdf ...
                 *
                 * Um zu erkennen ob es sich um ein Bild handelt, teilen wir den String am Slash und nehmen den Wert 0,
                 * also "image" oder "application".
                 */
                $type = $_FILES['images']['type'][$index];
                $type = explode('/', $type)[0];

                /**
                 * Handelt es sich um ein Bild?
                 */
                if ($type === 'image') {
                    /**
                     * $tmp_name ist der Dateipfad, an den PHP das File temporär gespeichert hat.
                     */
                    $tmp_name = $_FILES['images']['tmp_name'][$index];

                    /**
                     * Die basename-Funktion gibt den Dateinamen aus einem kompletten Dateipfad zurück:
                     * basename('/Application/MAMP/htdocs/index.php') ==> 'index.php
                     *
                     * Wir stellen so sicher, dass wir wirklich nur den originalen Dateinamen bekommen.
                     */
                    $filename = basename($_FILES['images']['name'][$index]);

                    /**
                     * Damit im Zuge des Uploads bereits existierende Dateien nicht überschrieben werden, hängen wir
                     * einen UNIX-Timestamp vorne dran. Dadurch haben wir zwar potentiell die selbe Datei mehrfach, aber
                     * es kommt nicht zu Datenverlust.
                     */
                    $filename = time() . "_" . $filename;

                    /**
                     * Hier definieren wir uns den absoluten Pfad, an den die Datei vom $tmp_name aus verschoben werden
                     * soll.
                     */
                    $destination = __DIR__ . "/../../storage/uploads/$filename";

                    /**
                     * Verschieben der hochgeladenen Datei von $tmp_name nach $destination.
                     */
                    move_uploaded_file($tmp_name, $destination);

                    /**
                     * Hochgeladenes Bild zum Product hinzufügen. Hier wird es noch nicht in die Datenbank gespeichert,
                     * sondern nur in dem PHP Objekt im RAM des Servers.
                     */
                    $product->addImage("uploads/$filename");
                }
            }
        }

        /**
         * Im Formular angehakerlte Dateien löschen
         *
         * Wurden Dateien zur Löschung angehakerlt?
         */
        if (isset($_POST['delete-images'])) {
            /**
             * Für jede angehakerlte Checkbox, entfernen wir die Datei aus dem Product und löschen sie physisch vom
             * Server.
             */
            foreach ($_POST['delete-images'] as $imagePath => $unusedValue) {
                /**
                 * Datei aus dem Product entfernen.
                 */
                $product->removeImage($imagePath);

                /**
                 * Die unlink-Funktion löscht eine Datei.
                 */
                unlink(__DIR__ . "/../../storage/$imagePath");
            }
        }

        /**
         * Aktualisierte Eigenschaften in die Datenbank speichern.
         *
         * Tritt ein Fehler auf, bevor diese Zeile aufgerufen wird, kann es passieren, dass Dateien auf Zeile 166
         * gelöscht werden, auf 161 auch aus dem Produkt entfernt werden, die Änderungen am Produkt aber nicht in die
         * Datenbank gespeichert werden. Das kann dazu führen, dass in der Datenbank Dateien verlinkt sind, die
         * physisch nicht mehr existieren. Dieser Fall ist sehr unwahrscheinlich, kann aber rein theoretisch auftreten.
         */
        $product->save();

        /**
         * Redirect
         */
        header("Location: $baseUrl/dashboard");
        exit;
    }

    /**
     * Add Formular für ein Produkt anzeigen
     */
    public function addForm ()
    {
        /**
         * View laden und mögliche Validierungsfehler übergeben
         */
        View::load('admin/productAddForm', [
            'errors' => Session::get('errors', [], true)
        ]);
    }

    /**
     * Daten aus dem Add Formular eines Produkts entgegen nehmen und neues Produkt in die Datenbank speichern. Die
     * Logik ist dabei praktisch Ident mit der der edit() Methode. Sie ist lediglich angepasst auf das Hinzufügen eines
     * neuen und nicht das Aktualisieren eines bereits existierenden Produkts.
     */
    public function add ()
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
        if (!empty($errors)) {
            Session::set('errors', $errors);
            header("Location: {$baseUrl}dashboard/products/add");
            exit;
        }

        /**
         * Product aus der DB abfragen
         */
        $product = new Product();
        /**
         * Eigenschafen des Products überschreiben. Die Daten werden dabei nicht direkt in die Datenbank geschpeichert
         * sondern nur in dem PHP Objekt.
         */
        $product->name = $_POST['name'];
        $product->description = $_POST['description'];
        $product->price = (float)$_POST['price'];
        $product->stock = (int)$_POST['stock'];

        /**
         * Hochgeladene Dateien aus dem Formular entgegennehmen. Die Dateien werden als Array übergeben, weil wir
         * mehrere Dateien hochladen könnten. S. dazu auch das Beispiele/1-file-upload.php
         *
         * Nachdem es sich um einen Array handelt, gehen wir mit einer Schleife alle Dateien in dem Array durch.
         */
        foreach ($_FILES['images']['error'] as $index => $error) {
            /**
             * Wenn kein Fehler beim Upload der aktuellen Datei aufgetreten ist, dann verarbeiten wir die Datei weiter.
             */
            if ($error === 0) {
                /**
                 * Wir akzeptieren nur Bilder. Über den MIME-Type können wir relative leicht herausfinden, ob eine Datei
                 * ein Bild ist oder nicht. MIME-Types schauen wie folgt aus: image/jpeg, image/gif, application/pdf ...
                 *
                 * Um zu erkennen ob es sich um ein Bild handelt, teilen wir den String am Slash und nehmen den Wert 0,
                 * also "image" oder "application".
                 */
                $type = $_FILES['images']['type'][$index];
                $type = explode('/', $type)[0];

                /**
                 * Handelt es sich um ein Bild?
                 */
                if ($type === 'image') {
                    /**
                     * $tmp_name ist der Dateipfad, an den PHP das File temporär gespeichert hat.
                     */
                    $tmp_name = $_FILES['images']['tmp_name'][$index];

                    /**
                     * Die basename-Funktion gibt den Dateinamen aus einem kompletten Dateipfad zurück:
                     * basename('/Application/MAMP/htdocs/index.php') ==> 'index.php
                     *
                     * Wir stellen so sicher, dass wir wirklich nur den originalen Dateinamen bekommen.
                     */
                    $filename = basename($_FILES['images']['name'][$index]);

                    /**
                     * Damit im Zuge des Uploads bereits existierende Dateien nicht überschrieben werden, hängen wir
                     * einen UNIX-Timestamp vorne dran. Dadurch haben wir zwar potentiell die selbe Datei mehrfach, aber
                     * es kommt nicht zu Datenverlust.
                     */
                    $filename = time() . "_" . $filename;

                    /**
                     * Hier definieren wir uns den absoluten Pfad, an den die Datei vom $tmp_name aus verschoben werden
                     * soll.
                     */
                    $destination = __DIR__ . "/../../storage/uploads/$filename";

                    /**
                     * Verschieben der hochgeladenen Datei von $tmp_name nach $destination.
                     */
                    move_uploaded_file($tmp_name, $destination);

                    /**
                     * Hochgeladenes Bild zum Product hinzufügen. Hier wird es noch nicht in die Datenbank gespeichert,
                     * sondern nur in dem PHP Objekt im RAM des Servers.
                     */
                    $product->addImage("uploads/$filename");
                }
            }
        }

        /**
         * Neues Produkt in die Datenbank speichern.
         */
        $product->save();

        /**
         * Redirect
         */
        header("Location: $baseUrl/dashboard");
        exit;
    }

}

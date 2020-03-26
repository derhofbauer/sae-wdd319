<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Datei Upload</title>
</head>
<body>

<?php

/**
 * Prüfen, ob wir ein abgeschicktes Formular erhalten haben
 */
if (isset($_POST['MAX_FILE_SIZE'])) {
    // var_dump($_FILES);

    /**
     * Wenn keine Fehler beim Upload aufgetreten sind, speichern wir das File in unseren Upload Ordner
     */
    if ($_FILES['uploaded_file']['error'] === 0) {

        /**
         * ursprünglicher Name der hochgeladenen Datei
         */
        $tmp_name = $_FILES['uploaded_file']['tmp_name'];

        /**
         * die `basename()` Funktion extrahiert den Dateinamen aus einem vollständigen Dateipfad
         */
        $filename = basename($_FILES['uploaded_file']['name']);

        /**
         * . gibt das Verzeichnis an, in dem grade gearbeitet wird. ./uploads ist also ein Ordner, parallel zum 1-file-upload.php
         */
        $destination = "./uploads/$filename";

        /**
         * verschieben der temporären Datei aus dem PHP tmp-Verzeichnis an die gewünschte Stelle im Dateisystem
         */
        move_uploaded_file($tmp_name, $destination);
    }

    /**
     * Mehrfach-Dateiupload
     *
     * Funktionell analog zum einfachen Datei Upload oben, aber wir müssen jede Datei einzeln behandeln.
     * Beim Upload mehrerer Dateien erhält jede $_FILES Property eine neue Ebene und darin jeweils den entsprechenden
     * Partikel aller Dateien.
     */
    foreach ($_FILES['uploaded_files']['error'] as $index => $error) {
        if ($error === 0) {
            $tmp_name = $_FILES['uploaded_files']['tmp_name'][$index];
            $filename = basename($_FILES['uploaded_files']['name'][$index]);
            $destination = "./uploads/$filename";
            move_uploaded_file($tmp_name, $destination);
        }
    }
}

?>

<!--
Damit Dateien in einem Formular überhaupt übertragen werden, muss der `enctype="multipart/form-data"` gesetzt werden.
-->
<form method="post" enctype="multipart/form-data">

    <p class="form-group">
        <label for="uploaded_file">Dateiupload (einfach)</label>
        <br>
        <input type="file" name="uploaded_file">
    </p>

    <p class="form-group">
        <!--
        Damit PHP weiß, dass mehrere Dateien übertragen wurden und diese den selben Namen in $_FILES haben, muss dem
        Namen das HTML-Input Elements [] nachgestellt werden. Die Informationen werden in der $_FILES Superglobal
        trotzdem als "uploaded_files" und nicht "uploaded_files[]" verfügbar sein.
        -->
        <label for="uploaded_files[]">Dateiupload (mehrfach)</label>
        <br>
        <input type="file" name="uploaded_files[]" multiple>
    </p>

    <input type="hidden" name="MAX_FILE_SIZE" value="2000">

    <button type="submit">Upload</button>
</form>

</body>
</html>

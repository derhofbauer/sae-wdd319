<?php

/**
 * + Formular zur Topic bearbeitung
 * + Datenvalidierung
 */

$errors = [];

/**
 * Wurde eine ID in der URL übergeben?
 */
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = $_GET['id'];

    /**
     * Wurde das Formular abgeschickt?
     */
    if (isset($_POST['name']) && isset($_POST['description'])) {
        /**
         * Hier würden wir validieren. Der Übersichtlichkeit wegen verzichten wir hier darauf.
         */

        /**
         * Aliases für die POST Werte definieren
         */
        $name = $_POST['name'];
        $description = $_POST['description'];

        /**
         * Update MySQL Query definieren und abschicken
         */
        $query = "UPDATE `topics` SET `name` = '$name', `description` = '$description' WHERE `id` = '$id'";
        $result = mysqli_query($link, $query);

        /**
         * mysqli_query gibt im Fehlerfall false zurück
         */
        if ($result === false) {
            /**
             * MySQL Fehler in den $errors Array speichern, damit wir ihn ausgeben könnten
             */
            $errors[] = mysqli_errno($link) . ': ' . mysqli_error($link);
        } else {
            /**
             * Tritt kein MySQL Fehler auf, leiten wir zurück zum Dashboard
             */
            header('Location: index.php?page=dashboard');
            exit;
        }
    }

    /**
     * Topic mit der ID aus der URL aus der Datenbank abfragen
     */
    $query = "SELECT * FROM `topics` WHERE `id` = '$id'";
    $result = mysqli_query($link, $query);

    /**
     * Hat der $query ein Ergebnis zurück geliefert oder war das Ergebnis leer?
     */
    if (mysqli_num_rows($result) > 0) {
        /**
         * MySQL Ergebnis in ein Array konvertieren
         */
        $resultData = mysqli_fetch_assoc($result);

        /**
         * Die extract Funktion erstellt für jeden Array Key eine neue Variable. In unserem Fall wie folgt:
         *
         * + $resultData['id']          => $id
         * + $resultData['name']        => $name
         * + $resultData['description'] => $description
         *
         * Die Werte der einzelnen Variablen sind dabei ident mit den Werten aus dem Array.
         *
         * Wir verwenden die extract Funktion, damit wir im View nicht bspw. $resultData['id'] schreiben müssen, sondern
         * $id verwenden können.
         */
        extract($resultData);
    } else {
        $errors[] = "Topic mit der ID $id nicht gefunden";
    }

} else {
    $errors[] = 'Es wurde keine gültige ID übergeben';
}

require_once __DIR__ . '/../views/admin.edit-topic.php';

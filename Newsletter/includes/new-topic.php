<?php

$errors = [];

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
    $query = "INSERT INTO `topics` SET `name` = '$name', `description` = '$description'";
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

require_once __DIR__ . '/../views/admin.new-topic.php';

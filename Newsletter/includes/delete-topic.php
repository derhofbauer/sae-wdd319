<?php

$errors = [];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    /**
     * Update MySQL Query definieren und abschicken
     */
    $id = $_GET['id'];
    $query = "DELETE FROM `topics` WHERE `id` = '$id'";
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
} else {
    /**
     * Fehler wir nicht ausgegen, weil kein View geladen wird, wir leiten daher einfach aufs Dashboard weiter.
     */
    $errors[] = "Keine ID angegeben";

    header('Location: index.php?page=dashboard');
    exit;
}

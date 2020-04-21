<?php

/**
 * + Formular zur Topic bearbeitung
 * + Datenvalidierung
 */

$errors = [];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = $_GET['id'];

    if (isset($_POST['name']) && isset($_POST['description'])) {
        /**
         * Validierung ...
         */

        /**
         * Änderungen speichern
         */
        $name = $_POST['name'];
        $description = $_POST['description'];

        $query = "UPDATE `topics` SET `name` = '$name', `description` = '$description' WHERE `id` = '$id'";
        $result = mysqli_query($link, $query);

        if ($result === false) {
            $errors[] = mysqli_errno($link) . ': ' . mysqli_error($link);
        } else {
            /**
             * Redirect
             */
            header('Location: index.php?page=dashboard');
            exit;
        }
    }

    $query = "SELECT * FROM `topics` WHERE `id` = '$id'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0) {
        $resultData = mysqli_fetch_assoc($result);

        extract($resultData);
    } else {
        $errors[] = "Topic mit der ID $id nicht gefunden";
    }

} else {
    $errors[] = 'Es wurde keine gültige ID übergeben';
}

require_once __DIR__ . '/../views/admin.edit-topic.php';

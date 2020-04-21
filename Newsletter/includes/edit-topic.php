<?php

/**
 * + Formular zur Topic bearbeitung
 * + Datenvalidierung
 */

$errors = [];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {



} else {
    $errors[] = 'Es wurde keine gültige ID übergeben';
}

require_once __DIR__ . '/../views/admin.edit-topic.php';

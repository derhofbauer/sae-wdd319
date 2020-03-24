<?php

$errors = [];

/**
 * Name
 */
$name = $_POST['name'];
if (strlen($name) < 2) {
    $errors[] = "Der Name muss mindestens 2 Zeichen lang sein.";
    // array_push($errors, "Der Name muss mindestens 2 Zeichen lang sein.");
}

/**
 * Email
 */
$email = $_POST['email'];
$atIndex = strpos($email, '@');
if ($atIndex < 1 || strpos($email, '.', $atIndex) < ($atIndex + 1)) {
    $errors[] = "Bitte geben Sie eine gültige Email-Adresse ein.";
}

/**
 * Anrede
 */
if (!isset($_POST['salutation'])) {
    $errors[] = "Bitte wählen Sie eine Anrede aus.";
}

/**
 * Geschlecht
 */
$gender = $_POST['gender'];
if ($gender === '_default') {
    $errors[] = "Bitte wählen Sie ein Geschlecht aus.";
}

/**
 * Nachricht
 */
$message = $_POST['message'];
if (strlen($message) < 10) {
    $errors[] = "Bitte geben Sie eine ordentliche Nachricht ein, ich mein hallo?!";
}

/**
 * Newsletter
 */
$newsletter = false;
if (isset($_POST['newsletter']) && $_POST['newsletter'] === 'on') {
    $newsletter = true;
}

/**
 * Formular neu laden
 */
require_once 'index.php';

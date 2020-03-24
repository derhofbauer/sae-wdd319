<?php

/**
 * Wir definieren einen Array, in den wir alle Fehlermeldungen einfach nur hinein pushen, damit wir später darauf
 * zugreifen und eine Liste an Fehlern ausgeben können.
 */
$errors = [];

/**
 * Name
 */
$name = $_POST['name'];
if (strlen($name) < 2) {
    /**
     * Die Syntax $array[] mit den beiden Klammern erzeugt einen neuen numerischen Index und fügt den Wert nach dem "="
     * an diesem Index in das Array ein. Analog zu einem klassischen push in einem Array.
     */
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
 * Telefon
 */
$phone = $_POST['phone'];
/*$phone = str_replace('+', '00', $phone);
$phone = str_replace([' ', '-'], '', $phone);
if (!is_numeric($phone)) {
    $errors[] = 'Bitte geben Sie eine gültige Telefonnummer ein.';
}*/
$phone_regex = '/^(\+|00)[\ 0-9-]*$/';
if (preg_match($phone_regex, $phone) === false) {
    $errors[] = 'Bitte geben Sie eine gültige Telefonnummer ein.';
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
/**
 * $newsletter definieren wir hier nur als "Schalter". Der Schalter ist standardmäßig aus, nur wenn die Bedingunen erfüllt
 * ist, wird er aktiviert. Wir benötigen daher keinen "else"-Block.
 */
$newsletter = false;
if (isset($_POST['newsletter']) && $_POST['newsletter'] === 'on') {
    $newsletter = true;
}

/**
 * Formular neu laden
 */
require_once 'index.php';

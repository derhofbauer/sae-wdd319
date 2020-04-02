<?php

$errors = [];

if (isset($_POST['do-submit'])) {


    var_dump($_POST);


    if (
        !isset($_POST['salutation']) ||
        $_POST['salutation'] !== 'f' ||
        $_POST['salutation'] !== 'm'
    ) {
        $errors['salutation'] = "Bitte wählen Sie eine Andrede aus";
    }

    if (!isset($_POST['name']) || strlen($_POST['name']) < 2) {
        $errors['name'] = "Bitte geben Sie einen gültigen Namen ein";
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $at = strpos($email, '@');

        if ($at < 1 || strpos($email, '.', $at) < ($at + 1)) {
            $errors['email'] = "Bitte geben sie eine gültige Email-Adresse ein";
        }
    }

    if (isset($_POST['birthday'])) {
        // DD.MM.YYYY

        $birthday = $_POST['birthday'];
        $dateParticles = explode('.', $birthday);

        if (count($dateParticles) === 3) {
            $day = (int)$dateParticles[0];
            $month = (int)$dateParticles[1];
            $year = (int)$dateParticles[2];

            $months = [
                1 => 31,
                2 => 29,
                3 => 31,
                4 => 30,
                5 => 31,
                6 => 30,
                7 => 31,
                8 => 31,
                9 => 30,
                10 => 31,
                11 => 30,
                12 => 31
            ];

            if ($month > 12 || $month < 1) {
                $errors['birthday'] = "Bitte geben Sie ein valides Monat ein";
            } else {
                $daysOfGivenMonth = $months[$month];

                if ($day > $daysOfGivenMonth || $day < 1) {
                    $errors['birthday'] = "Bitte geben Sie einen validen Tag ein";
                } else {
                    $currentYear = (int)date('Y');
                    if ($year > $currentYear || $year < ($currentYear - 120)) {
                        $errors['birthday'] = "Bitte geben Sie ein valides Jahr ein";
                    }
                }
            }
        } else {
           $errors['birthday'] = "Bitte geben Sie Ihr Geburtsdatum ein";
        }
    }

}

var_dump($errors);

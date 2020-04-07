<?php

$errors = [];

if (isset($_POST['do-submit'])) {


    // var_dump($_POST);


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

    // KREDITKARTENNUMMER

    /**
     * 1) Gibts eine Kreditkartennummer?
     * 2) Alle Leerzeichen entfernen
     * 3) Numerisch & 16 Zeichen?
     * 4) String umdrehen
     * 5) Multiplikationen durchführen
     * 6) Ziffernsummer aller Produkte berechnen
     * 7) Ziffernsumme Modulo 10 gleich 0? wenn ja: valide, wenn nein: FEHLER
     */

    if (isset($_POST['creditcard'])) {
        $creditcard = $_POST['creditcard'];

        /**
         * Leerzeichen aus der Kreditkartennummer entfernen
         */
        $creditcard = str_replace(' ', '', $creditcard);

        /**
         * Kreditkartennummern müssen nicht immer 16 Zeichen lang sein, daher die strlen-Prüfung auf mind. 13 Zeichen
         *
         * Laut folgender Seite, haben Kreditkartennummern allerdings mindestens 13 Zeichen:
         * http://www.pruefziffernberechnung.de/K/Kreditkarten.shtml
         *
         * An dieser Stelle prüfen wir, ob die Kreditkartennummer numerisch ist und mindestens 13 Zeichen hat
         */
        if (is_numeric($creditcard) && strlen($creditcard) >= 13) {

            /**
             * Umdrehen der Kreditkartennummer, die aktuell ein String ist
             */
            $creditcardRev = strrev($creditcard);

            /**
             * Wird die Produkte der Multiplikationen beinhalten, die für die Prüfziffernberechnung nötig sind
             * (s. obenstehender Link)
             */
            $multipliedDigits = [];

            /**
             * Wird als "Schalter" dienen, damit wir wissen, ob wir mit 1 oder mit 2 multiplizieren sollen
             * (s. obenstehender Link)
             */
            $double = false;

            /**
             * str_split teilt einen String in ein Array, sodass jeder Buchstabe ein eigener Wert ist
             *
             * Bsp: str_split("SAE") // --> ["S", "A", "E"];
             */
            $digits = str_split($creditcardRev);

            /**
             * Jetzt möchten wir alle Zeichen aus der Kreditkartennummer durchgehen und entsprechend der Regeln aus dem
             * Link multiplizieren
             */
            foreach ($digits as $digit) {

                /**
                 * Wenn der "Schalter" $double aktiv ist, dann multiplizieren wir mit 2, sonst multiplizieren wir mit 1.
                 * Wir verzichten daher auf die Multiplikation, weil eine Multiplikation mit 1 den Wert nicht verändert.
                 *
                 * Wir multiplizieren hier also abwechseln in jedem Schleifendurchlauf einmal mit 2 und einmal mit 1,
                 * weil die Regeln für die Prüfziffernberechnung von Kreditkartennummern das vorsieht.
                 */
                if ($double === true) {
                    $multipliedDigits[] = (int)$digit * 2;
                } else {
                    $multipliedDigits[] = (int)$digit; // * 1
                }

                /**
                 * "Umschalten" des logischen "Schalters"
                 */
                $double = !$double;

                /**
                 * Dieser Block ist funktionell ident mit dem oberen if-Block:
                 */
                /*
                    $multiplier = 1;
                    if ($double === true) {
                        $multiplier = 2;
                    }
                    $double = !$double;

                    $multipliedDigits[] = (int)$digit * $multiplier;
                */
            }

            /**
             * Dieser Block ist funktionell ident mit der oberen foreach-Schleife:
             */
            /*
            for ($i = strlen($creditcard); $i > 0; $i--) {
                $digit = $creditcard[$i];
                if ($double === true) {
                    $multipliedDigits[] = (int)$digit * 2;
                } else {
                    $multipliedDigits[] = (int)$digit; // * 1
                }
                $double = !$double;
            }
            */

            /**
             * Im folgenden tricksen wir ein bisschen um uns Code zu sparen.
             *
             * Mit der implode-Funktion hängen wir alle Produkte, die auch zweistellig sein können, in einen String
             * zusammen, weil wir die Ziffernsumme berechnen möchten und somit einfach nur alle Ziffern, nicht aber die
             * Zahlen selbst brauchen.
             */
            $productsString = implode('', $multipliedDigits);

            /**
             * Mit str_split zerlegen wir den String an Ziffern wieder in ein Array (s. oben)
             */
            $productsStringDigits = str_split($productsString);

            /**
             * Die Funktion array_sum berechnet die Summe aller Werte in einem Array.
             *
             * Wir könnten hierfür auch eine Schleife verwenden aber die str_split/array_sum Kombination könnte auch als
             * Einzeiler geschrieben werden und ist daher ziemlich elegant:
             *
             * $crossSum = array_sum(str_split($productsString);
             */
            $crossSum = array_sum($productsStringDigits);

            /**
             * Wenn Ziffernsumme module 10 genau 0 ergibt, dann ist die Kreditkartennummer valide
             * (s. obenstehender Link)
             */
            if ($crossSum % 10 !== 0) {
                $errors['creditcard'] = "Bitte geben Sie eine valide Kreditkartennummer ein";
            }
        } else {
            $errors['creditcard'] = "Ihre Kreditkartennummer ist zu kurz";
        }
    }

    // END: KREDITKARTENNUMMER

    if (isset($_POST['country'])/* && $_POST['country'] !== '_default'*/) {
        $country = $_POST['country'];
        $allowedOptions = require 'countries.php';

        if (!array_key_exists($country, $allowedOptions)) {
            $errors['country'] = "Bitte wählen Sie ein Land aus";
        }
    }

    if (!isset($_POST['agb']) || $_POST['agb'] !== 'on') {
        $errors['agb'] = "Sie müssen die AGB akzeptieren";
    }

}

<?php

namespace App\Controllers;

use App\Models\User;
use Core\Helpers\Config;
use Core\Session;
use Core\View;

class AuthController
{

    /**
     * Es werden zwei verschieden Funktionen benötigt. Eine für das Login Formular und eine für den Login-Vorgang.
     */
    public function loginForm ()
    {
        /**
         * Ist ein Account bereits eingeloggt und braucht sich daher nicht nochmal einloggen?
         */
        if (User::isLoggedIn()) {
            /**
             * User Daten aus DB laden.
             */
            $user = User::getLoggedInUser();

            /**
             * Je nachdem ob der Account ein Admin ist oder nicht, leiten wir wo anders hin.
             */
            $redirectUrl = 'home';
            if ($user->is_admin === true) {
                $redirectUrl = 'dashboard';
            }

            header("Location: $redirectUrl");
            exit;
        } else {
            /**
             * Wenn kein Account eingeloggt ist, laden wir das Login Formular und übergeben die Fehler, die beim
             * Login-Vorgang aufgetreten sein könnten (merke Konjunktiv), an den View. Hier verwenden wir den
             * $forgetAfterReturn Parameter der Session::get Methode.
             */
            View::load('login', [
                'errors' => Session::get('errors', [], true),
            ]);
        }
    }

    public function login ()
    {
        /**
         * Ist ein Account bereits eingeloggt und braucht sich daher nicht nochmal einloggen?
         */
        if (User::isLoggedIn()) {
            $user = User::getLoggedInUser();

            $redirectUrl = 'home';
            if ($user->is_admin === true) {
                $redirectUrl = 'dashboard';
            }

            header("Location: $redirectUrl");
            exit;
        } else {
            /**
             * $errors vorbereiten.
             */
            $errors = [];

            /**
             * Sind Email und Passwort aus dem Formular übergeben worden?
             */
            if (isset($_POST['email']) && isset($_POST['password'])) {
                /**
                 * Aliases definieren
                 */
                $email = $_POST['email'];
                $passwordFromForm = $_POST['password'];

                /**
                 * Account anhand der eingegebenen Email-Adresse aus der DB laden
                 */
                $user = User::findByEmail($email);

                /**
                 * Ein Objekt wir auf den Bool'schen Wert true konvertiert, daher können wir nur $user in die if-Klammern
                 * schreiben.
                 *
                 * Wenn ein $user zur eingegeben Email-Adresse gefunden wurde UND das Passwort übereinstimmt, leiten wir
                 * weiter, sonst schreiben wir einen Fehler.
                 */
                if ($user && $user->checkPassword($passwordFromForm)) {
                    $redirectUrl = 'home';

                    if ($user->is_admin === true) {
                        $redirectUrl = 'dashboard';
                    }

                    $user->login($redirectUrl);
                } else {
                    $errors[] = "Benutzer existiert nicht oder Passwort ist falsch.";
                }
            } else {
                if (!isset($_POST['email'])) {
                    $errors[] = "Bitte geben Sie eine Email-Adresse ein.";
                }

                if (!isset($_POST['password'])) {
                    $errors[] = "Bitte geben Sie ein Passwort ein.";
                }
            }

            /**
             * Fehler in die Session speichern, weil mit dem Redirect der Request endet und $errors gelöscht wird. Wir
             * möchten aber im Login-Formular, auf das wir weiterleiten, die Fehler noch ausgeben können.
             */
            Session::set('errors', $errors);
            header("Location: login");
            exit;
        }
    }

    public function logout ()
    {
        /**
         * Account ausloggen und weiterleiten
         */
        User::logout("home");
    }

}

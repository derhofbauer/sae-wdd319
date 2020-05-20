<?php

namespace App\Controllers;

use App\Models\User;
use Core\Helpers\Config;
use Core\Helpers\Validator;
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

    /**
     * Zeigt das Registrierungsformular, wenn aktuell noch kein User eingeloggt ist.
     * Nähere Erklärung zur Logik in der AuthController::loginForm()
     */
    public function signupForm ()
    {
        if (User::isLoggedIn()) {
            $user = User::getLoggedInUser();

            $redirectUrl = 'home';
            if ($user->is_admin === true) {
                $redirectUrl = 'dashboard';
            }

            header("Location: $redirectUrl");
            exit;
        } else {
            View::load('signup', [
                'errors' => Session::get('errors', [], true),
            ]);
        }
    }

    /**
     * Nimmt die Formulardaten aus dem Registrierungsformular entgegen.
     */
    public function signup ()
    {
        // var_dump($_POST);
        $baseUrl = Config::get('app.baseUrl');

        /**
         * Daten validieren
         */
        $validator = new Validator();
        $validator->validate($_POST['firstname'], 'Firstname', true, 'text', 2, 255);
        $validator->validate($_POST['lastname'], 'Lastname', true, 'text', 2, 255);
        $validator->validate($_POST['email'], 'Email', true, 'email');
        $validator->validate($_POST['password'], 'Passwort', true, 'password');
        $validator->compare($_POST['password'], $_POST['password2']);

        /**
         * Fehler aus dem Validator holen
         */
        $errors = $validator->getErrors();

        /**
         * Wenn Validierungsfehler aufgetreten sind, speichern wir die Fehler zur späteren Anzeige in die Session und
         * leiten zurück zum Registrierungsformular, wo die Fehler aus der Session angezeigt werden.
         */
        if ($errors !== false) {
            Session::set('errors', $errors);
            header("Location: $baseUrl/sign-up");
            exit;
        }

        /*
         * @todo: CONTINUE HERE!
         */

    }

}

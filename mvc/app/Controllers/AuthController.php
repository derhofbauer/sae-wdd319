<?php

namespace App\Controllers;

use App\Models\User;
use Core\Helpers\Config;
use Core\Helpers\Validator;
use Core\Libs\PHPMailer;
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

    /**
     * In der Angabe steht, dass die der Login serverseitig validiert werden soll. Das macht allerdings überhaupt keinen
     * Sinn. Es macht nur Sinn hier den Benutzernamen zu validieren, damit kein MySQL Query abgeschickt wird, wenn von
     * Vorn herein klar ist, dass kein User gefunden werden wird (bspw. wenn die Email-Adresse als Username verwendet
     * wird und keine gültige Adresse eingegeben wird). Genauso für das Passwort. Ist klar, dass es nicht zutreffen
     * wird, weil es die Anforderungen nicht erfüllt, die bei der Registrierung forciert werden, dann kann ein MySQL
     * Query eingespart werden. Es wird aber mit großer Wahrscheinlichkeit zu inkonsistenzen kommen, wenn die Passwort
     * Regeln sich ändern oder im Admin Bereich ein Passwort zurückgesetzt wird und da andere Regeln angewendet werden,
     * weil unsauber programmiert wurde. Fazit: eine Validierung hat hier winzige Performance Verbesserungen, macht aber
     * vermutlich mehr Probleme als sie löst.
     */
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
         * Nachdem die eingegebenen Daten nun Validiert sind, möchten wir wissen, ob die Email-Adresse schon in unserer
         * Datenbank existiert oder nicht. Dazu nutzen wir die findByEmail-Methode der User Klasse, die wir extra so
         * gebaut haben, dass sie false zurück gibt, wenn kein Eintrag gefunden wurde. Existiert die Email-Adresse schon
         * und kann somit nicht mehr verwendet werden, geben wir einen Fehler aus.
         */
        if (User::findByEmail($_POST['email']) !== false) {
            $errors[] = "Diese Email-Adresse wird bereits verwendet.";
        }

        /**
         * Wenn Validierungsfehler aufgetreten sind, speichern wir die Fehler zur späteren Anzeige in die Session und
         * leiten zurück zum Registrierungsformular, wo die Fehler aus der Session angezeigt werden.
         */
        if (!empty($errors)) {
            Session::set('errors', $errors);
            header("Location: $baseUrl/sign-up");
            exit;
        }

        /**
         * Wenn kein Validierungsfehler auftritt, wollen wir den Account speichern
         */
        $user = new User();
        $user->firstname = $_POST['firstname'];
        $user->lastname = $_POST['lastname'];
        $user->email = $_POST['email'];
        $user->setPassword($_POST['password']);
        $user->save();

        /**
         * Hier müssten wir eigentlich Fehler, die beim Speichern in die Datenbank auftreten könnten, handeln. Wir
         * werden aber für Übersichtichkeit und Einfachheit darauf verzichten.
         */

        /**
         * Die PHPMailer Klasse ist eine externe Klasse, die wir als Anbieter von dem MVC für unsere Anwender
         * mitliefern. Sie unterstützt mehrere Methoden Emails zu verschicken, mehr dazu in der Dokumentation:
         * https://github.com/PHPMailer/PHPMailer
         *
         * Grundsätzlich werdet ihr am Anfang eurer Developer-Karriere selbst keine Emails verschicken müssen sondern
         * über das verwendete Framework (bspw. Laravel) Emails zusammenbauen.
         *
         * Zum Testen von Emails bieten sich dienste wie Ethereal an, die genau dafür entwickelt wurden:
         * https://ethereal.email/
         */
        if (PHPMailer::ValidateAddress($user->email)) {
            $mail = new PHPMailer();
            $mail->isMail();
            $mail->AddAddress($user->email);
            $mail->SetFrom('no-reply@mvc-sae.at');
            $mail->Subject = 'Herzlich Wilkommen!';
            $mail->Body = 'Sie haben sich erfolgreich registriert!\n\rDanke dafür! :*';

            $mail->Send();

            header("Location: $baseUrl/login");
            exit;
        } else {
            /**
             * Erkennt PHPMailer keine gültige Email-Adresse, müsste hier ein besserer Fehler ausgegeben werden. Wir
             * könnten beispielsweise einen eigenen Fehler-View bauen (ähnlich wie 404.view.php), werden das aber
             * vorerst einmal noch nicht machen und uns auf die wesentlicheren Dinge konzentrieren.
             */
            die('PHPMailer Error');
        }
    }

}

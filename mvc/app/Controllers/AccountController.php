<?php

namespace App\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Core\Helpers\Config;
use Core\Session;
use Core\View;

class AccountController
{

    /**
     * Liste der eigenen Orders anzeigen.
     */
    public function orders ()
    {
        /**
         * Ist ein User eingeloggt?
         */
        if (User::isLoggedIn()) {
            /**
             * Eingeloggten User aus der Datenbank abfragen.
             */
            $user = User::getLoggedInUser();

            /**
             * Alle Orders dieses einen Users laden.
             */
            $orders = Order::findByUser($user->id);

            /**
             * View laden und abgefragte Orders übergeben.
             */
            View::load('account-orders', [
                'orders' => $orders
            ]);
        } else {
            /**
             * Ist kein User eingeloggt, leiten wir auf den Login weiter.
             */
            header("Location: login");
        }
    }

    /**
     * Formular zur Account-Bearbeitung anzeigen.
     */
    public function editForm ()
    {
        /**
         * Ist ein User eingeloggt?
         */
        if (User::isLoggedIn()) {
            /**
             * Eingeloggten User aus der Datenbank abfragen.
             */
            $user = User::getLoggedInUser();

            /**
             * View laden und User übergeben.
             */
            View::load('account-edit', [
                'user' => $user
            ]);
        } else {
            /**
             * Ist kein User eingeloggt, leiten wir auf den Login weiter.
             */
            header("Location: login");
        }
    }

    /**
     * Daten aus Account Bearbeitungsformular entgegennehmen und speichern.
     */
    public function edit ()
    {
        if (User::isLoggedIn()) {
            /**
             * Aus Gründen der Übersichtlichkeit verzichten wir hier auf eine Datenvalidierung. Die Validierung würde
             * analog zur Validierung während des Registrierungsprozesses ablaufen.
             */

            /**
             * Eingeloggten User aus der Datenbank abfragen.
             */
            $user = User::getLoggedInUser();

            /**
             * Eigenschaften des eingeloggten Users mit Formulardaten überschreiben
             */
            $user->firstname = trim($_POST['firstname']);
            $user->lastname = trim($_POST['lastname']);
            $user->email = trim($_POST['email']);

            /**
             * Passwort nur dann überschreiben, wenn beide Passwort Felder gesetzt und ident sind.
             */
            if (
                !empty($_POST['password']) &&
                !empty($_POST['password2']) &&
                $_POST['password'] == $_POST['password2']
            ) {
                /**
                 * Die setPassword()-Methode generiert direkt einen Passwort Hash.
                 */
                $user->setPassword($_POST['password']);
            }

            /**
             * User in die DB speichern.
             */
            $user->save();

            /**
             * Erfolgsmeldung in die Session schreiben.
             */
            Session::set('flash', 'Success! :D');

            /**
             * Redirect.
             */
            $baseUrl = Config::get('app.baseUrl');
            header("Location: {$baseUrl}account");
        } else {
            /**
             * Ist kein User eingeloggt, leiten wir auf den Login weiter.
             */
            header("Location: login");
        }
    }

}

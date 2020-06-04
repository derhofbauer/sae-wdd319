<?php

namespace App\Controllers;

use App\Models\User;
use Core\Helpers\Config;
use Core\Session;
use Core\View;

class AdminAccountController
{

    /**
     * Alle Accounts in einer Liste anzeigen.
     */
    public function list ()
    {
        /**
         * Ist ein User eingeloggt und ist er Admin?
         */
        if (User::isLoggedIn() && User::getLoggedInUser()->is_admin === true) {

            /**
             * Alle User aus der Datenbank laden.
             */
            $users = User::all();

            /**
             * View laden und User übergeben.
             */
            View::load('admin/users', [
                'users' => $users
            ]);
        } else {
            /**
             * Ist kein Admin User eingeloggt, leiten wir auf den Login weiter.
             */
            header("Location: login");
        }
    }

    /**
     * Formular zur Bearbeitung eines Accounts als Admin
     *
     * @param int $id
     */
    public function editForm (int $id)
    {
        /**
         * Ist ein User eingeloggt und ist er Admin?
         */
        if (User::isLoggedIn() && User::getLoggedInUser()->is_admin === true) {

            /**
             * User aus der Datenbank laden.
             */
            $user = User::find($id);

            /**
             * View laden und User übergeben.
             */
            View::load('admin/account-edit', [
                'user' => $user
            ]);
        } else /**
         * Ist kein Admin User eingeloggt, leiten wir auf den Login weiter.
         */ {
            header("Location: login");
        }
    }

    /**
     * Daten aus Bearbeitungsformular entegegennehmen und verarbeiten.
     *
     * @param int $id
     */
    public function edit (int $id)
    {
        /**
         * Ist ein User eingeloggt und ist er Admin?
         */
        if (User::isLoggedIn() && User::getLoggedInUser()->is_admin === true) {
            /**
             * Aus Gründen der Übersichtlichkeit verzichten wir hier auf eine Datenvalidierung. Die Validierung würde
             * analog zur Validierung während des Registrierungsprozesses ablaufen.
             */

            /**
             * Angefragten User aus der Datenbank abfragen.
             */
            $user = User::find($id);

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
             * Wenn die isAdmin-Checkbox im Formular angehakerlt ist, dann soll $user->is_admin true sein, sonst false.
             */
            $user->is_admin = (isset($_POST['isAdmin']) && $_POST['isAdmin'] === 'on') ? true : false;

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
            header("Location: {$baseUrl}dashboard/accounts");

        } else /**
         * Ist kein Admin User eingeloggt, leiten wir auf den Login weiter.
         */ {
            header("Location: login");
        }
    }

    /**
     * Bestätigung, ob die Löschung eines Accounts wirklich durchgeführt werden soll.
     *
     * @param int $id
     */
    public function deleteForm (int $id)
    {
        /**
         * Ist ein User eingeloggt und ist er Admin?
         */
        if (User::isLoggedIn() && User::getLoggedInUser()->is_admin === true) {

            /**
             * User, der gelöscht werden soll, aus der Datenbank holen, damit wir im View eine spezifische Frage
             * formulieren können.
             */
            $user = User::find($id);

            /**
             * View laden und zu löschenden User übergeben.
             */
            View::load('admin/confirm-user-delete', [
                'user' => $user
            ]);
        } else {
            /**
             * Ist kein Admin User eingeloggt, leiten wir auf den Login weiter.
             */
            header("Location: login");
        }
    }

    /**
     * Account nach Bestätiung wirklich löschen.
     *
     * @param int $id
     */
    public function delete (int $id)
    {
        /**
         * Ist ein User eingeloggt und ist er Admin?
         */
        if (User::isLoggedIn() && User::getLoggedInUser()->is_admin === true) {

            /**
             * Ein Model sollte alles, was es selbst betrifft, können. Daher kann das Model ein Objekt des eigenen Typs
             * löschen.
             */
            User::delete($id);

            /**
             * Redirect.
             */
            $baseUrl = Config::get('app.baseUrl');
            header("Location: {$baseUrl}dashboard/accounts");

        } else {
            /**
             * Ist kein Admin User eingeloggt, leiten wir auf den Login weiter.
             */
            header("Location: login");
        }
    }

}

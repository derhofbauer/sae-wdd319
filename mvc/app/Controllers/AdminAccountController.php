<?php

namespace App\Controllers;

use App\Models\User;
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

}

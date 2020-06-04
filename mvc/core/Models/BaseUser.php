<?php

namespace Core\Models;

use App\Models\User;
use Core\Database;
use Core\Session;

/**
 * Der BaseUser Trait dient dazu, allgemein Funktionalitäten, bspw. für den Login, für die Anwender*innen unseres MVC
 * bereitzustellen, damit gängige Funktionalitäten nicht jedes Mal selbst programmiert werden müssen.
 *
 * @package Core\Models
 */
trait BaseUser
{
    protected $password = '';
    public $id = 0;
    public static $tableName = 'users';
    /**
     * Die $softDelete Property steuert, ob ein Model Soft Deletes unterstützt oder nicht. Wenn die Property existiert
     * und true ist, dann gehen die all() und die delete() Methode des ModelTraits davon aus, dass Soft Deletes von dem
     * Model verwendet werden und passen sich an.
     *
     * @var bool
     */
    public static $softDelete = true;

    /**
     * Stimmt das Passwort aus dem Login Formular mit dem Hash in der Datenbank überein?
     *
     * @param string $password Password from Login Form
     *
     * @return bool
     */
    public function checkPassword (string $password): bool
    {
        /**
         * verify_password wird von PHP mitgeliefert.
         */
        return password_verify($password, $this->password);
    }

    /**
     * Nachdem das Passwort gehashed werden muss, bevor es in die Datenbank gespeichert werden kann, sollten wir es
     * nicht direkt setzen sondern bieten hier eine Methode dafür an.
     *
     * @param string $plainPassword
     */
    public function setPassword (string $plainPassword)
    {
        /**
         * Die password_hash Methode unterstützt ein paar Hash-Algorithmen. Die PHP Konstanten PASSWORD_DEFAULT und
         * PASSWORD_BCRYPT verwenden aber beide BCrypt mit dem Blowfish Algorithmus. Das ist aktuell ein sehr guter und
         * sicherer Algorithmus.
         */
        $this->password = password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    /**
     * Loggt einen Account ein
     *
     * @param string $redirect
     *
     * @return bool
     */
    public function login (string $redirect = '')
    {
        /**
         * Login Status und User ID in die Session speichern.
         *
         * Wir verwenden hier die Session-Konstanten, weil wir dadurch den Wert, der hinter der Session-Konstante liegt
         * ganz einfach ändern können. Nach dem Grundsatz "wenn ein Wert mehr als 1x verwendet wird, sollte eine
         * Variable erstellt werden".
         */
        Session::set(Session::LOGGED_IN_KEY, true);
        Session::set(Session::LOGGED_IN_ID, $this->id);

        /**
         * Wenn ein $redirect Pfad gesetzt ist, leiten wir hier weiter.
         */
        if (strlen($redirect) > 0) {
            header("Location: $redirect");
            exit;
        } else {
            return true;
        }
    }

    /**
     * Loggt einen Account aus
     *
     * @param string $redirect
     *
     * @return bool
     */
    public static function logout (string $redirect = '')
    {
        /**
         * Login Status und User ID auf die Werte für "ausgeloggt" setzen.
         */
        Session::set(Session::LOGGED_IN_KEY, false);
        Session::forget(Session::LOGGED_IN_ID);

        if (strlen($redirect) > 0) {
            header("Location: $redirect");
            exit;
        } else {
            return true;
        }
    }

    /**
     * Prüft, ob ein Account eingeloggt ist
     *
     * @return mixed|null
     */
    public static function isLoggedIn ()
    {
        return Session::get(Session::LOGGED_IN_KEY, false);
    }

    /**
     * Gibt den aktuell eingeloggten Account zurück
     *
     * @return bool|object
     */
    public static function getLoggedInUser ()
    {
        /**
         * Auslesen der ID des potentiell eingeloggten Users
         */
        $userId = Session::get(Session::LOGGED_IN_ID, null);

        /**
         * Wenn eine User ID in der Session steht, dann laden wir die zugehörigen Daten aus der Datenbank.
         */
        if ($userId !== null) {
            return User::find($userId);
        }
        return false;
    }

    /**
     * Während des Login müssen Accounts anhand der Benutzerkennung, also beispielsweise Username oder Email, abgerufen
     * werden können.
     *
     * @param string $email
     *
     * @return bool|BaseUser
     */
    public static function findByEmail (string $email)
    {
        $db = new Database();

        $tableName = self::$tableName;
        $result = $db->query("SELECT * FROM {$tableName} WHERE email = ?", [
            's:email' => $email
        ]);

        /**
         * Damit wir die findByEmail Methode auch dazu verwenden können zu prüfen, ob ein Account mit einer bestimmten
         * Mail-Adresse schon existiert oder nicht, geben wir false zurück, wenn kein Treffer zur $email gefunden wurde.
         * Das ist grade im Registrierungsprozess enorm hilfreich, weil wir dann keine eigene Funktion schreiben müssen.
         */
        if (count($result) === 0) {
            return false;
        }

        $data = new self($result[0]);

        return $data;
    }

}

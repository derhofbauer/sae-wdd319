<?php

/**
 * Wenn ein User bereits eingeloggt ist, leiten wir direkt weiter, wenn nicht, prüfen wir, ob wir Daten aus dem Login
 * Formular erhalten haben und versuchen den User einzuloggen, oder zeigen ihm das Login Formular, wenn wir keine Daten
 * erhalten haben.
 */
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    $errors = [];

    /**
     * Haben wir Daten aus dem Login Formular erhalten?
     */
    if (isset($_POST['email']) && isset($_POST['password'])) {

        /**
         * Abfragen aller User mit der eingegeben Email-Adresse aus der Datenbank
         */
        $query = sprintf("SELECT * FROM users WHERE email = '%s'", $_POST['email']); // "SELECT * FROM users WHERE email = 'arthur.dent@galaxy.com'"
        $result = mysqli_query($link, $query);

        /**
         * Wenn wir ein leeres Result-Set zurück bekommen, also keine Ergebnisse aus dem Query, dann existiert kein
         * Datensatz zur eingegebenen Email-Adresse und wir zeigen einen Fehler an.
         */
        if (mysqli_num_rows($result) > 0) {

            $result = mysqli_fetch_assoc($result);

            $passwordInput = $_POST['password'];
            $passwordHashFromDb = $result['password'];

            /**
             * Prüfen, ob der eingegeben Wert für das Passwort mit dem Wert, der in den Salted Hash in der Datenbank
             * verschlüsselt wurde, übereinstimmt. Wenn nein geben wir einen Fehler aus.
             */
            if (password_verify($passwordInput, $passwordHashFromDb)) {

                /**
                 * Session setzen, damit wir persistent vermerkt haben, dass ein User eingeloggt ist.
                 *
                 * Beim Logout werden wir $_SESSION['loggedIn'] auf false setzen oder den Key 'loggedIn' löschen.
                 */
                $_SESSION['loggedIn'] = true;

                /**
                 * Hier leiten wir zum Admin-Dashboard weiter.
                 */
                header('Location: index.php?page=dashboard');
                exit;

            } else {
                /**
                 * Wir geben den selben Fehler zurück, obwohl wir unterschiedliche Fehlerfälle haben, damit wir einem
                 * Brute-Forcer keine hilfreichen Informationen geben.
                 */
                $errors[] = "Benutzer existiert nicht oder Passwort ist falsch.";
            }
        } else {
            $errors[] = "Benutzer existiert nicht oder Passwort ist falsch.";
        }

        /**
         * Sind während des Login Prozesses Fehler aufgetreten und wurde der User somit nicht eingeloggt, zeigen wir
         * das Login Formular wieder an. Innerhalb des Login Formulars werden die Fehler aus $errors ausgegeben.
         */
        if (!empty($errors)) {
            require_once __DIR__ . '/../views/login.php';
        }

    } else {
        require_once __DIR__ . '/../views/login.php';
    }
} else {
    /**
     * Hier leiten wir zum Admin-Dashboard weiter, weil der User bereits eingeloggt war und trotzdem das Login
     * Formular aufgerufen hat.
     */
    header('Location: index.php?page=dashboard');
    exit;
}

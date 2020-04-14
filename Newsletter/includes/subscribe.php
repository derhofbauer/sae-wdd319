<?php

/**
 * Validation ...
 *
 * + prüfen ob Email eingegeben wurde, sonst Fehler
 * + prüfen ob mind. 1 Topic ausgewählt wurde, sonst Fehler
 */

$errors = [];

/**
 * Schlägt die Validierung fehl, kommen wir hier gar nicht her!
 */
if (isset($_POST['firstname'], $_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['lastname'])) {

    /**
     * Aliases definieren
     */
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    /**
     * Query vorbereiten: String, den wir an die Datenbank schicken werden
     */
    $query = sprintf(
        "INSERT INTO subscribers SET email = '%s', firstname = '%s', lastname = '%s'",
        $email, $firstname, $lastname
    );

} else {

    /**
     * Aliases definieren
     */
    $email = $_POST['email'];

    /**
     * Query vorbereiten: String, den wir an die Datenbank schicken werden
     */
    $query = sprintf("INSERT INTO subscribers SET email = '%s'", $email);

}

/**
 * Query an Datenbank schicken & ausführen
 *
 * $link wird in der includes/database.php erzeugt und in der /index.php geladen und ist somit "global" verfügbar.
 */
$result = mysqli_query($link, $query);
if ($result === false) {
    $errors[] = (mysqli_errno($link) . ': ' . mysqli_error($link));
}

if (empty($errors)) {

    /**
     * MySQL erzeugt bei A_I Spalten immer einen neuen Wert bei INSERT-Queries. Diesen fragen wir ab, um sie in den nächsten
     * Queries verwenden zu können.
     */
    $result = mysqli_query($link, "SELECT id FROM subscribers WHERE email = '$email'");
    $result = mysqli_fetch_assoc($result);
    $insertedSubscriberId = $result['id'];

    /**
     * Subscriptions in Mapping-Tabelle eintragen
     */
    foreach ($_POST['topics'] as $topicId => $on) {

        $query = sprintf(
            "INSERT INTO subscribers_topics_mm SET subscriber_id = '%d', topic_id = '%d'",
            $insertedSubscriberId,
            $topicId
        );

        $result = mysqli_query($link, $query);
        if ($result === false) {
            $errors[] = (mysqli_errno($link) . ': ' . mysqli_error($link));
        }

    }
}

var_dump($errors);
